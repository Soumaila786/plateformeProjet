<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activites', function (Blueprint $table) {
            $table->id();
            $table->string('activite');
            $table->text('descriptionActivite')->nullable();

            $table->enum('statutActivite', ['en_attente', 'financee', 'en_cours', 'termine', 'annule'])->default('en_attente');

            // Champs fusionnés depuis l'ancienne table planifications (supprimée)
            $table->integer('indicateur');
            $table->string('uniteIndicateur');
            $table->text('resultatsAttendues');
            $table->decimal('coutEstimatif', 10, 2);
            $table->string('periode');

            $table->foreignId('projet_id')->constrained()->onDelete('cascade');

            // Quel planificateur a créé cette activité (plusieurs planificateurs
            // peuvent intervenir sur les activités d'un même projet)
            $table->foreignId('planificateur_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activites');
    }
};
