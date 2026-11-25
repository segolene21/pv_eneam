@extends('layouts.inapp')

@section('title', 'Gestion des utilisateurs')
@section('subtitle', 'Comptes ayant accès à l\'archive des PV')

@section('content')

    @if (session('temp_password'))
        <div class="alert alert-success">
            {{ session('temp_password') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-white px-4 py-3">
            <h3 class="h5 mb-0">{{ $users->count() }} utilisateur(s)</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> Nouveau compte
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Filière</th>
                        <th>Statut MDP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="ps-4">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    Agent de scolarité
                                @elseif ($user->role === 'chef_departement')
                                    Chef de département
                                @else
                                    Enseignant
                                @endif
                            </td>
                            <td>
                                {{ $user->filiere ? ($user->filiere->nom ?? 'Filière #' . $user->filiere->id) : 'Toutes / Aucune' }}
                            </td>
                            <td>
                                @if ($user->must_change_password)
                                    <span class="badge bg-warning-subtle text-warning">À changer</span>
                                @else
                                    <span class="badge bg-success-subtle text-success">Actif</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection