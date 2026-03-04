<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('secteur_activites', function (Blueprint $table) {
            $table->id();
            $table->string('nomSecteur');
            $table->text('description')->nullable();
            $table->boolean('statutSecteur')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('secteur_activites');
    }
};
