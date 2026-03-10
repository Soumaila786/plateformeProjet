<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ── Liste ──
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomComplet', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('actif')) {
            $query->where('actif', $request->actif === '1');
        }

        $users = $query->latest('created_at')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    // ── Formulaire création ──
    public function create()
    {
        return view('admin.users.create');
    }

    // ── Enregistrer ──
    public function store(Request $request)
    {
        $request->validate([
            'nomComplet'  => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'role'        => 'required|in:admin,porteur,approbateur,validateur',
            'motDePasse'  => 'required|string|min:8|confirmed',
            'telephone'   => 'nullable|string|max:20',
            'organisation'=> 'nullable|string|max:255',
        ]);

        User::create([
            'nomComplet'   => $request->nomComplet,
            'email'        => $request->email,
            'role'         => $request->role,
            'motDePasse'   => Hash::make($request->motDePasse),
            'telephone'    => $request->telephone,
            'organisation' => $request->organisation,
            'actif'        => true,
            'dateCreation' => now(),
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    // ── Détail ──
    public function show(User $user)
    {
        $user->load('projets');
        return view('admin.users.show', compact('user'));
    }

    // ── Formulaire édition ──
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // ── Mettre à jour ──
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nomComplet'   => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'role'         => 'required|in:admin,porteur,approbateur,validateur',
            'telephone'    => 'nullable|string|max:20',
            'organisation' => 'nullable|string|max:255',
            'motDePasse'   => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nomComplet'   => $request->nomComplet,
            'email'        => $request->email,
            'role'         => $request->role,
            'telephone'    => $request->telephone,
            'organisation' => $request->organisation,
        ];

        if ($request->filled('motDePasse')) {
            $data['motDePasse'] = Hash::make($request->motDePasse);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // ── Supprimer ──
    public function destroy(User $user)
    {
        if ($user->projets()->count() > 0) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Impossible de supprimer un utilisateur ayant des projets.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur supprimé.');
    }

    // ── Activer / Désactiver ──
    public function toggleStatus(User $user)
    {
        $user->update(['actif' => !$user->actif]);

        $msg = $user->actif ? 'Compte activé.' : 'Compte désactivé.';

        return back()->with('success', $msg);
    }
}
