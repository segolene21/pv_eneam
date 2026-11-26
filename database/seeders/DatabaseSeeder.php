<?php

namespace Database\Seeders;

use App\Models\Filiere;
use App\Models\Pv;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Filiere::firstOrCreate(['code' => 'IG'], ['nom' => 'Informatique de Gestion']);
        Filiere::firstOrCreate(['code' => 'PLAN'], ['nom' => 'Planification']);

        $admin = User::updateOrCreate(['email' => 'admin@pv.test'], [
            'name' => 'Administrateur',
            'password' => 'password',
            'role' => 'admin',
            'filiere_code' => null,
            'must_change_password' => false,
        ]);

        User::updateOrCreate(['email' => 'chef.ig@pv.test'], [
            'name' => 'Chef IG',
            'password' => 'password',
            'role' => 'chef_departement',
            'filiere_code' => 'IG',
            'must_change_password' => true,
        ]);

        foreach (Filiere::all() as $filiere) {
            foreach (['2023-2024', '2024-2025'] as $annee) {
                Pv::firstOrCreate(
                    ['annee' => $annee, 'filiere_code' => $filiere->code],
                    [
                        'fichier_path' => 'pvs/exemple.pdf',
                        'nom_original' => 'PV_' . $filiere->code . '_' . $annee . '.pdf',
                        'depose_par' => $admin->id,
                    ]
                );
            }
        }
    }
}