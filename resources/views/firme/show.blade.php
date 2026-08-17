@php
    function sortLink($coloana, $label, $sortBy, $sortDir, $firma) {
        $dir = ($sortBy === $coloana && $sortDir === 'asc') ? 'desc' : 'asc';
        $sageata = $sortBy === $coloana ? ($sortDir === 'asc' ? ' ▲' : ' ▼') : '';
        $url = route('firme.show', $firma->id) . '?' . http_build_query(array_merge(request()->query(), ['sort' => $coloana, 'dir' => $dir]));
        return '<a href="' . $url . '" class="hover:underline font-semibold">' . $label . $sageata . '</a>';
    }
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $firma->nume }}</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Informatii firma</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Nume</p>
                    <p class="font-medium">{{ $firma->nume }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">CUI</p>
                    <p class="font-medium">{{ $firma->cui }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Adresa</p>
                    <p class="font-medium">{{ $firma->adresa ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Telefon</p>
                    <p class="font-medium">{{ $firma->telefon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Email</p>
                    <p class="font-medium">{{ $firma->email ?? '-' }}</p>
                </div>
            </div>

            <div class="flex gap-4 mt-6">
                <a href="{{ route('firme.edit', $firma->id) }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Editeaza
                </a>
                <form action="{{ route('firme.destroy', $firma->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Esti sigur?')"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Sterge
                    </button>
                </form>
                <a href="{{ route('firme.index') }}"
                   class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Inapoi
                </a>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Documente</h3>
                <a href="{{ route('documente.create', ['firma_id' => $firma->id]) }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Incarcare document
                </a>
            </div>

            {{-- Cautare si filtrare --}}
            <form method="GET" action="{{ route('firme.show', $firma->id) }}" class="flex gap-3 mb-4">
                <input type="text" name="cauta" value="{{ request('cauta') }}"
                       placeholder="Cauta dupa numar, tip, observatii..."
                       class="flex-1 border border-gray-300 rounded p-2">
                <select name="tip" class="border border-gray-300 rounded p-2">
                    <option value="">Toate tipurile</option>
                    <option value="factura" {{ request('tip') == 'factura' ? 'selected' : '' }}>Factura</option>
                    <option value="chitanta" {{ request('tip') == 'chitanta' ? 'selected' : '' }}>Chitanta</option>
                    <option value="receptie" {{ request('tip') == 'receptie' ? 'selected' : '' }}>Receptie</option>
                    <option value="extras_banca" {{ request('tip') == 'extras_banca' ? 'selected' : '' }}>Extras banca</option>
                    <option value="extras_casa" {{ request('tip') == 'extras_casa' ? 'selected' : '' }}>Extras casa</option>
                </select>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Cauta
                </button>
                @if(request('cauta') || request('tip'))
                    <a href="{{ route('firme.show', $firma->id) }}"
                       class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                        Reseteaza
                    </a>
                @endif
            </form>

            @if($documente->isEmpty())
                <p class="text-gray-500">Nu exista documente.</p>
            @else
                <table class="w-full border-collapse border border-gray-300 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border border-gray-300 p-2 text-left">
                                    {!! sortLink('tip', 'Tip', $sortBy, $sortDir, $firma) !!}
                                </th>
                                <th class="border border-gray-300 p-2 text-left">
                                    {!! sortLink('numar_document', 'Nr. document', $sortBy, $sortDir, $firma) !!}
                                </th>
                                <th class="border border-gray-300 p-2 text-left">
                                    {!! sortLink('data_document', 'Data document', $sortBy, $sortDir, $firma) !!}
                                </th>
                                <th class="border border-gray-300 p-2 text-left">
                                    {!! sortLink('created_at', 'Data incarcare', $sortBy, $sortDir, $firma) !!}
                                </th>
                                <th class="border border-gray-300 p-2 text-left">Observatii</th>
                                <th class="border border-gray-300 p-2 text-left">Actiuni</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($documente as $document)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 p-2 capitalize">
                                {{ str_replace('_', ' ', $document->tip) }}
                            </td>
                            <td class="border border-gray-300 p-2">{{ $document->numar_document ?? '-' }}</td>
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

    </div>
</x-app-layout>

