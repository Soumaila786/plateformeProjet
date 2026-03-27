<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationsTable extends Migration
{
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('cle')->unique();       // nom_app, email_expediteur, etc.
            $table->text('valeur')->nullable();
            $table->string('type')->default('text'); // text, email, number, boolean, color
            $table->string('groupe')->default('general'); // general, email, projets, securite
            $table->string('label');               // Libellé affiché
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
