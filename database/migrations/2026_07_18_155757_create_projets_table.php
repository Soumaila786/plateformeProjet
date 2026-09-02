<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('codeProjet')->unique();
            $table->string('titre');
            $table->text('description');
            $table->text('objectif')->nullable();
            $table->timestamp('dateSoumission')->nullable();
            $table->integer('duree')->nullable();
            $table->date('dateDebut')->nullable();
            $table->date('dateFin')->nullable();
            $table->decimal('budgetTotal', 15, 2)->default(0);
            $table->decimal('montantDemande', 15, 2)->default(0);
            $table->enum('statutProjet', ['brouillon', 'soumis', 'en_examen', 'approuve', 'rejete', 'valide'])->default('brouillon');
            $table->timestamp('dateApprobation')->nullable();
            $table->foreignId('approbateur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('dateValidation')->nullable();
            $table->foreignId('validateur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('planification_demandee')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // porteur propriétaire
            $table->foreignId('secteur_id')->constrained('secteur_activites')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('projets');
    }
};
