<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Planification;
use App\Models\Commentaire;
use App\Models\DocumentProjet;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    public function index(Request $request)
    {
        $query = Projet::with(['porteur', 'secteur'])
            ->whereIn('statutProjet', ['soumis', 'en_examen']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('codeProjet', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statutProjet', $request->statut);
        }

        $projets = $query->latest()->paginate(10);
        return view('approbateur.projets.index', compact('projets'));
    }

    public function show(Projet $projet)
    {
        $projet->load(['porteur', 'secteur', 'planifications', 'documents.uploader', 'commentaires.utilisateur']);
        return view('approbateur.projets.show', compact('projet'));
    }

    public function mesProjets(Request $request)
    {
        $projets = Projet::with(['porteur', 'secteur'])
            ->whereIn('statutProjet', ['approuve', 'rejete', 'en_examen', 'valide'])
            ->latest()->paginate(10);
        return view('approbateur.projets.mes-projets', compact('projets'));
    }

    // ── Mettre en examen ──
    public function examiner(Projet $projet)
    {
        $projet->update(['statutProjet' => 'en_examen']);

        NotificationService::notifierPorteur(
            $projet,
            'Votre projet « ' . $projet->titre . ' » est en cours d\'examen par un approbateur.',
            'statut_change'
        );

        return redirect()->route('approbateur.projets.show', $projet)
                         ->with('success', 'Projet mis en examen.');
    }

    // ── Approuver ──
    public function approuver(Request $request, Projet $projet)
    {
        $request->validate([
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $projet->update([
            'statutProjet'    => 'approuve',
            'dateApprobation' => now(),
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
    public function rejeter(Request $request, Projet $projet)
    {
        $request->validate([
            'motifRejet'          => 'required|string|max:1000',
            'messageModification' => 'nullable|string|max:1000',
        ]);

        $statutFinal = $request->filled('messageModification') ? 'brouillon' : 'rejete';

        $projet->update([
            'statutProjet'        => $statutFinal,
            'motifRejet'          => $request->motifRejet,
            'messageModification' => $request->messageModification,
        ]);

        Commentaire::create([
            'message'         => 'Rejet : ' . $request->motifRejet,
            'typeCommentaire' => 'rejet',
            'dateEnvoi'       => now(),
            'projet_id'       => $projet->id,
            'utilisateur_id'  => Auth::id(),
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

        NotificationService::notifierPorteur($projet, $msgPorteur, 'rejet');

        return redirect()->route('approbateur.projets.show', $projet)
                            ->with('success', 'Projet rejeté.');
    }

    // ── Changer statut d'une activité planifiée ──
    public function changerStatutActivite(Request $request, Projet $projet, Planification $planification)
    {
        $request->validate([
            'statutActivite' => 'required|in:en_attente,financee,en_cours,termine,annule',
        ]);

        $ancienStatut = $planification->statutActivite;
        $planification->update(['statutActivite' => $request->statutActivite]);

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
                'L\'activité « ' . $planification->activite . ' » de votre projet « ' . $projet->titre . ' » a été marquée comme financée.',
                'approbation'
            );
        }

        return back()->with('success', 'Statut de l\'activité mis à jour : ' . ($labels[$request->statutActivite] ?? ''));
    }

    public function downloadDocument(Projet $projet, DocumentProjet $document)
    {
        $path = storage_path('app/public/' . $document->cheminFichier);
        if (!file_exists($path)) {
            return back()->with('error', 'Fichier introuvable.');
        }
        return response()->download($path, $document->nomFichier);
    }
}
