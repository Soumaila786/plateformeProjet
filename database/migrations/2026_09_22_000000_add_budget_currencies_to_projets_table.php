<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->string('budgetDevise', 3)->default('XOF')->after('budgetTotal');
            $table->string('montantDemandeDevise', 3)->default('XOF')->after('montantDemande');
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn(['budgetDevise', 'montantDemandeDevise']);
        });
    }
};
