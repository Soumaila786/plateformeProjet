<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\DocumentProjet;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjetController extends Controller
{
    public function index(Request $request)
    {
        $query = Projet::with(['porteur', 'secteur']);

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

        $projets = $query->latest()->paginate(12);

        return view('admin.projets.index', compact('projets'));
    }

    public function show(Projet $projet)
    {
        $projet->load(['porteur', 'secteur', 'planifications', 'documents.uploader', 'commentaires.utilisateur']);
        return view('admin.projets.show', compact('projet'));
    }

    public function destroy(Projet $projet)
    {
        $titre = $projet->titre;

        foreach ($projet->documents as $doc) {
            Storage::disk('public')->delete($doc->cheminFichier);
        }
        $projet->delete();

        return redirect()->route('admin.projets.index')
                        ->with('success', 'Projet supprimé avec succès.');
    }

    public function changerStatut(Request $request, Projet $projet)
    {
        $request->validate([
            'statut' => 'required|in:brouillon,soumis,en_examen,approuve,valide,rejete',
        ]);

        $ancienStatut = $projet->statutProjet;
        $projet->update(['statutProjet' => $request->statut]);

        $labels = [
            'brouillon' => 'Brouillon', 'soumis'    => 'Soumis',
            'en_examen' => 'En examen', 'approuve'  => 'Approuvé',
            'valide'    => 'Validé',    'rejete'     => 'Rejeté',
        ];

        // Notification au porteur
        NotificationService::notifierPorteur(
            $projet,
            'Le statut de votre projet « ' . $projet->titre . ' » a été modifié de « ' . ($labels[$ancienStatut] ?? $ancienStatut) . ' » à « ' . ($labels[$request->statut] ?? $request->statut) . ' » par l\'administrateur.',
            'statut_change'
        );

        return redirect()->route('admin.projets.show', $projet)
                            ->with('success', 'Statut mis à jour.');
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
