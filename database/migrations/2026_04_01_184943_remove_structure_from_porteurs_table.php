<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveStructureFromPorteursTable extends Migration
{
    public function up(): void
    {
        Schema::table('porteurs', function (Blueprint $table) {
            $table->dropColumn('structure');
        });
    }

    public function down(): void
    {
        Schema::table('porteurs', function (Blueprint $table) {
            $table->string('structure')->nullable();
        });
    }
}
