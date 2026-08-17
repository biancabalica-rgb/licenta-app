<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Adauga Firma</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('firme.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nume firma</label>
                <input type="text" name="nume" value="{{ old('nume') }}"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">CUI</label>
                <input type="text" name="cui" value="{{ old('cui') }}"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Adresa</label>
                <input type="text" name="adresa" value="{{ old('adresa') }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Telefon</label>
                <input type="text" name="telefon" value="{{ old('telefon') }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            <div class="flex gap-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Salveaza
                </button>
                <a href="{{ route('firme.index') }}"
                   class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Anuleaza
                </a>
            </div>

        </form>
    </div>
</x-app-layout>