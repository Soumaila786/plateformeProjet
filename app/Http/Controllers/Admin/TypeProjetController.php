<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeProjet;
use Illuminate\Http\Request;

class TypeProjetController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()->can('configurations.gerer'), 403);
    }

    public function index()
    {
        $this->authorizeAdmin();
        $types = TypeProjet::withCount('projets')->orderBy('nom')->get();
        return view('types-projets.index', compact('types'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'nom' => 'required|string|max:255|unique:types_projets,nom',
            'description' => 'nullable|string|max:1000',
        ]);
        TypeProjet::create(array_merge($data, ['actif' => true]));
        return back()->with('success', 'Type de projet créé avec succès.');
    }

    public function update(Request $request, TypeProjet $typeProjet)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'nom' => 'required|string|max:255|unique:types_projets,nom,' . $typeProjet->id,
            'description' => 'nullable|string|max:1000',
        ]);
        $typeProjet->update($data);
        return back()->with('success', 'Type de projet mis à jour.');
    }

    public function toggleStatus(TypeProjet $typeProjet)
    {
        $this->authorizeAdmin();
        $typeProjet->update(['actif' => !$typeProjet->actif]);
        return back()->with('success', $typeProjet->actif ? 'Type activé.' : 'Type désactivé.');
    }

    public function destroy(TypeProjet $typeProjet)
    {
        $this->authorizeAdmin();
        if ($typeProjet->projets()->exists()) {
            return back()->with('error', 'Impossible de supprimer un type utilisé par des projets. Désactivez-le plutôt.');
        }
        $typeProjet->delete();
        return back()->with('success', 'Type de projet supprimé.');
    }
}
