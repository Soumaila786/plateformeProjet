<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // Crée les utilisateurs de test en premier (ex: l'admin)
            UserSeeder::class,

            RolesAndPermissionsSeeder::class,
            MotifsRejetSeeder::class,

            // Doit tourner APRÈS UserSeeder, puisqu'elle assigne les rôles Spatie
            // aux utilisateurs déjà créés.
            AssignRolesToExistingUsersSeeder::class,
        ]);
    }
}
