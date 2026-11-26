<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Pv;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    private function pvsVisibles()
    {
        $user = auth()->user();

        return Pv::with('filiere')->when(
            $user->role === 'chef_departement',
            fn ($q) => $q->where('filiere_code', $user->filiere_code)
        );
    }

    public function index(Request $request)
    {
        $pvs = $this->pvsVisibles()
            ->when($request->annee, fn ($q, $v) => $q->where('annee', $v))
            ->when($request->filiere, fn ($q, $v) => $q->where('filiere_code', $v))
            ->orderByDesc('annee')
            ->orderBy('filiere_code')
            ->get();

        return view('archive.index', [
            'pvs' => $pvs,
            'filieres' => Filiere::orderBy('nom')->get(),
            'annees' => Pv::select('annee')->distinct()->orderByDesc('annee')->pluck('annee'),
        ]);
    }

    public function show($id)
    {
        $pv = $this->pvsVisibles()->findOrFail($id);

        return view('archive.show', compact('pv'));
    }
}