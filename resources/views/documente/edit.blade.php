<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editeaza document — {{ $firma->nume }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('documente.update', $document->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Tip document</label>
                <select name="tip" id="tip" class="w-full border border-gray-300 rounded p-2"
                        required onchange="toggleCampuri()">
                    <option value="factura" {{ $document->tip == 'factura' ? 'selected' : '' }}>Factura</option>
                    <option value="chitanta" {{ $document->tip == 'chitanta' ? 'selected' : '' }}>Chitanta</option>
                    <option value="receptie" {{ $document->tip == 'receptie' ? 'selected' : '' }}>Receptie</option>
                    <option value="extras_banca" {{ $document->tip == 'extras_banca' ? 'selected' : '' }}>Extras de banca</option>
                    <option value="extras_casa" {{ $document->tip == 'extras_casa' ? 'selected' : '' }}>Extras de casa</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Data document</label>
                <input type="date" name="data_document"
                       value="{{ old('data_document', $document->data_document) }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            <div class="mb-4" id="camp_numar">
                <label class="block text-gray-700 mb-1">Numar document</label>
                <input type="text" name="numar_document"
                       value="{{ old('numar_document', $document->numar_document) }}"
                       class="w-full border border-gray-300 rounded p-2"
                       placeholder="ex: 1234">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Observatii (optional)</label>
                <textarea name="observatii" rows="3"
                          class="w-full border border-gray-300 rounded p-2">{{ old('observatii', $document->observatii) }}</textarea>
            </div>

            <p class="text-gray-500 text-sm mb-4">
                Fisier curent: <span class="font-medium">{{ $document->nume_fisier }}</span>
                — pentru a schimba fisierul, sterge documentul si incarca unul nou.
            </p>

            <div class="flex gap-4">
                <button type="submit"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Actualizeaza
                </button>
                <a href="{{ route('firme.show', $firma->id) }}"
                   class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Anuleaza
                </a>
            </div>

        </form>
    </div>

    <script>
        function toggleCampuri() {
            const tip = document.getElementById('tip').value;
            const campNumar = document.getElementById('camp_numar');
            const tipuriCuNumar = ['factura', 'chitanta', 'receptie'];

            if (tipuriCuNumar.includes(tip)) {
                campNumar.style.display = 'block';
            } else {
                campNumar.style.display = 'none';
            }
        }

        // Ruleaza la incarcare pagina ca sa seteze starea initiala
        toggleCampuri();
    </script>
</x-app-layout>