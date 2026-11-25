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
       Schema::table('users', function (Blueprint $table) {
    $table->string('role')->default('chef_departement');
    $table->foreignId('filiere_id')->nullable()->constrained()->nullOnDelete();
    $table->boolean('must_change_password')->default(true);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('users', function (Blueprint $table) {
    $table->dropConstrainedForeignId('filiere_id');
    $table->dropColumn(['role', 'must_change_password']);
});
    }
};
