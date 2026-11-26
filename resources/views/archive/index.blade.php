@extends('layouts.inapp')

@section('content')
<h4 class="mb-3">Archive des PV</h4>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="annee" class="form-select">
            <option value="">Toutes les années</option>
            @foreach ($annees as $a)
                <option value="{{ $a }}" @selected(request('annee') === $a)>{{ $a }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <select name="filiere" class="form-select">
            <option value="">Toutes les filières</option>
            @foreach ($filieres as $f)
                <option value="{{ $f->code }}" @selected(request('filiere') === $f->code)>{{ $f->nom }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary">Filtrer</button>
        <a href="{{ route('archive.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
    </div>
</form>

<table class="table align-middle">
    <thead>
        <tr><th>Année</th><th>Filière</th><th>Fichier</th><th>Déposé le</th><th></th></tr>
    </thead>
    <tbody>
        @forelse ($pvs as $pv)
            <tr>
                <td>{{ $pv->annee }}</td>
                <td>{{ $pv->filiere->nom ?? $pv->filiere_code }}</td>
                <td>{{ $pv->nom_original }}</td>
                <td>{{ $pv->created_at->format('d/m/Y') }}</td>
                <td class="d-flex gap-2">
                    <a href="{{ route('archive.show', $pv->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                    @if (auth()->user()->role === 'admin')
                        <form method="POST" action="{{ route('depot.destroy', $pv) }}"
                              onsubmit="return confirm('Supprimer ce PV ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted">Aucun PV.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection