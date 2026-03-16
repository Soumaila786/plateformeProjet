<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidatedColumnsToProjets extends Migration
{
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            if (!Schema::hasColumn('projets', 'validated_at')) {
                $table->timestamp('validated_at')->nullable()->after('motifRejet');
            }
            if (!Schema::hasColumn('projets', 'validated_by')) {
                $table->unsignedBigInteger('validated_by')->nullable()->after('validated_at');
                $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['validated_at', 'validated_by']);
        });
    }
}
