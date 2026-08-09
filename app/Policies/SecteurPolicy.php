<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SecteurPolicy {

    use HandlesAuthorization;

    // Consultation ouverte à tout utilisateur authentifié (formulaires de projet, tous rôles)
    public function viewAny(User $user) {
        return true;
    }

    // Gestion (create/update/delete/toggle) : permission dédiée
    public function manage(User $user) {
        return $user->can('secteurs.gerer');
    }
}
