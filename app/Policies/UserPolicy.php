<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy {

    public function viewAny(User $user) {
        return $user->can('utilisateurs.gerer');
    }

    public function view(User $user, User $target) {
        return $user->can('utilisateurs.gerer');
    }

    public function create(User $user) {
        return $user->can('utilisateurs.gerer');
    }

    public function update(User $user, User $target) {
        // Gestion complète, ou modification de son propre profil
        return $user->can('utilisateurs.gerer') || $user->id === $target->id;
    }

    public function delete(User $user, User $target) {
        return $user->can('utilisateurs.gerer') && $user->id !== $target->id;
    }

    public function toggleStatus(User $user, User $target) {
        return $user->can('utilisateurs.gerer') && $user->id !== $target->id;
    }
}
