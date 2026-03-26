<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Activite;
use App\Models\Commentaire;
use App\Models\DocumentProjet;
use App\Models\SecteurActivite;
use App\Services\NotificationService;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller{

    protected $mailService;

    public function __construct(MailService $mailService){
        $this->mailService = $mailService;
    }

    public function index(Request $request){
    $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();

    $query = Projet::with(['secteur', 'porteur'])
        ->whereIn('statutProjet', ['soumis', 'en_examen', 'approuve', 'rejete']);

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

    $projets = $query->orderBy('updated_at', 'desc')->paginate(10);

    return view('approbateur.projets.index', compact('projets', 'secteurs'));
}

public function mesProjets(Request $request){
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

    $projets = $query->orderBy('updated_at', 'desc')->paginate(10);

    // Motif rejet depuis commentaires
    $projets->getCollection()->transform(function ($projet) {
        $projet->motifRejet = null;
        if ($projet->statutProjet === 'rejete') {
            $com = \App\Models\Commentaire::where('projet_id', $projet->id)
                ->where('typeCommentaire', 'rejet')
                ->latest('dateEnvoi')
                ->first();
            $projet->motifRejet = $com ? $com->message : null;
        }
        return $projet;
    });

    return view('approbateur.projets.mes_projets', compact('projets', 'secteurs'));
}


    public function show(Projet $projet){

        $projet->load(['porteur', 'secteur', 'activites', 'documents.uploader', 'commentaires.utilisateur']);
        return view('approbateur.projets.show', compact('projet'));
    }

    // public function mesProjets(Request $request){

    //     $query = Projet::with(['secteur', 'porteur'])
    //         ->where('approbateur_id', Auth::id());

    //     if ($request->filled('statut')) {
    //         $query->where('statutProjet', $request->statut);
    //     }

    //     if ($request->filled('search')) {
    //         $s = $request->search;
    //         $query->where(function($q) use ($s) {
    //             $q->where('titre', 'like', '%'.$s.'%')
    //                 ->orWhere('codeProjet', 'like', '%'.$s.'%');
    //         });
    //     }

    //     $projets = $query->orderBy('updated_at', 'desc')->paginate(10);

    //     return view('approbateur.projets.mes_projets', compact('projets'));
    // }

    // ── Mettre en examen ──
    public function examiner(Projet $projet){
        $projet->update([
            'statutProjet' => 'en_examen',
            'approbateur_id' => Auth::id()
            ]);

        NotificationService::notifierPorteur(
            $projet,
            'Votre projet « ' . $projet->titre . ' » est en cours d\'examen par un approbateur.',
            'statut_change'
        );

        return redirect()->route('approbateur.projets.show', $projet)
                            ->with('success', 'Projet mis en examen.');
    }

    // ── Approuver ──
    public function approuver(Request $request, Projet $projet){

        $request->validate([
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $projet->update([
            'statutProjet'    => 'approuve',
            'dateApprobation' => now(),
            'approbateur_id' => Auth::id()
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

        // Pour projet approuvé
        $this->mailService->envoyerProjetApprouve($projet);

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
    }

    // ── Rejeter ──
    public function rejeter(Request $request, Projet $projet){
        $request->validate([
            'motifRejet'          => 'required|string|max:1000',
            'messageModification' => 'nullable|string|max:1000',
        ]);

        $statutFinal = $request->filled('messageModification') ? 'brouillon' : 'rejete';

        $commentaire = Commentaire::create([
            'message'         => 'Rejet : ' . $request->motifRejet,
            'typeCommentaire' => 'rejet',
            'dateEnvoi'       => now(),
            'projet_id'       => $projet->id,
            'utilisateur_id'  => Auth::id(),
        ]);

        $projet->update([
            'statutProjet'        => $statutFinal,
            'messageModification' => $request->messageModification,
            'approbateur_id'      => Auth::id(),
            'commentaire_id'      => $commentaire->id
        ]);

        if ($request->filled('messageModification')) {
            Commentaire::create([
                'message'         => 'Demande de modification : ' . $request->messageModification,
                'typeCommentaire' => 'demande',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);
        }

        $msgPorteur = $statutFinal === 'brouillon'
            ? 'Votre projet « ' . $projet->titre . ' » a été retourné en brouillon pour modification. Motif : ' . $request->motifRejet
            : 'Votre projet « ' . $projet->titre . ' » a été rejeté. Motif : ' . $request->motifRejet;


       // Envoyer l'email avec le commentaire
        $this->mailService->envoyerProjetRejete($projet, $commentaire);

        NotificationService::notifierPorteur($projet, $msgPorteur, 'rejet');

        return redirect()->route('approbateur.projets.show', $projet)
                            ->with('success', 'Projet rejeté.');
    }

    // ── Changer statut d'une activité planifiée ──
    public function changerStatutActivite(Request $request, Projet $projet, Activite $activites){
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

        // Notifier le porteur si l'activité est financée
        if ($request->statutActivite === 'financee') {
            NotificationService::notifierPorteur(
                $projet,
                'L\'activité « ' . $activites->activite . ' » de votre projet « ' . $projet->titre . ' » a été marquée comme financée.',
                'approbation'
            );
        }

        return back()->with('success', 'Statut de l\'activité mis à jour : ' . ($labels[$request->statutActivite] ?? ''));
    }

    public function downloadDocument(Projet $projet, DocumentProjet $document){
        $path = storage_path('app/public/' . $document->cheminFichier);
        if (!file_exists($path)) {
            return back()->with('error', 'Fichier introuvable.');
        }
        return response()->download($path, $document->nomFichier);
    }
}
