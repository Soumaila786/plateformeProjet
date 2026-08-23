<?php

use App\Models\Configuration;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Configuration::firstOrCreate(
            ['cle' => 'logo_image'],
            [
                'valeur' => null,
                'type' => 'image',
                'groupe' => 'general',
                'label' => "Logo de l'application",
                'description' => "Image affichee dans l'application (2 Mo maximum).",
            ]
        );
    }

    public function down(): void
    {
        Configuration::where('cle', 'logo_image')->delete();
    }
};
