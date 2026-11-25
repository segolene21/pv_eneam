<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ===== TEMPORAIRE (personne 3) : données fictives, à supprimer quand PvController existera =====
$fauxFilieres = function () {
    return collect([
        (object) ['id' => 1, 'nom' => 'Informatique de Gestion', 'code' => 'IG'],
        (object) ['id' => 2, 'nom' => 'Planification', 'code' => 'PLAN'],
    ]);
};

$fauxPvs = function () use ($fauxFilieres) {
    $f = $fauxFilieres();
    $ig = $f[0];
    $plan = $f[1];

    $pvs = collect([
        (object) ['id' => 1, 'filiere' => $ig,   'niveau' => 'L1', 'semestre' => 'S1', 'session' => 'normale',    'created_at' => now()->subDays(20)],
        (object) ['id' => 2, 'filiere' => $ig,   'niveau' => 'L1', 'semestre' => 'S2', 'session' => 'rattrapage', 'created_at' => now()->subDays(15)],
        (object) ['id' => 3, 'filiere' => $ig,   'niveau' => 'L2', 'semestre' => 'S3', 'session' => 'normale',    'created_at' => now()->subDays(10)],
        (object) ['id' => 4, 'filiere' => $ig,   'niveau' => 'L3', 'semestre' => 'S6', 'session' => 'normale',    'created_at' => now()->subDays(1)],
        (object) ['id' => 5, 'filiere' => $plan, 'niveau' => 'L1', 'semestre' => 'S1', 'session' => 'normale',    'created_at' => now()->subDays(18)],
        (object) ['id' => 6, 'filiere' => $plan, 'niveau' => 'L2', 'semestre' => 'S3', 'session' => 'rattrapage', 'created_at' => now()->subDays(8)],
        (object) ['id' => 7, 'filiere' => $plan, 'niveau' => 'L2', 'semestre' => 'S4', 'session' => 'normale',    'created_at' => now()->subDays(3)],
        (object) ['id' => 8, 'filiere' => $plan, 'niveau' => 'L3', 'semestre' => 'S5', 'session' => 'normale',    'created_at' => now()->subDays(2)],
    ]);

    // Règle d'accès : un chef ne voit que sa filière
    if (auth()->user()->role === 'chef_departement') {
        $pvs = $pvs->where('filiere.id', auth()->user()->filiere_id);
    }

    return $pvs;
};
// ===== FIN TEMPORAIRE =====

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () use ($fauxPvs, $fauxFilieres) {
    $pvs = $fauxPvs();

    $nbFilieres = $fauxFilieres()
        ->when(auth()->user()->role === 'chef_departement',
            fn ($c) => $c->where('id', auth()->user()->filiere_id))
        ->count();

    return view('dashboard', [
        'pvs'        => $pvs,
        'derniers'   => $pvs->sortByDesc('created_at')->take(5),
        'nbFilieres' => $nbFilieres,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});

require __DIR__.'/auth.php';

// ===== TEMPORAIRE (personne 3) : routes de consultation, à remplacer par PvController =====
Route::middleware('auth')->get('/pvs', function (Request $request) use ($fauxPvs, $fauxFilieres) {
    $pvs = $fauxPvs()
        ->when($request->input('filiere'),  fn ($c, $v) => $c->where('filiere.id', (int) $v))
        ->when($request->input('niveau'),   fn ($c, $v) => $c->where('niveau', $v))
        ->when($request->input('semestre'), fn ($c, $v) => $c->where('semestre', $v))
        ->when($request->input('session'),  fn ($c, $v) => $c->where('session', $v));

    return view('pvs.index', [
        'pvs'      => $pvs->sortByDesc('created_at'),
        'filieres' => $fauxFilieres(),
    ]);
})->name('pvs.index');

Route::middleware('auth')->get('/pvs/parcourir', function () use ($fauxPvs, $fauxFilieres) {
    $pvs = $fauxPvs();

    $filieres = $fauxFilieres()
        ->when(auth()->user()->role === 'chef_departement',
            fn ($c) => $c->where('id', auth()->user()->filiere_id))
        ->map(function ($f) use ($pvs) {
            $f->nb_pvs = $pvs->where('filiere.id', $f->id)->count();
            return $f;
        });

    return view('pvs.parcourir', ['filieres' => $filieres]);
})->name('pvs.parcourir');

Route::middleware('auth')->get('/pvs/{id}', function ($id) use ($fauxPvs) {
    $pv = $fauxPvs()->firstWhere('id', (int) $id);
    abort_if(! $pv, 403, 'Vous n\'avez pas accès à ce procès-verbal.');

    return view('pvs.show', ['pv' => $pv]);
})->whereNumber('id')->name('pvs.show');
// ===== FIN TEMPORAIRE =====