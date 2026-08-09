<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MotifRejetPolicy {

    use HandlesAuthorization;

    // Consultation de la liste (pour le picklist rejet/demande de modification)
    public function viewAny(User $user) {
        return $user->can('motifs.gerer')
            || $user->can('projets.rejeter')
            || $user->can('projets.demander_modification');
    }

    // Créer / modifier / supprimer / activer-désactiver un motif
    public function manage(User $user) {
        return $user->can('motifs.gerer');
    }
}
