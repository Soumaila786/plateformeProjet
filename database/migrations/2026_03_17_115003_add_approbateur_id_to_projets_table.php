<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprobateurIdToProjetsTable extends Migration
{
    public function up(){
        Schema::table('projets', function (Blueprint $table) {
            $table->unsignedBigInteger('approbateur_id')->nullable()->after('user_id');
            $table->foreign('approbateur_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(){
        Schema::table('projets', function (Blueprint $table) {
            $table->dropForeign(['approbateur_id']);
            $table->dropColumn('approbateur_id');
        });
    }
}
