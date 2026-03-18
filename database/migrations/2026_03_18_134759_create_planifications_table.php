<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('planifications', function (Blueprint $table) {
            $table->id('idPlanification');
            $table->string('activitePlanification');
            $table->string('reference');
            $table->string('indicateur');
            $table->string('uniteIndicateur');
            $table->text('resultatsAttendues');
            $table->decimal('coutEstimatif', 10, 2);
            $table->string('periode');
            // Clé étrangère vers projets (relation directe)
            $table->foreignId('projet_id')->constrained('projets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('planifications');
    }

};
