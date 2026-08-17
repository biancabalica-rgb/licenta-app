<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editeaza Firma</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('firme.update', $firma->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nume firma</label>
                <input type="text" name="nume" value="{{ old('nume', $firma->nume) }}"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">CUI</label>
                <input type="text" name="cui" value="{{ old('cui', $firma->cui) }}"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Adresa</label>
                <input type="text" name="adresa" value="{{ old('adresa', $firma->adresa) }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Telefon</label>
                <input type="text" name="telefon" value="{{ old('telefon', $firma->telefon) }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $firma->email) }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            <div class="flex gap-4">
                <button type="submit"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Actualizeaza
                </button>
                <a href="{{ route('firme.index') }}"
                   class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Anuleaza
                </a>
            </div>

        </form>
    </div>
</x-app-layout>