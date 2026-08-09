<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AssignRolesToExistingUsersSeeder extends Seeder {
    /**
     * Assigne à chaque utilisateur son rôle Spatie, basé sur sa colonne `role`
     * actuelle (enum). Ne touche pas à la colonne `role` elle-même — elle reste
     * en place pour l'instant (voir note dans User.php), seule la source de
     * vérité pour les permissions change.
     */
    public function run() {

        User::whereDoesntHave('roles')->get()->each(function (User $user) {
            if ($user->role) {
                $user->assignRole($user->role);
            }
        });
    }
}
