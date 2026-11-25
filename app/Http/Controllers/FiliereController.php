<?php

namespace App\Http\Controllers;
use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $filieres = Filiere::withCount('pvs')->orderBy('nom')->get();

    return view('filieres.index', compact('filieres'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filieres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
        'nom'  => 'required|string|max:255',
        'code' => 'required|string|max:20|unique:filieres,code',
    ]);

    Filiere::create($data);

    return redirect()->route('filieres.index')->with('success', 'Filière ajoutée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
