<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'nomComplet' => 'Admin Principal',
                'matricule' => 'ADM001',
                'fonction' => 'Administrateur',
                'contact' => '70000000',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'actif' => true,
            ]
        );
    }
}
