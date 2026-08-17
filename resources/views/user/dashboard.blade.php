<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Firmele mele</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

    <form method="GET" action="{{ route('user.dashboard') }}" class="flex gap-3 mb-6">
    <input type="text" name="cauta" value="{{ $cauta ?? '' }}"
           placeholder="Cauta dupa numar, tip, observatii..."
           class="flex-1 border border-gray-300 rounded p-2">
    <select name="tip" class="border border-gray-300 rounded p-2">
        <option value="">Toate tipurile</option>
        <option value="factura" {{ ($tip ?? '') == 'factura' ? 'selected' : '' }}>Factura</option>
        <option value="chitanta" {{ ($tip ?? '') == 'chitanta' ? 'selected' : '' }}>Chitanta</option>
        <option value="receptie" {{ ($tip ?? '') == 'receptie' ? 'selected' : '' }}>Receptie</option>
        <option value="extras_banca" {{ ($tip ?? '') == 'extras_banca' ? 'selected' : '' }}>Extras banca</option>
        <option value="extras_casa" {{ ($tip ?? '') == 'extras_casa' ? 'selected' : '' }}>Extras casa</option>
    </select>
    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Cauta
    </button>
    @if($cauta || $tip)
        <a href="{{ route('user.dashboard') }}"
           class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            Reseteaza
        </a>
    @endif
</form>

        @forelse($firme as $firma)
            <div class="bg-white rounded shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ $firma->nume }}</h3>
                    <span class="text-gray-500 text-sm">CUI: {{ $firma->cui }}</span>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Adresa:</span> {{ $firma->adresa ?? '-' }}
                    </div>
                    <div>
                        <span class="font-medium">Telefon:</span> {{ $firma->telefon ?? '-' }}
                    </div>
                    <div>
                        <span class="font-medium">Email:</span> {{ $firma->email ?? '-' }}
                    </div>
                </div>

                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium">Documente</h4>
                    <a href="{{ route('documente.create', ['firma_id' => $firma->id]) }}"
                       class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                        + Incarcare document
                    </a>
                </div>

                @if($firma->documente->isEmpty())
                    <p class="text-gray-400 text-sm">Nu exista documente inca.</p>
                @else
                    <table class="w-full border-collapse border border-gray-300 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 p-2 text-left">Tip</th>
                                <th class="border border-gray-300 p-2 text-left">Nr. document</th>
                                <th class="border border-gray-300 p-2 text-left">Fisier</th>
                                <th class="border border-gray-300 p-2 text-left">Data document</th>
                                <th class="border border-gray-300 p-2 text-left">Data incarcare</th>
                                <th class="border border-gray-300 p-2 text-left">Observatii</th>
                                <th class="border border-gray-300 p-2 text-left">Actiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($firma->documente as $document)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 p-2 capitalize">
                                    {{ str_replace('_', ' ', $document->tip) }}
                                </td>
                                <td class="border border-gray-300 p-2">{{ $document->numar_document ?? '-' }}</td>
                                <td class="border border-gray-300 p-2">{{ $document->nume_fisier }}</td>
                                <td class="border border-gray-300 p-2">
                                    {{ $document->data_document ? \Carbon\Carbon::parse($document->data_document)->format('d.m.Y') : '-' }}
                                </td>
                                <td class="border border-gray-300 p-2">
                                    {{ $document->created_at->format('d.m.Y') }}
                                </td>
                                <td class="border border-gray-300 p-2">{{ $document->observatii ?? '-' }}</td>
                                <td class="border border-gray-300 p-2">
                                    <a href="{{ route('documente.edit', $document->id) }}"
                                        class="text-yellow-600 hover:underline mr-2">Editeaza</a>
                                    <a href="{{ route('documente.show', $document->id) }}"
                                       class="text-blue-600 hover:underline mr-2">Descarca</a>
                                    <form action="{{ route('documente.destroy', $document->id) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Stergi documentul?')"
                                                class="text-red-600 hover:underline">Sterge</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @empty
            <div class="bg-white rounded shadow p-6">
                <p class="text-gray-500">Nu ai nicio firma asociata contului tau. Contacteaza contabilul.</p>
            </div>
        @endforelse

    </div>
</x-app-layout>