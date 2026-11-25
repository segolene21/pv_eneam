<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Filiere;
use App\Models\AnneeAcademique;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $ig = Filiere::firstOrCreate(['code' => 'IG'], ['nom' => 'Informatique de Gestion']);
Filiere::firstOrCreate(['code' => 'PLAN'], ['nom' => 'Planification']);

AnneeAcademique::firstOrCreate(['libelle' => '2024-2025']);

User::updateOrCreate(['email' => 'admin@pv.test'], [
    'name' => 'Administrateur',
    'password' => 'password',
    'role' => 'admin',
    'filiere_id' => null,
    'must_change_password' => false,
]);

User::updateOrCreate(['email' => 'chef.ig@pv.test'], [
    'name' => 'Chef IG',
    'password' => 'password',
    'role' => 'chef_departement',
    'filiere_id' => $ig->id,
    'must_change_password' => true,
]);
    }
}
