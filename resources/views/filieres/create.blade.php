<x-app-layout>
    <div class="p-6 max-w-xl">
        <h1 class="text-2xl font-bold mb-4">Nouvelle filière</h1>

        <form method="POST" action="{{ route('filieres.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" class="w-full border rounded px-3 py-2">
                @error('nom') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Code</label>
                <input type="text" name="code" value="{{ old('code') }}" class="w-full border rounded px-3 py-2">
                @error('code') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Enregistrer</button>
            <a href="{{ route('filieres.index') }}" class="ml-2">Annuler</a>
        </form>
    </div>
</x-app-layout>