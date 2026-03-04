<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_projets', function (Blueprint $table) {
            $table->id();
            $table->string('nomFichier');
            $table->string('typeDocument');
            $table->string('cheminFichier');
            $table->timestamp('dateUpload')->useCurrent();

            $table->foreignId('projet_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploader_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_projets');
    }
};
