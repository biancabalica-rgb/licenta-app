<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContaBia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-700">📊 ContaBia</h1>
        <div class="flex gap-4">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('firme.index') : route('user.dashboard') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Autentificare
                </a>
            @endauth
        </div>
    </nav>

    {{-- Hero --}}
    <div class="max-w-4xl mx-auto mt-20 px-4 text-center">
        <h2 class="text-4xl font-bold text-gray-800 mb-6">
            Gestionare documente contabile
        </h2>
        <p class="text-xl text-gray-500 mb-10">
            Platforma dedicata transmiterii documentelor contabile intre antreprenori si contabil.
            Facturi, chitante, receptii si extrase intr-un singur loc.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12 text-left">
            <div class="bg-white rounded shadow p-6">
                <div class="text-blue-600 text-3xl mb-3">📄</div>
                <h3 class="font-semibold text-lg mb-2">Documente centralizate</h3>
                <p class="text-gray-500 text-sm">Facturi, chitante, receptii si extrase intr-un singur loc, organizate pe firma.</p>
            </div>
            <div class="bg-white rounded shadow p-6">
                <div class="text-blue-600 text-3xl mb-3">🔍</div>
                <h3 class="font-semibold text-lg mb-2">Cautare rapida</h3>
                <p class="text-gray-500 text-sm">Gaseste orice document dupa numar, tip sau data in cateva secunde.</p>
            </div>
            <div class="bg-white rounded shadow p-6">
                <div class="text-blue-600 text-3xl mb-3">🔒</div>
                <h3 class="font-semibold text-lg mb-2">Acces securizat</h3>
                <p class="text-gray-500 text-sm">Fiecare antreprenor vede doar documentele firmei sale. Contabilul gestioneaza totul.</p>
            </div>
        </div>
    </div>

    {{-- Subsol CTA --}}
    <div class="bg-blue-700 mt-24 py-12 text-center text-white">
        <h3 class="text-2xl font-bold mb-2">Vrei sa colaboram?</h3>
        <p class="text-blue-200 mb-6">Preia controlul asupra documentelor contabile ale firmei tale.</p>
        <a href="#contact"
           class="bg-white text-blue-700 font-semibold px-6 py-3 rounded hover:bg-blue-50">
            Contacteaza-ma acum
        </a>
    </div>

    {{-- Formular contact --}}
{{-- Formular contact --}}
<div id="contact" class="max-w-2xl mx-auto mt-16 mb-20 px-4" style="display:none;">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Trimite-mi un mesaj</h2>
    <p class="text-center text-gray-500 mb-8">Te contactez in cel mai scurt timp.</p>

        @if(session('contact_success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-center">
                {{ session('contact_success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('contact') }}" class="bg-white rounded shadow p-8">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 font-medium">Nume complet *</label>
                <input type="text" name="nume" value="{{ old('nume') }}"
                       class="w-full border border-gray-300 rounded p-2"
                       placeholder="Ion Popescu" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 font-medium">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded p-2"
                       placeholder="ion@firma.ro" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1 font-medium">Telefon</label>
                <input type="text" name="telefon" value="{{ old('telefon') }}"
                       class="w-full border border-gray-300 rounded p-2"
                       placeholder="07xx xxx xxx">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1 font-medium">Mesaj *</label>
                <textarea name="mesaj" rows="4"
                          class="w-full border border-gray-300 rounded p-2"
                          placeholder="Descrieti pe scurt activitatea firmei si ce servicii aveti nevoie..." required>{{ old('mesaj') }}</textarea>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded text-lg hover:bg-blue-700">
                Trimite mesajul
            </button>
        </form>
</div>

<script>
    document.querySelector('a[href="#contact"]').addEventListener('click', function(e) {
        e.preventDefault();
        const formular = document.getElementById('contact');
        formular.style.display = 'block';
        formular.scrollIntoView({ behavior: 'smooth' });
    });

    // Daca sunt erori sau mesaj de succes, arata formularul automat
    @if($errors->any() || session('contact_success'))
        document.getElementById('contact').style.display = 'block';
    @endif
</script>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-6 text-center text-gray-400 text-sm">
        © {{ date('Y') }} ContaBia. Toate drepturile rezervate.
    </footer>

</body>
</html>