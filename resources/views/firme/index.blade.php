<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Firme</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('firme.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Adauga firma
        </a>

        <form method="GET" action="{{ route('firme.index') }}" class="flex gap-3 mt-4 mb-4">
            <input type="text" name="cauta" value="{{ request('cauta') }}"
                placeholder="Cauta dupa nume, CUI, email, telefon..."
                class="flex-1 border border-gray-300 rounded p-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Cauta
            </button>
            @if(request('cauta'))
                <a href="{{ route('firme.index') }}"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Reseteaza
                </a>
            @endif
        </form>

        <table class="w-full mt-6 border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 p-2 text-left">Nume</th>
                    <th class="border border-gray-300 p-2 text-left">CUI</th>
                    <th class="border border-gray-300 p-2 text-left">Email</th>
                    <th class="border border-gray-300 p-2 text-left">Telefon</th>
                    <th class="border border-gray-300 p-2 text-left">Actiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($firme as $firma)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-2">{{ $firma->nume }}</td>
                    <td class="border border-gray-300 p-2">{{ $firma->cui }}</td>
                    <td class="border border-gray-300 p-2">{{ $firma->email }}</td>
                    <td class="border border-gray-300 p-2">{{ $firma->telefon }}</td>
                    <td class="border border-gray-300 p-2">
                        <a href="{{ route('firme.show', $firma->id) }}"
                           class="text-blue-600 hover:underline mr-2">Vezi</a>
                        <a href="{{ route('firme.edit', $firma->id) }}"
                           class="text-yellow-600 hover:underline mr-2">Editeaza</a>
                        <form action="{{ route('firme.destroy', $firma->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Esti sigur?')"
                                    class="text-red-600 hover:underline">Sterge</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>