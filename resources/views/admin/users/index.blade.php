<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des utilisateurs
            </h2>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                + Nouveau compte
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
        @if (session('temp_password'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded font-medium">
                {{ session('temp_password') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Statut MDP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3 font-medium">
                                @if ($user->role === 'admin')
                                    Agent de scolarité
                                @elseif ($user->role === 'chef_departement')
                                    Chef de département
                                @else
                                    Enseignant
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                         {{ $user->filiere ? ($user->filiere->nom ?? 'Filière #' . $user->filiere->id) : 'Toutes / Aucune' }}
                             </td>

                            <td class="px-4 py-3">
                                @if ($user->must_change_password)
                                    <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded">À changer</span>
                                @else
                                    <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">Actif</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
