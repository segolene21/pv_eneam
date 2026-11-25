<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer un compte utilisateur
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="name" value="Nom complet" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Adresse email" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="role" value="Rôle" />
                    <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="chef_departement">Chef de département</option>
                        <option value="enseignant">Enseignant (lecture seule)</option>
                        <option value="admin">Agent de scolarité (Administrateur)</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="filiere_id" value="Filière (obligatoire si Chef de département)" />
                    <select id="filiere_id" name="filiere_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Aucune (Agent / Enseignant) --</option>
                        @foreach ($filieres as $filiere)
                            <option value="{{ $filiere->id }}">
                               {{ ($filiere->code ? $filiere->code . ' - ' : '') . ($filiere->nom ?? 'Filière #' . $filiere->id) }}
                           </option>

                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('filiere_id')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm">Annuler</a>
                    <x-primary-button>Créer le compte</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
