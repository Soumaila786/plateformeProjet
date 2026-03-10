<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToProjetsTable extends Migration
{
    public function up()
    {
        Schema::table('projets', function (Blueprint $table) {
            if (!Schema::hasColumn('projets', 'motifRejet')) {
                $table->text('motifRejet')->nullable()->after('statutProjet');
            }
            if (!Schema::hasColumn('projets', 'messageModification')) {
                $table->text('messageModification')->nullable()->after('motifRejet');
            }
            if (!Schema::hasColumn('projets', 'dateApprobation')) {
                $table->timestamp('dateApprobation')->nullable()->after('messageModification');
            }
            if (!Schema::hasColumn('projets', 'dateValidation')) {
                $table->timestamp('dateValidation')->nullable()->after('dateApprobation');
            }
            if (!Schema::hasColumn('projets', 'dateSoumission')) {
                $table->timestamp('dateSoumission')->nullable()->after('dateValidation');
            }
        });
    }

    public function down()
    {
        Schema::table('projets', function (Blueprint $table) {
            $columns = ['motifRejet', 'messageModification', 'dateApprobation', 'dateValidation', 'dateSoumission'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('projets', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
