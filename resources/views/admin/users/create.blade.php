@extends('layouts.inapp')

@section('title', 'Créer un compte utilisateur')
@section('subtitle', 'Un mot de passe temporaire sera généré')

@section('content')

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input id="name" name="name" type="text" required
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input id="email" name="email" type="email" required
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <select id="role" name="role"
                                    class="form-select @error('role') is-invalid @enderror">
                                <option value="chef_departement" @selected(old('role') === 'chef_departement')>Chef de département</option>
                                <option value="enseignant" @selected(old('role') === 'enseignant')>Enseignant (lecture seule)</option>
                                <option value="admin" @selected(old('role') === 'admin')>Agent de scolarité (Administrateur)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="filiere_id" class="form-label">Filière (obligatoire si Chef de département)</label>
                            <select id="filiere_id" name="filiere_id"
                                    class="form-select @error('filiere_id') is-invalid @enderror">
                                <option value="">-- Aucune (Agent / Enseignant) --</option>
                                @foreach ($filieres as $filiere)
                                    <option value="{{ $filiere->id }}" @selected(old('filiere_id') == $filiere->id)>
                                        {{ ($filiere->code ? $filiere->code . ' - ' : '') . ($filiere->nom ?? 'Filière #' . $filiere->id) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('filiere_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Créer le compte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection