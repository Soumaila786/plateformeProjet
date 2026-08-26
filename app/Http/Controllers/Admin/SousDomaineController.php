<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecteurActivite;
use App\Models\SousDomaine;
use Illuminate\Http\Request;

class SousDomaineController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()->can('configurations.gerer'), 403);
    }

    public function index()
    {
        $this->authorizeAdmin();
        $sousDomaines = SousDomaine::with('secteur')->withCount('projets')->orderBy('nom')->get();
        $secteurs = SecteurActivite::orderBy('nomSecteur')->get();
        return view('sous-domaines.index', compact('sousDomaines', 'secteurs'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'secteur_id' => 'required|exists:secteur_activites,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        if (SousDomaine::where('secteur_id', $data['secteur_id'])->where('nom', $data['nom'])->exists()) {
            return back()->withInput()->with('error', 'Ce sous-domaine existe déjà dans ce secteur.');
        }
        SousDomaine::create(array_merge($data, ['actif' => true]));
        return back()->with('success', 'Sous-domaine créé avec succès.');
    }

    public function update(Request $request, SousDomaine $sousDomaine)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'secteur_id' => 'required|exists:secteur_activites,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
        $exists = SousDomaine::where('secteur_id', $data['secteur_id'])
            ->where('nom', $data['nom'])->where('id', '!=', $sousDomaine->id)->exists();
        if ($exists) {
            return back()->withInput()->with('error', 'Ce sous-domaine existe déjà dans ce secteur.');
        }
        $sousDomaine->update($data);
        return back()->with('success', 'Sous-domaine mis à jour.');
    }

    public function toggleStatus(SousDomaine $sousDomaine)
    {
        $this->authorizeAdmin();
        $sousDomaine->update(['actif' => !$sousDomaine->actif]);
        return back()->with('success', $sousDomaine->actif ? 'Sous-domaine activé.' : 'Sous-domaine désactivé.');
    }

    public function destroy(SousDomaine $sousDomaine)
    {
        $this->authorizeAdmin();
        if ($sousDomaine->projets()->exists()) {
            return back()->with('error', 'Impossible de supprimer un sous-domaine utilisé par des projets. Désactivez-le plutôt.');
        }
        $sousDomaine->delete();
        return back()->with('success', 'Sous-domaine supprimé.');
    }
}
