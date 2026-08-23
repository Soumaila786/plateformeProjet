<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Activite;
use App\Models\Commentaire;
use App\Models\MotifRejet;
use App\Models\DocumentProjet;
use App\Models\SecteurActivite;
use App\Services\NotificationService;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\Projet\ProjetService;


class ProjetController extends Controller {

    protected $mailService;

    public function __construct(MailService $mailService){
        $this->mailService = $mailService;
    }

    public function index(Request $request) {

        try{

            $secteurs = SecteurActivite::where('statutSecteur', true)
                                        ->orderBy('nomSecteur')
                                        ->get();

            $query = Projet::with(['secteur', 'porteur'])
                            ->whereIn('statutProjet',
                            ['soumis', 'en_examen', 'approuve', 'rejete']);

            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('titre', 'like', '%'.$s.'%')
                        ->orWhere('codeProjet', 'like', '%'.$s.'%');
                });
            }

            if ($request->filled('statut')) {
                $query->where('statutProjet', $request->statut);
            }

            if ($request->filled('secteur_id')) {
                $query->where('secteur_id', $request->secteur_id);
            }

            $projets = $query->orderBy('updated_at', 'desc')->paginate(4);

            $motifsDisponibles = MotifRejet::actifs()->orderBy('libelle')->get();

            return view('projets.index', compact('projets', 'secteurs', 'motifsDisponibles'));

        }catch(\Exception $e){

            Log::error('Erreur lors du chargement des projets (Approbateur)', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    public function mesProjets(Request $request){
        try{

            $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();

            $query = Projet::with(['secteur', 'porteur'])
                ->where('approbateur_id', Auth::id());

            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('titre', 'like', '%'.$s.'%')
                        ->orWhere('codeProjet', 'like', '%'.$s.'%');
                });
            }

            if ($request->filled('statut')) {
                $query->where('statutProjet', $request->statut);
            }

            if ($request->filled('secteur_id')) {
                $query->where('secteur_id', $request->secteur_id);
            }

            $projets = $query->orderBy('updated_at', 'desc')->paginate(4);

            $projets->getCollection()->transform(function ($projet) {
                $projet->motifRejet = null;
                if ($projet->statutProjet === 'rejete') {
                    $com = Commentaire::where('projet_id', $projet->id)
                        ->where('typeCommentaire', 'rejet')
                        ->latest('dateEnvoi')
                        ->first();
                    $projet->motifRejet = $com ? $com->message : null;
                }
                return $projet;
            });

            return view('approbateur.projets.mes_projets', compact('projets', 'secteurs'));

        }catch(\Exception $e){

            Log::error('Erreur lors du chargement des projets de l\'approbateur', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue ');
        }
    }


    public function show(Projet $projet){

        $this->authorize('view', $projet);

        // Motifs actifs pour alimenter les cases à cocher (rejet / demande de modification)
        $motifsDisponibles = MotifRejet::actifs()->orderBy('libelle')->get();

        $projet->load([
            'porteur', 'secteur', 'activites',
            'documents.uploader',
            'commentaires.utilisateur',
            'commentaires.motifs',
        ]);

        return view('projets.show', compact('projet', 'motifsDisponibles'));
    }

    // Mettre en examen
    public function examiner(Projet $projet){

        $this->authorize('examiner', $projet);

        try{

            $projet->update([
                'statutProjet' => 'en_examen',
                'approbateur_id' => Auth::id()
            ]);

            NotificationService::notifierPorteur(
                $projet,
                'Votre projet « ' . $projet->titre . ' » est en cours d\'examen par un approbateur.',
                'statut_change'
                );

            Log::notice('Projet mis en examen', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'approbateur_id' => Auth::id(),
                'ip' => request()->ip()
            ]);
            return redirect()->route('approbateur.projets.show', $projet)
                ->with('success', 'Projet mis en examen.');

        }catch(\Exception $e){

            Log::error('Erreur lors de la mise en examen du projet', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue ');
        }
    }

    // Approuver
    public function approuver(Request $request, Projet $projet){

        $this->authorize('approuver', $projet);

        try{

            $request->validate([
                'commentaire' => 'nullable|string|max:1000',
            ]);

            $projet->update([
                'statutProjet'    => 'approuve',
                'dateApprobation' => now(),
                'approbateur_id' => Auth::id()
            ]);
            Log::notice('Projet approuvé', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'approbateur_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            if ($request->filled('commentaire')) {

                Commentaire::create([
                    'message'         => $request->commentaire,
                    'typeCommentaire' => 'approbation',
                    'dateEnvoi'       => now(),
                    'projet_id'       => $projet->id,
                    'utilisateur_id'  => Auth::id(),
                ]);
            }

            $this->mailService->envoyerProjetApprouve($projet);
            Log::info('Email d’approbation envoyé', [
                'projet_id' => $projet->id,
                'destinataire' => $projet->porteur->email ?? null
            ]);

            NotificationService::notifierPorteur(
                $projet,
                'Félicitations ! Votre projet « ' . $projet->titre . ' » a été approuvé et transmis pour validation.',
                'approbation'
            );

            NotificationService::notifierValidateurs(
                'Le projet « ' . $projet->titre . ' » (' . $projet->codeProjet . ') a été approuvé et est en attente de validation.',
                'approbation',
                $projet->id
            );

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('success', 'Projet approuvé.');

        }catch(\Exception $e){

            Log::error('Erreur lors de l’approbation du projet', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);
            return redirect()->route('approbateur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue ');
        }
    }

    // Rejeter — bouton 3 : liste de motifs à cocher (obligatoire) + commentaire libre (optionnel)
    public function rejeter(Request $request, Projet $projet){

        $this->authorize('rejeter', $projet);

        try{

            $request->validate([
                'motifs'            => 'required|array|min:1',
                'motifs.*'          => 'exists:motifs_rejet,id',
                'commentaire_libre' => 'nullable|string|max:1000',
            ]);

            $commentaire = Commentaire::create([
                'message'         => $request->commentaire_libre ?? '',
                'typeCommentaire' => 'rejet',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);
            $commentaire->motifs()->sync($request->motifs);

            $projet->update([
                'statutProjet'   => 'rejete',
                'approbateur_id' => Auth::id(),
            ]);

            $libelles = MotifRejet::whereIn('id', $request->motifs)->pluck('libelle')->implode(', ');
            $msgPorteur = 'Votre projet « ' . $projet->titre . ' » a été rejeté. Motif(s) : ' . $libelles
                . ($request->filled('commentaire_libre') ? ' — ' . $request->commentaire_libre : '');

            Log::warning('Projet rejeté', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'motifs' => $request->motifs,
                'approbateur_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            $this->mailService->envoyerProjetRejete($projet, $commentaire);
            Log::info('Email du rejet envoyé', [
                'projet_id' => $projet->id,
                'destinataire' => $projet->porteur->email ?? null
            ]);
            NotificationService::notifierPorteur($projet, $msgPorteur, 'rejet');

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('success', 'Projet rejeté.');

        }catch(\Exception $e){
            Log::error('Erreur lors du rejet du projet', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);
            return redirect()->route('approbateur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue ');
        }
    }

    // Demande de modification — bouton 2 : liste de motifs à cocher (obligatoire) + commentaire libre (optionnel)
    // Renvoie le projet en brouillon pour que le porteur corrige, puis resoumette.
    public function demanderModification(Request $request, Projet $projet){

        $this->authorize('demandeModification', $projet);

        try{

            $request->validate([
                'motifs'            => 'required|array|min:1',
                'motifs.*'          => 'exists:motifs_rejet,id',
                'commentaire_libre' => 'nullable|string|max:1000',
            ]);

            $commentaire = Commentaire::create([
                'message'         => $request->commentaire_libre ?? '',
                'typeCommentaire' => 'demande',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);
            $commentaire->motifs()->sync($request->motifs);

            $projet->update([
                'statutProjet'   => 'brouillon',
                'approbateur_id' => Auth::id(),
            ]);

            $libelles = MotifRejet::whereIn('id', $request->motifs)->pluck('libelle')->implode(', ');
            $msgPorteur = 'Une modification est demandée sur votre projet « ' . $projet->titre . ' ». Motif(s) : ' . $libelles
                . ($request->filled('commentaire_libre') ? ' — ' . $request->commentaire_libre : '');

            Log::warning('Demande de modification envoyée par l’approbateur', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'motifs' => $request->motifs,
                'approbateur_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            NotificationService::notifierPorteur($projet, $msgPorteur, 'modification');

            return redirect()->route('approbateur.projets.index')
                ->with('success', 'Demande de modification envoyée au porteur.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la demande de modification', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);
            return redirect()->route('approbateur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue ');
        }
    }

    // Changer statut d'une activité planifiée
    public function changerStatutActivite(Request $request, Projet $projet, Activite $activites){

        $this->authorize('gererPlanification', $projet);

        try{

            $request->validate([
                'statutActivite' => 'required|in:en_attente,financee,en_cours,termine,annule',
            ]);

            $ancienStatut = $activites->statutActivite;
            $activites->update([
                'statutActivite' => $request->statutActivite
            ]);

            $labels = [
                'en_attente' => 'En attente',
                'financee'   => 'Financée',
                'en_cours'   => 'En cours',
                'termine'    => 'Terminée',
                'annule'     => 'Annulée',
            ];

            if ($request->statutActivite === 'financee') {
                NotificationService::notifierPorteur(
                    $projet,
                    'L\'activité « ' . $activites->activite . ' » de votre projet « ' . $projet->titre . ' » a été marquée comme financée.',
                    'approbation'
                    );
            }

            Log::notice('Changement de statut d’une activité', [
                'projet_id' => $projet->id,
                'activite_id' => $activites->id,
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => $request->statutActivite,
                'approbateur_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return back()->with('success', 'Statut de l\'activité mis à jour : ' . ($labels[$request->statutActivite] ?? ''));

        }catch(\Exception $e){
            Log::error('Erreur lors du changement de statut d’une activité', [
                'activite_id' => $activites->id ?? null,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    public function downloadDocument(Projet $projet, DocumentProjet $document){

        $this->authorize('view', $projet);

        $path = storage_path('app/public/' . $document->cheminFichier);

        if (!file_exists($path)) {
            Log::warning('Fichier de projet introuvable', [
                'document_id' => $document->id,
                'chemin' => $document->cheminFichier,
                'user_id' => Auth::id()
            ]);
            return back()->with('error', 'Fichier introuvable.');
        }

        Log::info('Téléchargement d’un document de projet', [
            'document_id' => $document->id,
            'projet_id' => $projet->id,
            'user_id' => Auth::id(),
            'ip' => request()->ip()
        ]);

        return response()->download($path, $document->nomFichier);
    }
}
