<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecteurActivite;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    /**
     * Afficher la liste des secteurs
     */
    public function index()
    {
        $secteurs = SecteurActivite::orderBy('nomSecteur')->get();
        $totalSecteurs = SecteurActivite::count();
        
        return view('admin.secteurs.index', compact('secteurs', 'totalSecteurs'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.secteurs.create');
    }

    /**
     * Enregistrer un nouveau secteur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomSecteur' => 'required|string|max:255|unique:secteur_activites',
            'description' => 'nullable|string',
            'statutSecteur' => 'nullable|boolean'
        ]);

        SecteurActivite::create([
            'nomSecteur' => $validated['nomSecteur'],
            'description' => $validated['description'] ?? null,
            'statutSecteur' => $request->has('statutSecteur')
        ]);

        return redirect()->route('admin.secteurs.index')
            ->with('success', 'Secteur créé avec succès.');
    }

    /**
     * Afficher les détails d'un secteur
     */
    public function show(SecteurActivite $secteur)
    {
        $secteur->load('projets');
        return view('admin.secteurs.show', compact('secteur'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(SecteurActivite $secteur)
    {
        return view('admin.secteurs.edit', compact('secteur'));
    }

    /**
     * Mettre à jour un secteur
     */
    public function update(Request $request, SecteurActivite $secteur)
    {
        $validated = $request->validate([
            'nomSecteur' => 'required|string|max:255|unique:secteur_activites,nomSecteur,' . $secteur->id,
            'description' => 'nullable|string',
            'statutSecteur' => 'nullable|boolean'
        ]);

        $secteur->update([
            'nomSecteur' => $validated['nomSecteur'],
            'description' => $validated['description'] ?? null,
            'statutSecteur' => $request->has('statutSecteur')
        ]);

        return redirect()->route('admin.secteurs.index')
            ->with('success', 'Secteur mis à jour avec succès.');
    }

    /**
     * Supprimer un secteur
     */
    public function destroy(SecteurActivite $secteur)
    {
        // Vérifier si le secteur a des projets associés
        if ($secteur->projets()->count() > 0) {
            return redirect()->route('admin.secteurs.index')
                ->with('error', 'Impossible de supprimer ce secteur car il est associé à des projets.');
        }

        $secteur->delete();

        return redirect()->route('admin.secteurs.index')
            ->with('success', 'Secteur supprimé avec succès.');
    }

    /**
     * Activer/Désactiver un secteur
     */
    public function toggleStatus(SecteurActivite $secteur)
    {
        $secteur->update([
            'statutSecteur' => !$secteur->statutSecteur
        ]);

        $status = $secteur->statutSecteur ? 'activé' : 'désactivé';

        return redirect()->route('admin.secteurs.index')
            ->with('success', "Secteur {$status} avec succès.");
    }
}
