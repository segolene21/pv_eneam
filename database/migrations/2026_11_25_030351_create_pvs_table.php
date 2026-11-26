<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('pvs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('annee_academique_id')->constrained('annees_academiques');
    $table->foreignId('filiere_id')->constrained();
    $table->string('niveau');
    $table->string('semestre');
    $table->string('session');
    $table->string('fichier_path');
    $table->foreignId('depose_par')->constrained('users');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pvs');
    }
};
