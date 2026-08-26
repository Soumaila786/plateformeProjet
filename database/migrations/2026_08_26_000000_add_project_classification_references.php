<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types_projets', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        Schema::create('sous_domaines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secteur_id')->constrained('secteur_activites')->restrictOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
            $table->unique(['secteur_id', 'nom']);
        });

        Schema::table('projets', function (Blueprint $table) {
            $table->foreignId('type_projet_id')->nullable()->after('objectif')
                ->constrained('types_projets')->nullOnDelete();
            $table->foreignId('sous_domaine_id')->nullable()->after('secteur_id')
                ->constrained('sous_domaines')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropForeign(['type_projet_id']);
            $table->dropForeign(['sous_domaine_id']);
            $table->dropColumn(['type_projet_id', 'sous_domaine_id']);
        });

        Schema::dropIfExists('sous_domaines');
        Schema::dropIfExists('types_projets');
    }
};
