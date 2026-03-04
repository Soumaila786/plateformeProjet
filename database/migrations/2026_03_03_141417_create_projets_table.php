<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->string('codeProjet')->unique();
            $table->string('titre');
            $table->text('description');
            $table->text('objectif');
            $table->timestamp('dateCreation')->useCurrent();
            $table->timestamp('dateSoumission')->nullable();
            $table->integer('duree')->nullable();
            $table->date('dateDebut')->nullable();
            $table->date('dateFin')->nullable();
            $table->decimal('budgetTotal', 15, 2)->default(0);
            $table->decimal('montantDemande', 15, 2)->default(0);
            $table->enum('statutProjet', ['brouillon', 'soumis', 'en_examen', 'approuve', 'rejete', 'valide'])->default('brouillon');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('secteur_id')->constrained()->restrictOnDelete();


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projets');
    }
};
