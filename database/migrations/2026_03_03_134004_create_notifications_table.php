<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->timestamp('dateEnvoi')->useCurrent();
            $table->enum('statut', ['non_lu', 'lu'])->default('non_lu');
            $table->string('type')->nullable();

            $table->foreignId('destinataire_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('projet_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
