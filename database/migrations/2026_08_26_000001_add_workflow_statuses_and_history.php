<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE projets MODIFY statutProjet ENUM('brouillon','soumis','en_examen','a_corriger','approuve','en_validation','valide','rejete') NOT NULL DEFAULT 'brouillon'");
        Schema::create('historique_projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('projets')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ancien_statut')->nullable();
            $table->string('nouveau_statut');
            $table->string('action');
            $table->foreignId('commentaire_id')->nullable()->constrained('commentaires')->nullOnDelete();
            $table->timestamps();
            $table->index(['projet_id', 'created_at']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('historique_projets');
        DB::statement("ALTER TABLE projets MODIFY statutProjet ENUM('brouillon','soumis','en_examen','approuve','rejete','valide') NOT NULL DEFAULT 'brouillon'");
    }
};
