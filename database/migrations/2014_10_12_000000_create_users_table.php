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
            $table->string('motDePasse');
            $table->enum('role', ['admin', 'approbateur', 'validateur', 'porteur'])->default('porteur');
            $table->boolean('actif')->default(true);
            $table->timestamp('dateCreation')->useCurrent();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
