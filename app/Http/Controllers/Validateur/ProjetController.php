<?php

namespace App\Http\Controllers\Validateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\SecteurActivite;
use App\Models\Commentaire;
use App\Models\MotifRejet;
use App\Services\MailService;
use App\Services\NotificationService;
use App\Services\Projet\ProjetWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjetController extends Controller {

    protected $mailService;
    protected $notifService;

    public function __construct(MailService $mailService, NotificationService $notifService) {
        $this->mailService  = $mailService;
        $this->notifService = $notifService;
    }

    // Liste A valider (avec recherche + filtre secteur)
    public function index(Request $request) {

        try{
            $secteurs = SecteurActivite::where('statutSecteur', true)
                                        ->orderBy('nomSecteur')->get();

            $query = Projet::with(['secteur', 'porteur'])
                            ->where('statutProjet', 'approuve');

            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('titre', 'like', '%'.$s.'%')
                        ->orWhere('codeProjet', 'like', '%'.$s.'%');
                });
            }

            if ($request->filled('secteur_id')) {
                $query->where('secteur_id', $request->secteur_id);
            }

            $projets = $query->orderBy('updated_at', 'asc')
                            ->paginate(4);

            return view('projets.index', compact('projets', 'secteurs'));

        }catch(\Exception $e){
            Log::error('Erreur lors du chargement des projets à valider', [
                'message' => $e->getMessage(),
                'validateur_id' => Auth::id(),
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue' );
        }

    }

    // Mes projets traités
    public function mesProjets(Request $request) {

        try{
            $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();

            $query = Projet::with(['secteur', 'porteur'])
                ->where('validateur_id', Auth::id());

            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('titre', 'like', '%'.$s.'%')
                        ->orWhere('codeProjet', 'like', '%'.$s.'%');
                });
            }

            if ($request->filled('secteur_id')) {
                $query->where('secteur_id', $request->secteur_id);
            }

            if ($request->filled('statut')) {
                $query->where('statutProjet', $request->statut);
            }

            $projets = $query->orderBy('dateValidation', 'desc')->paginate(10);

            $projets->getCollection()->transform(function ($p) {

                $p->motifRejet = null;

                if ($p->statutProjet === 'rejete') {

                    $com = Commentaire::where('projet_id', $p->id)
                        ->where('typeCommentaire', 'rejet')
                        ->latest('dateEnvoi')
                        ->first();

                    $p->motifRejet = $com ? $com->message : null;
                }
                return $p;
            });

            return view('validateur.projets.mes_projets', compact('projets', 'secteurs'));

        }catch(\Exception $e){
            Log::error('Erreur lors du chargement des projets validés', [
                'message' => $e->getMessage(),
                'validateur_id' => Auth::id(),
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue');
        }
    }

    // Détail d'un projet
    public function show(Projet $projet) {

        $this->authorize('view', $projet);

        // Motifs actifs pour alimenter les cases à cocher (rejet / demande de modification)
        $motifsDisponibles = MotifRejet::actifs()->orderBy('libelle')->get();

        $projet->load([
            'secteur',
            'porteur',
            'activites',
            'documents',
            'commentaires.utilisateur',
            'commentaires.motifs',
        ]);

        return view('projets.show', compact('projet', 'motifsDisponibles'));
    }

    // Valider (bouton 1)
    public function valider(Request $request, Projet $projet) {

        $this->authorize('valider', $projet);

        try{

            $request->validate([
                'commentaire' => 'nullable|string|max:1000',
            ]);

            if ($projet->statutProjet !== 'en_validation') {
                return back()->with('error', 'Ce projet ne peut pas être validé dans son état actuel.');
            }

            $projet->validateur_id  = Auth::id();
            $projet->dateValidation = now();
            $projet->save();
            app(ProjetWorkflowService::class)->transition($projet, Auth::user(), 'valide', 'Validation du projet');

            Log::notice('Validation d’un projet', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'titre' => $projet->titre,
                'validateur_id' => Auth::id(),
                'ip' => $request->ip(),
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

            NotificationService::notifierPorteur(
                $projet,
                'Félicitations ! Votre projet « '.$projet->titre.' » a été validé.',
                'validation'
            );

            $this->mailService->envoyerProjetValide($projet);
            Log::info('Email de validation envoyé', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'validateur_id' =>Auth::id()
            ]);

            return redirect()->route('validateur.projets.index')
                    ->with('success', 'Le projet « '.$projet->titre.' » a été validé avec succès.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la validation du projet', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'validateur_id' => Auth::id(),
            ]);
            return redirect()->back()
                    ->with('error', 'Une erreur est survenue ');
        }

    }

    // Rejeter (bouton 3) — liste de motifs à cocher (obligatoire) + commentaire libre (optionnel)
    // NOTE : après rejet, le projet est verrouillé définitivement (voir ProjetPolicy::update()).
    public function rejeter(Request $request, Projet $projet) {

        $this->authorize('rejeter', $projet);

        try {

            $request->validate([
                'motifs'            => 'required|array|min:1',
                'motifs.*'          => 'exists:motifs_rejet,id',
                'commentaire_libre' => 'nullable|string|max:1000',
            ]);

            if ($projet->statutProjet !== 'en_validation') {
                return back()->with('error', 'Ce projet ne peut pas être rejeté dans son état actuel.');
            }

            $commentaire = Commentaire::create([
                'message'         => $request->commentaire_libre ?? '',
                'typeCommentaire' => 'rejet',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);
            $commentaire->motifs()->sync($request->motifs);

            $projet->validateur_id  = Auth::id();
            $projet->dateValidation = now();
            $projet->save();
            app(ProjetWorkflowService::class)->transition($projet, Auth::user(), 'rejete', 'Rejet par le validateur', $commentaire->id);

            $libelles = MotifRejet::whereIn('id', $request->motifs)->pluck('libelle')->implode(', ');
            $msgPorteur = 'Votre projet « '.$projet->titre.' » a été rejeté par le validateur. Motif(s) : ' . $libelles
                . ($request->filled('commentaire_libre') ? ' — ' . $request->commentaire_libre : '');

            NotificationService::notifierPorteur($projet, $msgPorteur, 'rejet');

            Log::warning('Rejet d’un projet par le validateur', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'motifs' => $request->motifs,
                'validateur_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);

            return redirect()->route('validateur.projets.index')
                    ->with('success', 'Le projet a été rejeté.');

        }catch(\Exception $e){
            Log::error('Erreur lors du rejet du projet', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'validateur_id' => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    // Demande de modification (bouton 2) — renvoie le projet en brouillon
    public function demanderModification(Request $request, Projet $projet) {

        $this->authorize('demandeModification', $projet);

        try {

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

            $projet->update(['validateur_id' => Auth::id()]);
            app(ProjetWorkflowService::class)->transition($projet, Auth::user(), 'a_corriger', 'Demande de correction', $commentaire->id);

            $libelles = MotifRejet::whereIn('id', $request->motifs)->pluck('libelle')->implode(', ');
            $msgPorteur = 'Une modification est demandée sur votre projet « '.$projet->titre.' » par le validateur. Motif(s) : ' . $libelles
                . ($request->filled('commentaire_libre') ? ' — ' . $request->commentaire_libre : '');

            NotificationService::notifierPorteur($projet, $msgPorteur, 'modification');

            Log::warning('Demande de modification envoyée par le validateur', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'motifs' => $request->motifs,
                'validateur_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);

            return redirect()->route('validateur.projets.index')
                    ->with('success', 'Demande de modification envoyée au porteur.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la demande de modification (validateur)', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'validateur_id' => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue ');
        }
    }

}
