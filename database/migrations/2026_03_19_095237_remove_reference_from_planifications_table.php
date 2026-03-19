<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveReferenceFromPlanificationsTable extends Migration
{
    public function up()
    {
        Schema::table('planifications', function (Blueprint $table) {
            $table->dropColumn('reference');
        });
    }

    public function down()
    {
        Schema::table('planifications', function (Blueprint $table) {
            $table->string('reference')->nullable();
        });
    }

}
