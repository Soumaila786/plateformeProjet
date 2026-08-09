<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigurationDefaultsSeeder extends Seeder
{
    public function run()
    {
        Configuration::firstOrCreate(
            ['cle' => 'logo_app'],
            [
                'valeur'      => null,
                'type'        => 'image',
                'groupe'      => 'general',
                'label'       => "Logo de l'application",
                'description' => "Image affichée dans la barre latérale à la place du texte 'GP'. Format recommandé : carré, PNG transparent, 200x200px max.",
            ]
        );
    }
}