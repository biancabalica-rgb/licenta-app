<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        @if(auth()->user()->role === 'user')
            @php return redirect()->route('user.dashboard'); @endphp
        @endif
        <p>Bine ai venit!</p>
    </div>
</x-app-layout>