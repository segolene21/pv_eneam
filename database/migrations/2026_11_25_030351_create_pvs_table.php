<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pvs', function (Blueprint $table) {
            $table->id();
            $table->string('annee', 9);
            $table->string('filiere_code', 20);
            $table->string('fichier_path');
            $table->string('nom_original');
            $table->foreignId('depose_par')->constrained('users');
            $table->timestamps();

            $table->unique(['annee', 'filiere_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pvs');
    }
};