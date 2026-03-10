<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecteurActivite;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    public function index()
    {
        $secteurs = SecteurActivite::with('projets')->get();
        return view('admin.secteurs.index', compact('secteurs'));
    }

    public function create()
    {
        return view('admin.secteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomSecteur'  => 'required|string|max:255|unique:secteur_activites,nomSecteur',
            'description' => 'nullable|string|max:500',
        ]);

        SecteurActivite::create([
            'nomSecteur'  => $request->nomSecteur,
            'description' => $request->description,
            'statutSecteur'      => $request->has('statutSecteur'),
        ]);

        return redirect()->route('admin.secteurs.index')
                            ->with('success', 'Secteur créé avec succès.');
    }

    public function edit(SecteurActivite $secteur)
    {
        return view('admin.secteurs.edit', compact('secteur'));
    }

    public function update(Request $request, SecteurActivite $secteur)
    {
        $request->validate([
            'nomSecteur'  => 'required|string|max:255|unique:secteur_activites,nomSecteur,' . $secteur->id,
            'description' => 'nullable|string|max:500',
        ]);

        $secteur->update([
            'nomSecteur'  => $request->nomSecteur,
            'description' => $request->description,
            'statutSecteur'      => $request->has('statutSecteur'),
        ]);

        return redirect()->route('admin.secteurs.index')
                            ->with('success', 'Secteur mis à jour.');
    }

    public function destroy(SecteurActivite $secteur)
    {
        if ($secteur->projets()->count() > 0) {
            return redirect()->route('admin.secteurs.index')
                                ->with('error', 'Impossible de supprimer un secteur contenant des projets.');
        }

        $secteur->delete();

        return redirect()->route('admin.secteurs.index')
                            ->with('success', 'Secteur supprimé.');
    }

    public function toggleStatus(SecteurActivite $secteur)
    {
        $secteur->update(['statutSecteur' => !$secteur->statutSecteur]);
        $msg = $secteur->statutSecteur ? 'Secteur activé.' : 'Secteur désactivé.';
        return back()->with('success', $msg);
    }
}
