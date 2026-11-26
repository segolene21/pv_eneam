<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pv;
use App\Models\Filiere;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
class PvDepotController extends Controller
{
    public function create()
{
    abort_unless(auth()->user()->role === 'admin', 403);

    $filieres = Filiere::orderBy('nom')->get();
    $annees = collect(range(now()->year + 1, 2015))
        ->map(fn ($y) => ($y - 1) . '-' . $y);

    return view('depot.create', compact('filieres', 'annees'));
}

public function store(Request $request)
{
    abort_unless(auth()->user()->role === 'admin', 403);

    $data = $request->validate([
        'annee' => ['required', 'regex:/^\d{4}-\d{4}$/'],
        'filiere_code' => 'required|exists:filieres,code',
        'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
    ]);

    if (Pv::where('annee', $data['annee'])->where('filiere_code', $data['filiere_code'])->exists()) {
        throw ValidationException::withMessages([
            'fichier' => 'Un PV existe déjà pour cette filière et cette année.',
        ]);
    }

    $fichier = $request->file('fichier');
    $path = $fichier->store("pvs/{$data['annee']}/{$data['filiere_code']}");

    Pv::create([
        'annee' => $data['annee'],
        'filiere_code' => $data['filiere_code'],
        'fichier_path' => $path,
        'nom_original' => $fichier->getClientOriginalName(),
        'depose_par' => auth()->id(),
    ]);

    if ($request->expectsJson()) {
        return response()->json(['message' => 'PV archivé.']);
    }

    return redirect()->route('depot.create')->with('success', 'PV archivé.');
}
public function destroy(Pv $pv)
{
    abort_unless(auth()->user()->role === 'admin', 403);

    Storage::delete($pv->fichier_path);
    $pv->delete();

    return back()->with('success', 'PV supprimé.');
}
}
