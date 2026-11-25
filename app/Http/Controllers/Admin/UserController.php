<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('filiere')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
       $filieres = Filiere::all();
        return view('admin.users.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:admin,chef_departement,enseignant'],
            'filiere_id' => ['required_if:role,chef_departement', 'nullable', 'exists:filieres,id'],
        ]);

        $tempPassword = Str::random(10);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => $request->role,
            'filiere_id' => $request->role === 'chef_departement' ? $request->filiere_id : null,
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('temp_password', "Compte créé pour {$request->name} ! Mot de passe temporaire (affiché une seule fois) : {$tempPassword}");
    }
}
