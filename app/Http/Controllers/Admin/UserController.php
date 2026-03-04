<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Approbateur;
use App\Models\Validateur;
use App\Models\Porteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //Afficher la liste des utilisateurs
    public function index(){
        $users = User::orderBy('created_at', 'desc')->get();
        $totalUsers = User::count();
        return view('admin.users.index', compact('users', 'totalUsers'));
    }

    //Afficher le formulaire de création
    public function create(){ return view('admin.users.create'); }

    //Enregistrer un nouvel utilisateur
    public function store(Request $request){
        // Règles de validation de base
        $rules = [
            'nomComplet' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matricule' => 'nullable|string|unique:users,matricule',
            'fonction' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
            'role' => 'required|in:admin,approbateur,validateur,porteur',
            'password' => 'required|string|min:8|confirmed',
            'actif' => 'nullable|boolean'
        ];

        // Ajouter les règles selon le rôle choisi
        if ($request->role == 'admin') {
            $rules['datePriseFonction'] = 'nullable|date';
        } elseif ($request->role == 'approbateur') {
            $rules['service'] = 'nullable|string|max:255';
            $rules['poste'] = 'nullable|string|max:255';
        } elseif ($request->role == 'validateur') {
            $rules['dateDebutMandat'] = 'nullable|date';
            $rules['dateFinMandat'] = 'nullable|date|after_or_equal:dateDebutMandat';
        } elseif ($request->role == 'porteur') {
            $rules['structure'] = 'nullable|string|max:255';
            $rules['specialite'] = 'nullable|string|max:255';
        }

        // Valider les données
        $validated = $request->validate($rules);

        // Utiliser une transaction pour créer l'utilisateur et ses données spécifiques
        try {
            DB::beginTransaction();

            // Créer l'utilisateur de base
            $user = User::create([
                'nomComplet' => $validated['nomComplet'],
                'email' => $validated['email'],
                'matricule' => $validated['matricule'] ?? null,
                'fonction' => $validated['fonction'] ?? null,
                'contact' => $validated['contact'] ?? null,
                'role' => $validated['role'],
                'motDePasse' => Hash::make($validated['password']),
                'dateCreation' => now(),
                'actif' => $request->has('actif')
            ]);

            // Ajouter les données spécifiques selon le rôle
            if ($request->role == 'admin') {
                Admin::create([
                    'user_id' => $user->id,
                    'datePriseFonction' => $request->datePriseFonction
                ]);
            } elseif ($request->role == 'approbateur') {
                Approbateur::create([
                    'user_id' => $user->id,
                    'service' => $request->service,
                    'poste' => $request->poste
                ]);
            } elseif ($request->role == 'validateur') {
                Validateur::create([
                    'user_id' => $user->id,
                    'dateDebutMandat' => $request->dateDebutMandat,
                    'dateFinMandat' => $request->dateFinMandat
                ]);
            } elseif ($request->role == 'porteur') {
                Porteur::create([
                    'user_id' => $user->id,
                    'structure' => $request->structure,
                    'specialite' => $request->specialite
                ]);
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur créé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création : ' . $e->getMessage());
        }
    }


    // Voir les details d'un utilisateur spécçfique
    public function show(User $user){
        // Charger les relations selon le rôle
        if ($user->role == 'admin') {
            $user->load('admin');
        } elseif ($user->role == 'approbateur') {
            $user->load('approbateur');
        } elseif ($user->role == 'validateur') {
            $user->load('validateur');
        } elseif ($user->role == 'porteur') {
            $user->load('porteur');
        }

        return view('admin.users.show', compact('user'));
    }


    // Ouvrir le formulaire pour la modification
    public function edit(User $user){
        // Charger les relations selon le rôle
        if ($user->role == 'admin') {
            $user->load('admin');
        } elseif ($user->role == 'approbateur') {
            $user->load('approbateur');
        } elseif ($user->role == 'validateur') {
            $user->load('validateur');
        } elseif ($user->role == 'porteur') {
            $user->load('porteur');
        }

        return view('admin.users.edit', compact('user'));
    }


    // Mis à jour d'un utilisateur
    public function update(Request $request, User $user){
        // Règles de validation de base
        $rules = [
            'nomComplet' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'matricule' => 'nullable|string|unique:users,matricule,' . $user->id,
            'fonction' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
            'motDePasse' => 'nullable|string|min:8|confirmed',
            'actif' => 'nullable|boolean'
        ];

        // Ajouter les règles selon le rôle (en utilisant le rôle existant de l'utilisateur)
        if ($user->role == 'admin') {
            $rules['datePriseFonction'] = 'nullable|date';
        } elseif ($user->role == 'approbateur') {
            $rules['service'] = 'nullable|string|max:255';
            $rules['poste'] = 'nullable|string|max:255';
        } elseif ($user->role == 'validateur') {
            $rules['dateDebutMandat'] = 'nullable|date';
            $rules['dateFinMandat'] = 'nullable|date|after_or_equal:dateDebutMandat';
        } elseif ($user->role == 'porteur') {
            $rules['structure'] = 'nullable|string|max:255';
            $rules['specialite'] = 'nullable|string|max:255';
        }

        // Valider les données
        $validated = $request->validate($rules);

        // Utiliser une transaction pour mettre à jour
        try {
            DB::beginTransaction();

            // Préparer les données de base
            $userData = [
                'nomComplet' => $validated['nomComplet'],
                'email' => $validated['email'],
                'matricule' => $validated['matricule'] ?? null,
                'fonction' => $validated['fonction'] ?? null,
                'contact' => $validated['contact'] ?? null,
                'actif' => $request->has('actif')
            ];

            // Mettre à jour le mot de passe seulement si fourni
            if ($request->filled('password')) {
                $userData['motDePasse'] = Hash::make($validated['password']);
            }

            // Mettre à jour l'utilisateur
            $user->update($userData);

            // Mettre à jour les données spécifiques selon le rôle
            if ($user->role == 'admin') {
                if ($user->admin) {
                    $user->admin->update([
                        'datePriseFonction' => $request->datePriseFonction
                    ]);
                } else {
                    Admin::create([
                        'user_id' => $user->id,
                        'datePriseFonction' => $request->datePriseFonction
                    ]);
                }
            } elseif ($user->role == 'approbateur') {
                if ($user->approbateur) {
                    $user->approbateur->update([
                        'service' => $request->service,
                        'poste' => $request->poste
                    ]);
                } else {
                    Approbateur::create([
                        'user_id' => $user->id,
                        'service' => $request->service,
                        'poste' => $request->poste
                    ]);
                }
            } elseif ($user->role == 'validateur') {
                if ($user->validateur) {
                    $user->validateur->update([
                        'dateDebutMandat' => $request->dateDebutMandat,
                        'dateFinMandat' => $request->dateFinMandat
                    ]);
                } else {
                    Validateur::create([
                        'user_id' => $user->id,
                        'dateDebutMandat' => $request->dateDebutMandat,
                        'dateFinMandat' => $request->dateFinMandat
                    ]);
                }
            } elseif ($user->role == 'porteur') {
                if ($user->porteur) {
                    $user->porteur->update([
                        'structure' => $request->structure,
                        'specialite' => $request->specialite
                    ]);
                } else {
                    Porteur::create([
                        'user_id' => $user->id,
                        'structure' => $request->structure,
                        'specialite' => $request->specialite
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur mis à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
        }
    }

    // Supprimer un utilisateur
    public function destroy(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        try {
            DB::beginTransaction();

            // Supprimer les données spécifiques selon le rôle
            if ($user->role == 'admin' && $user->admin) {
                $user->admin->delete();
            } elseif ($user->role == 'approbateur' && $user->approbateur) {
                $user->approbateur->delete();
            } elseif ($user->role == 'validateur' && $user->validateur) {
                $user->validateur->delete();
            } elseif ($user->role == 'porteur' && $user->porteur) {
                $user->porteur->delete();
            }

            // Supprimer l'utilisateur
            $user->delete();

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur supprimé avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleStatus(User $user)
    {
        // Empêcher la désactivation de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier le statut de votre propre compte.');
        }

        $user->update([
            'actif' => !$user->actif
        ]);

        $status = $user->actif ? 'activé' : 'désactivé';

        return redirect()->route('admin.users.index')
            ->with('success', "Compte utilisateur {$status} avec succès.");
    }

    /**
     * Attribuer un rôle à un utilisateur (si besoin)
     */
    public function attribuerRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,approbateur,validateur,porteur'
        ]);

        // Empêcher la modification de son propre rôle
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        // Si le rôle change, on doit gérer les données spécifiques
        if ($user->role !== $request->role) {
            try {
                DB::beginTransaction();

                // Supprimer les anciennes données spécifiques
                if ($user->role == 'admin' && $user->admin) {
                    $user->admin->delete();
                } elseif ($user->role == 'approbateur' && $user->approbateur) {
                    $user->approbateur->delete();
                } elseif ($user->role == 'validateur' && $user->validateur) {
                    $user->validateur->delete();
                } elseif ($user->role == 'porteur' && $user->porteur) {
                    $user->porteur->delete();
                }

                // Mettre à jour le rôle
                $user->update(['role' => $request->role]);

                DB::commit();

                return redirect()->route('admin.users.index')
                    ->with('success', 'Rôle modifié avec succès. Veuillez compléter les informations spécifiques.');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('admin.users.index')
                    ->with('error', 'Une erreur est survenue lors du changement de rôle.');
            }
        }

        return redirect()->route('admin.users.index')
            ->with('info', 'Le rôle est déjà celui sélectionné.');
    }

    // Dans app/Http/Controllers/Admin/UserController.php
    private function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return substr($initials, 0, 2); // Prendre les 2 premières initiales
    }

    private function getRoleLabel($role)
    {
        $labels = [
            'admin' => 'Administrateur',
            'approbateur' => 'Approbateur',
            'validateur' => 'Validateur',
            'porteur' => 'Porteur de projet'
        ];
        return $labels[$role] ?? $role;
    }
}
