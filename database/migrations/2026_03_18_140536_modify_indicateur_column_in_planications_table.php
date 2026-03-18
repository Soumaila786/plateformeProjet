<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('planifications', function (Blueprint $table) {
            // Changer le type de string à integer
            $table->integer('indicateur')->change();
        });
    }

    public function down(): void
    {
        Schema::table('planifications', function (Blueprint $table) {
            // Revenir en arrière (integer -> string)
            $table->string('indicateur')->change();
        });
    }
};
