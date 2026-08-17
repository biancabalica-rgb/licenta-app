<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Adauga Utilizator</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nume</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Parola</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Confirma parola</label>
                <input type="password" name="password_confirmation"
                       class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Firme asociate</label>
                <div class="border border-gray-300 rounded p-3">
                    @forelse($firme as $firma)
                        <div class="flex items-center gap-2 mb-2">
                            <input type="checkbox" name="firme[]"
                                   value="{{ $firma->id }}"
                                   id="firma_{{ $firma->id }}"
                                   {{ in_array($firma->id, old('firme', [])) ? 'checked' : '' }}>
                            <label for="firma_{{ $firma->id }}">{{ $firma->nume }} ({{ $firma->cui }})</label>
                        </div>
                    @empty
                        <p class="text-gray-400">Nu exista firme. Adauga o firma mai intai.</p>
                    @endforelse
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Salveaza
                </button>
                <a href="{{ route('users.index') }}"
                   class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Anuleaza
                </a>
            </div>

        </form>
    </div>
</x-app-layout>