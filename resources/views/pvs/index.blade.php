@extends('layouts.inapp')

@section('title', 'Procès-verbaux')
@section('subtitle', 'Consultez les PV de délibération')

@section('content')

    {{-- Filtres --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('pvs.index') }}" class="row g-3 align-items-end">

                @if (auth()->user()->role === 'admin')
                    <div class="col-md-3">
                        <label class="form-label">Filière</label>
                        <select name="filiere" class="form-select">
                            <option value="">Toutes</option>
                            @foreach ($filieres as $f)
                                <option value="{{ $f->id }}" @selected(request('filiere') == $f->id)>{{ $f->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-md-2">
                    <label class="form-label">Niveau</label>
                    <select name="niveau" class="form-select">
                        <option value="">Tous</option>
                        @foreach (['L1', 'L2', 'L3'] as $n)
                            <option value="{{ $n }}" @selected(request('niveau') === $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Semestre</label>
                    <select name="semestre" class="form-select">
                        <option value="">Tous</option>
                        @foreach (['S1', 'S2', 'S3', 'S4', 'S5', 'S6'] as $s)
                            <option value="{{ $s }}" @selected(request('semestre') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Session</label>
                    <select name="session" class="form-select">
                        <option value="">Toutes</option>
                        <option value="normale" @selected(request('session') === 'normale')>Normale</option>
                        <option value="rattrapage" @selected(request('session') === 'rattrapage')>Rattrapage</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-filter"></i> Filtrer
                    </button>
                    <a href="{{ route('pvs.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-white px-4 py-3">
            <h3 class="h5 mb-0">{{ $pvs->count() }} procès-verbal(aux)</h3>

            @if (auth()->user()->role === 'admin' && Route::has('pvs.create'))
                <a href="{{ route('pvs.create') }}" class="btn btn-sm btn-primary">
                    <i class="ti ti-plus"></i> Ajouter un PV
                </a>
            @endif
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
                    @forelse ($pvs as $pv)
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
                            <td colspan="6" class="text-center text-secondary py-5">
                                Aucun PV ne correspond à votre recherche.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection