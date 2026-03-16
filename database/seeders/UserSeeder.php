<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'nomComplet' => 'Admin Principal',
    'email' => 'admin@gmail.com',
    'matricule' => 'ADM001',
    'fonction' => 'Administrateur',
    'contact' => '70000000',
    'motDePasse' => Hash::make('password'),
    'role' => 'admin',
    'actif' => true,
    'dateCreation' => now()
]);