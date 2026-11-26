<?php

namespace App\Http\Controllers;

use App\Models\Pv;
use Illuminate\Support\Facades\Storage;

class PvFichierController extends Controller
{
    private function verifier(Pv $pv): void
    {
        $user = auth()->user();

        $autorise = $user->role === 'admin' || $user->filiere_code === $pv->filiere_code;
        abort_unless($autorise, 403);

        abort_unless(Storage::exists($pv->fichier_path), 404, 'Fichier introuvable.');
    }

    public function apercu(Pv $pv)
    {
        $this->verifier($pv);

        return Storage::response($pv->fichier_path, $pv->nom_original);
    }

    public function telecharger(Pv $pv)
    {
        $this->verifier($pv);

        return Storage::download($pv->fichier_path, $pv->nom_original);
    }
}