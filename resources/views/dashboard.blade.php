@extends('layouts.adminlte')

@section('title', 'Tableau de bord')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon text-bg-primary"><i class="bi bi-file-earmark-text"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">PV déposés</span>
                    <span class="info-box-number">12</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon text-bg-success"><i class="bi bi-calendar3"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Années académiques</span>
                    <span class="info-box-number">2</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon text-bg-warning"><i class="bi bi-diagram-3"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Filières</span>
                    <span class="info-box-number">3</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            Bienvenue {{ auth()->user()->name }}. Le layout fonctionne.
        </div>
    </div>
@endsection