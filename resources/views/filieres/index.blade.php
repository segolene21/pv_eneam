<x-app-layout>
    <div class="p-6">
        <h1 class="text-xl font-bold mb-4">Filières</h1>

        <a href="{{ route('filieres.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
    Ajouter une filière
</a>

        @if (session('success'))
            <p class="mb-4 text-green-600">{{ session('success') }}</p>
        @endif

        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left">Nom</th>
                    <th class="text-left">Code</th>
                    <th class="text-left">PV</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filieres as $filiere)
                    <tr>
                        <td>{{ $filiere->nom }}</td>
                        <td>{{ $filiere->code }}</td>
                        <td>{{ $filiere->pvs_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>