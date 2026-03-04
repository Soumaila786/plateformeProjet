<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\DocumentProjet;
use App\Models\SecteurActivite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjetController extends Controller
{
    // ── Liste ──
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

        $projets = $query->latest()->paginate(15);

        return view('admin.projets.index', compact('projets'));
    }

    // ── Formulaire création ──
    public function create()
    {
        $secteurs = SecteurActivite::where('statutSecteur', true)->get();
        $porteurs = User::where('role', 'porteur')->get();
        return view('admin.projets.create', compact('secteurs', 'porteurs'));
    }

    // ── Enregistrer ──
    public function store(Request $request)
    {
        $request->validate([
            'titre'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'objectif'       => 'nullable|string',
            'secteur_id'     => 'required|exists:secteur_activites,id',
            'user_id'        => 'required|exists:users,id',
            'budgetTotal'    => 'required|numeric|min:0',
            'montantDemande' => 'nullable|numeric|min:0',
            'duree'          => 'nullable|integer|min:1',
            'dateDebut'      => 'nullable|date',
            'dateFin'        => 'nullable|date|after_or_equal:dateDebut',
            'statutProjet'   => 'required|in:brouillon,soumis,en_examen,approuve,valide,rejete',
            'documents.*'    => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
            'typeDocument'   => 'nullable|string',
        ]);

        $projet = Projet::create([
            'codeProjet'     => 'PRJ-' . date('Y') . '-' . str_pad(Projet::count() + 1, 3, '0', STR_PAD_LEFT),
            'titre'          => $request->titre,
            'description'    => $request->description,
            'objectif'       => $request->objectif,
            'secteur_id'     => $request->secteur_id,
            'user_id'        => $request->user_id,
            'budgetTotal'    => $request->budgetTotal,
            'montantDemande' => $request->montantDemande,
            'duree'          => $request->duree,
            'dateDebut'      => $request->dateDebut,
            'dateFin'        => $request->dateFin,
            'statutProjet'   => $request->statutProjet,
            'dateCreation'   => now(),
        ]);

        // Upload des documents
        $this->uploadDocuments($request, $projet);

        return redirect()->route('projets.show', $projet)
                        ->with('success', 'Projet créé avec succès.');
    }

    // ── Détail ──
    public function show(Projet $projet)
    {
        $projet->load(['porteur', 'secteur', 'planifications', 'documents.uploader', 'commentaires']);
        return view('admin.projets.show', compact('projet'));
    }

    // ── Formulaire édition ──
    public function edit(Projet $projet)
    {
        $secteurs = SecteurActivite::where('statutSecteur', true)->get();
        $porteurs = User::where('role', 'porteur')->get();
        $projet->load('documents');
        return view('admin.projets.edit', compact('projet', 'secteurs', 'porteurs'));
    }

    // ── Mettre à jour ──
    public function update(Request $request, Projet $projet)
    {
        $request->validate([
            'titre'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'objectif'       => 'nullable|string',
            'secteur_id'     => 'required|exists:secteur_activites,id',
            'user_id'        => 'required|exists:users,id',
            'budgetTotal'    => 'required|numeric|min:0',
            'montantDemande' => 'nullable|numeric|min:0',
            'duree'          => 'nullable|integer|min:1',
            'dateDebut'      => 'nullable|date',
            'dateFin'        => 'nullable|date|after_or_equal:dateDebut',
            'statutProjet'   => 'required|in:brouillon,soumis,en_examen,approuve,valide,rejete',
            'documents.*'    => 'nullable|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
            'typeDocument'   => 'nullable|string',
        ]);

        $projet->update([
            'titre'          => $request->titre,
            'description'    => $request->description,
            'objectif'       => $request->objectif,
            'secteur_id'     => $request->secteur_id,
            'user_id'        => $request->user_id,
            'budgetTotal'    => $request->budgetTotal,
            'montantDemande' => $request->montantDemande,
            'duree'          => $request->duree,
            'dateDebut'      => $request->dateDebut,
            'dateFin'        => $request->dateFin,
            'statutProjet'   => $request->statutProjet,
        ]);

        // Upload des nouveaux documents
        $this->uploadDocuments($request, $projet);

        return redirect()->route('projets.show', $projet)
                        ->with('success', 'Projet mis à jour avec succès.');
    }


    // ── Supprimer projet ──
    public function destroy(Projet $projet)
    {
        // Supprimer les fichiers physiques
        foreach ($projet->documents as $doc) {
            Storage::disk('public')->delete($doc->cheminFichier);
        }

        $projet->delete();

        return redirect()->route('projets.index')
                        ->with('success', 'Projet supprimé avec succès.');
    }

    // ── Supprimer un document ──
    public function destroyDocument(Projet $projet, DocumentProjet $document)
    {
        Storage::disk('public')->delete($document->cheminFichier);
        $document->delete();

        return back()->with('success', 'Document supprimé.');
    }

    // ── Télécharger un document ──
    public function downloadDocument(Projet $projet, DocumentProjet $document)
    {
        return Storage::disk('public')->download(
            $document->cheminFichier,
            $document->nomFichier
        );
    }


    // ── Changer le statut ──
    public function changerStatut(Request $request, Projet $projet)
    {
        $request->validate([
            'statut' => 'required|in:brouillon,soumis,en_examen,approuve,valide,rejete',
        ]);

        $projet->update([
            'statutProjet'   => $request->statut,
            'dateSoumission' => $request->statut === 'soumis' ? now() : $projet->dateSoumission,
        ]);

        $labels = [
            'soumis'   => 'soumis pour examen',
            'approuve' => 'approuvé',
            'valide'   => 'validé',
            'rejete'   => 'rejeté',
        ];

        return redirect()->route('projets.show', $projet)
                         ->with('success', 'Projet ' . ($labels[$request->statut] ?? 'mis à jour') . ' avec succès.');
    }

    // ── Helper upload ──
    private function uploadDocuments(Request $request, Projet $projet)
    {
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $chemin = $file->store("projets/{$projet->id}/documents", 'public');

                DocumentProjet::create([
                    'nomFichier'    => $file->getClientOriginalName(),
                    'typeDocument'  => $request->typeDocument ?? 'autre',
                    'cheminFichier' => $chemin,
                    'dateUpload'    => now(),
                    'projet_id'     => $projet->id,
                    'uploader_id'   => Auth::id(),
                ]);
            }
        }
    }
}
