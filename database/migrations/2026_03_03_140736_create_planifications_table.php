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
            $table->decimal('montantDemande', 15, 2)->default(0);
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->enum('statutActivite', ['en_attente', 'en_cours', 'termine', 'annule'])->default('en_attente');

            $table->foreignId('projet_id')->constrained()->onDelete('cascade');


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activites');
    }
};
