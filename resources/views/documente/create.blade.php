<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Incarcare document — {{ $firma->nume }}
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

        <form method="POST" action="{{ route('documente.store') }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="firma_id" value="{{ $firma->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Tip document</label>
                <select name="tip" id="tip" class="w-full border border-gray-300 rounded p-2"
                        required onchange="toggleCampuri()">
                    <option value="">-- Selecteaza --</option>
                    <option value="factura">Factura</option>
                    <option value="chitanta">Chitanta</option>
                    <option value="receptie">Receptie</option>
                    <option value="extras_banca">Extras de banca</option>
                    <option value="extras_casa">Extras de casa</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Data document</label>
                <input type="date" name="data_document" value="{{ old('data_document') }}"
                       class="w-full border border-gray-300 rounded p-2">
            </div>

            {{-- Apare doar pentru factura, chitanta, receptie --}}
            <div class="mb-4" id="camp_numar" style="display:none;">
                <label class="block text-gray-700 mb-1">Numar document</label>
                <input type="text" name="numar_document" value="{{ old('numar_document') }}"
                       class="w-full border border-gray-300 rounded p-2"
                       placeholder="ex: 1234">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Fisier (PDF, JPG, PNG)</label>
                <input type="file" name="fisier"
                       class="w-full border border-gray-300 rounded p-2"
                       accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Observatii (optional)</label>
                <textarea name="observatii" rows="3"
                          class="w-full border border-gray-300 rounded p-2">{{ old('observatii') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Incarcare
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
    </script>
</x-app-layout>