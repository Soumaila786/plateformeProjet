<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Seul l'admin peut gérer les utilisateurs
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, User $target)
    {
        return $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, User $target)
    {
        // Admin peut modifier n'importe qui
        // Un utilisateur peut modifier son propre profil
        return $user->role === 'admin' || $user->id === $target->id;
    }

    public function delete(User $user, User $target)
    {
        // Admin peut supprimer mais pas son propre compte
        return $user->role === 'admin' && $user->id !== $target->id;
    }

    public function toggleStatus(User $user, User $target)
    {
        return $user->role === 'admin' && $user->id !== $target->id;
    }
}
