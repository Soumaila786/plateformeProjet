<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixCommentaireColumnInProjetsTable extends Migration
{
    public function up(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            // 1. Supprimer l'ancienne colonne string
            $table->dropColumn('motifRejet');
        });

        Schema::table('projets', function (Blueprint $table) {
            // 2. Créer la nouvelle colonne ID (clé étrangère)
            // nullable() est conseillé si tous les projets n'ont pas de commentaire
            $table->foreignId('commentaire_id')
                    ->nullable()
                    ->constrained('commentaires')
                    ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropForeign(['commentaire_id']);
            $table->dropColumn('commentaire_id');
            $table->string('commentaire_id')->nullable(); // Revenir à l'ancien état
        });
    }
}
