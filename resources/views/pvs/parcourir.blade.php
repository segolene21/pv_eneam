@extends('layouts.inapp')

@section('title', 'Parcourir par filière')
@section('subtitle', 'Choisissez une filière pour consulter ses procès-verbaux')

@section('content')

    <div class="row g-3">
        @forelse ($filieres as $filiere)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('pvs.index', ['filiere' => $filiere->id]) }}"
                   class="text-decoration-none">
                    <div class="card h-100 p-4 border border-primary border-opacity-25">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="icon-shape icon-md bg-primary text-white rounded-2">
                                <i class="ti ti-building fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h2 class="fs-6 mb-1">{{ $filiere->nom }}</h2>
                                <span class="badge bg-primary-subtle text-primary">{{ $filiere->code }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top mt-4 pt-3">
                            <span class="text-secondary">Procès-verbaux</span>
                            <span class="fw-bold fs-4">{{ $filiere->nb_pvs }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center text-secondary py-5">
                        Aucune filière disponible.
                    </div>
                </div>
            </div>
        @endforelse
    </div>

@endsection