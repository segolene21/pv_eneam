@extends('layouts.inapp')

@section('title', 'Tableau de bord')
@section('subtitle', auth()->user()->role === 'admin'
    ? 'Vue d\'ensemble de toutes les filières'
    : 'Vue d\'ensemble de votre filière')

@section('content')

    {{-- Cartes de chiffres --}}
    <div class="row g-3 mb-3">
        <div class="col-lg-4 col-12">
            <a href="{{ Route::has('pvs.index') ? route('pvs.index') : '#' }}" class="text-decoration-none">
                <div class="card p-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-2">
                    <div class="d-flex gap-3">
                        <div class="icon-shape icon-md bg-primary text-white rounded-2">
                            <i class="ti ti-file-text fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-2 fs-6">PV déposés</h2>
                            <h3 class="fw-bold mb-0">{{ $pvs->count() }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-12">
            <a href="{{ Route::has('pvs.parcourir') ? route('pvs.parcourir') : '#' }}" class="text-decoration-none">
                <div class="card p-4 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-2">
                    <div class="d-flex gap-3">
                        <div class="icon-shape icon-md bg-success text-white rounded-2">
                            <i class="ti ti-building fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-2 fs-6">{{ $nbFilieres > 1 ? 'Filières' : 'Filière' }}</h2>
                            <h3 class="fw-bold mb-0">{{ $nbFilieres }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-12">
            <a href="{{ Route::has('pvs.index') ? route('pvs.index', ['session' => 'rattrapage']) : '#' }}" class="text-decoration-none">
                <div class="card p-4 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-2">
                    <div class="d-flex gap-3">
                        <div class="icon-shape icon-md bg-warning text-white rounded-2">
                            <i class="ti ti-refresh fs-4"></i>
                        </div>
                        <div>
                            <h2 class="mb-2 fs-6">Sessions de rattrapage</h2>
                            <h3 class="fw-bold mb-0">{{ $pvs->where('session', 'rattrapage')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Derniers PV --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-white px-4 py-3">
            <h3 class="h5 mb-0">Derniers PV déposés</h3>

            <div class="d-flex gap-2">
                @if (Route::has('pvs.index'))
                    <a href="{{ route('pvs.index') }}" class="btn btn-sm btn-outline-secondary">Voir tout</a>
                @endif
                @if (auth()->user()->role === 'admin' && Route::has('pvs.create'))
                    <a href="{{ route('pvs.create') }}" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> Ajouter un PV
                    </a>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Filière</th>
                        <th>Niveau</th>
                        <th>Semestre</th>
                        <th>Session</th>
                        <th>Déposé le</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($derniers as $pv)
                        <tr>
                            <td class="ps-4">{{ $pv->filiere->nom }}</td>
                            <td>{{ $pv->niveau }}</td>
                            <td>{{ $pv->semestre }}</td>
                            <td>
                                @if ($pv->session === 'rattrapage')
                                    <span class="badge bg-warning-subtle text-warning">Rattrapage</span>
                                @else
                                    <span class="badge bg-primary-subtle text-primary">Normale</span>
                                @endif
                            </td>
                            <td>{{ $pv->created_at->format('d/m/Y') }}</td>
                            <td class="text-end pe-4">
                                @if (Route::has('pvs.show'))
                                    <a href="{{ route('pvs.show', $pv->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye"></i> Voir
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary py-4">
                                Aucun PV déposé pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection