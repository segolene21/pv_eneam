@extends('layouts.inapp')

@section('title', 'Détail du procès-verbal')
@section('subtitle', $pv->filiere->nom . ' - ' . $pv->niveau . ' - ' . $pv->semestre)

@section('content')

    <div class="mb-3">
        <a href="{{ route('pvs.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="ti ti-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="row g-3">

        {{-- Informations --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white px-4 py-3">
                    <h3 class="h5 mb-0">Informations</h3>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-secondary">Filière</span>
                        <span>{{ $pv->filiere->nom }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-secondary">Niveau</span>
                        <span>{{ $pv->niveau }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-secondary">Semestre</span>
                        <span>{{ $pv->semestre }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-secondary">Session</span>
                        @if ($pv->session === 'rattrapage')
                            <span class="badge bg-warning-subtle text-warning">Rattrapage</span>
                        @else
                            <span class="badge bg-primary-subtle text-primary">Normale</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-secondary">Déposé le</span>
                        <span>{{ $pv->created_at->format('d/m/Y') }}</span>
                    </li>
                </ul>

                <div class="card-body">
                    @if (Route::has('pvs.download'))
                        <a href="{{ route('pvs.download', $pv->id) }}" class="btn btn-primary w-100">
                            <i class="ti ti-download"></i> Télécharger le PV
                        </a>
                    @else
                        <button class="btn btn-primary w-100" disabled>
                            <i class="ti ti-download"></i> Télécharger le PV
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Aperçu du scan --}}
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-white px-4 py-3">
                    <h3 class="h5 mb-0">Aperçu du document</h3>
                </div>
                <div class="card-body">
                    @if (Route::has('pvs.fichier'))
                        <iframe src="{{ route('pvs.fichier', $pv->id) }}"
                                class="w-100 border rounded" style="height: 600px;"></iframe>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center text-secondary border rounded"
                             style="height: 600px; border-style: dashed !important;">
                            <i class="ti ti-file-text" style="font-size: 4rem;"></i>
                            <p class="mt-2 mb-0">L'aperçu du scan s'affichera ici.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection