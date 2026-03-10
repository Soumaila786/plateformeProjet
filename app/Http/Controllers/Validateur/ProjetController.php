<?php

namespace App\Http\Controllers\Validateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
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
            ->where('statutProjet', 'approuve');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                    ->orWhere('codeProjet', 'like', "%{$search}%");
            });
        }

        $projets = $query->latest()->paginate(10);
        return view('validateur.projets.index', compact('projets'));
    }

    public function show(Projet $projet)
    {
        $projet->load(['porteur', 'secteur', 'planifications', 'documents.uploader', 'commentaires.utilisateur']);
        return view('validateur.projets.show', compact('projet'));
    }

    public function mesProjets(Request $request)
    {
        $projets = Projet::with(['porteur', 'secteur'])
            ->whereIn('statutProjet', ['valide', 'rejete', 'approuve'])
            ->latest()->paginate(10);
        return view('validateur.projets.mes-projets', compact('projets'));
    }

    // ── Valider ──
    public function valider(Request $request, Projet $projet)
    {
        $request->validate([
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $projet->update([
            'statutProjet'   => 'valide',
            'dateValidation' => now(),
        ]);

        // Commentaire si observation
        if ($request->filled('commentaire')) {
            Commentaire::create([
                'message'         => $request->commentaire,
                'typeCommentaire' => 'approbation',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);
        }

        // Notification au porteur
        NotificationService::notifierPorteur(
            $projet,
            'Félicitations ! Votre projet « ' . $projet->titre . ' » a été validé définitivement.',
            'validation'
        );

        // Notification aux admins
        NotificationService::notifierAdmins(
            'Le projet « ' . $projet->titre . ' » (' . $projet->codeProjet . ') a été validé par le validateur ' . Auth::user()->nomComplet . '.',
            'validation',
            $projet->id
        );

        return redirect()->route('validateur.projets.show', $projet)
                            ->with('success', 'Projet validé avec succès.');
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

        // Commentaire de rejet (observation)
        Commentaire::create([
            'message'         => 'Rejet validation : ' . $request->motifRejet,
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

        // Notification au porteur
        $msgPorteur = $statutFinal === 'brouillon'
            ? 'Votre projet « ' . $projet->titre . ' » a été retourné pour modification après examen de validation. Motif : ' . $request->motifRejet
            : 'Votre projet « ' . $projet->titre . ' » a été rejeté lors de la validation. Motif : ' . $request->motifRejet;

        NotificationService::notifierPorteur($projet, $msgPorteur, 'rejet');

        // Notification aux approbateurs
        NotificationService::notifierApprobateurs(
            'Le projet « ' . $projet->titre . ' » a été rejeté lors de la validation par ' . Auth::user()->nomComplet . '.',
            'rejet',
            $projet->id
        );

        return redirect()->route('validateur.projets.show', $projet)
                            ->with('success', 'Projet rejeté.');
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
