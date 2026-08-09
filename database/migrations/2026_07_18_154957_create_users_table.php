<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nomComplet');
            $table->string('email')->unique();
            $table->string('matricule')->nullable()->unique();
            $table->string('fonction')->nullable();
            $table->string('contact')->nullable();
            $table->string('password');

            // TODO (phase permissions) : conservé temporairement pour compat avec le code existant.
            // À supprimer une fois Spatie Permission entièrement branché (rôles/policies/vues).
            $table->enum('role', ['admin', 'approbateur', 'validateur', 'porteur', 'planificateur'])->default('porteur');

            $table->boolean('actif')->default(true);
            $table->timestamp('last_activity')->nullable();
            $table->string('organisation')->nullable();

            // Champs fusionnés depuis les anciennes tables satellites par rôle
            $table->date('datePriseFonction')->nullable();
            $table->string('service')->nullable();
            $table->string('poste')->nullable();
            $table->date('dateDebutMandat')->nullable();
            $table->date('dateFinMandat')->nullable();
            $table->string('specialite')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
