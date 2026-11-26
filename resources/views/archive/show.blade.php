@extends('layouts.inapp')

@section('content')
<a href="{{ route('archive.index') }}" class="btn btn-outline-secondary btn-sm mb-3">← Retour</a>

<h4>{{ $pv->filiere->nom ?? $pv->filiere_code }} — {{ $pv->annee }}</h4>
<p class="text-muted">{{ $pv->nom_original }}</p>

<a href="{{ route('pv.telecharger', $pv) }}" class="btn btn-primary mb-3">Télécharger le PV</a>

<iframe src="{{ route('pv.apercu', $pv) }}" width="100%" height="700" style="border:1px solid #ddd"></iframe>
@endsection