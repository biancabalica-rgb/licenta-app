<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @if(auth()->check() && auth()->user()->role === 'admin')
            @php
                $notificariNoi = \App\Models\Notificare::where('citita', false)->count();
            @endphp
            @if($notificariNoi > 0)
                <div id="popup-notificari"
                     class="fixed bottom-6 right-6 bg-white rounded-lg shadow-lg border-l-4 border-blue-600 p-4 flex items-center gap-4 z-50"
                     style="max-width: 320px;">
                    <span class="text-2xl">🔔</span>
                    <div>
                        <p class="font-semibold text-gray-800">
                            Ai {{ $notificariNoi }} notificar{{ $notificariNoi == 1 ? 'e noua' : 'i noi' }}
                        </p>
                        <a href="{{ route('notificari.index') }}"
                           class="text-blue-600 text-sm hover:underline">
                            Vezi notificarile
                        </a>
                    </div>
                    <button onclick="document.getElementById('popup-notificari').style.display='none'"
                            class="text-gray-400 hover:text-gray-600 ml-auto text-lg">✕</button>
                </div>
            @endif
        @endif
    </body>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
