<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commentaire_motifs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commentaire_id')->constrained('commentaires')->onDelete('cascade');
            $table->foreignId('motif_id')->constrained('motifs_rejet')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['commentaire_id', 'motif_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('commentaire_motifs');
    }
};
