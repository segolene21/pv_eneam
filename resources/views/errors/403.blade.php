@extends('layouts.inapp')

@section('title', 'Accès refusé')

@section('content')
    <div class="card">
        <div class="card-body text-center py-6">
            <div class="mb-3">
                <i class="ti ti-lock text-danger" style="font-size: 4rem;"></i>
            </div>
            <h2 class="h3">Accès refusé</h2>
            <p class="text-secondary mb-4">
                {{ $exception->getMessage() ?: 'Vous n\'avez pas l\'autorisation de consulter cette page.' }}
            </p>

            <div class="d-flex justify-content-center gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Retour
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="ti ti-home"></i> Tableau de bord
                </a>
            </div>
        </div>
    </div>
@endsection