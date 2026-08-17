<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Notificari</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <p class="text-gray-500 text-sm">{{ $notificari->count() }} notificari total</p>
            @if($notificari->isNotEmpty())
                <form action="{{ route('notificari.stergeToate') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Stergi toate notificarile?')"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                        Sterge toate
                    </button>
                </form>
            @endif
        </div>

        @forelse($notificari as $notificare)
            <div class="bg-white rounded shadow p-4 mb-3 flex justify-between items-start
                        {{ $notificare->citita ? 'opacity-60' : 'border-l-4 border-blue-600' }}">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        @if($notificare->tip === 'document')
                            <span class="text-blue-600">📄</span>
                        @else
                            <span class="text-green-600">✉️</span>
                        @endif
                        <p class="font-semibold">{{ $notificare->titlu }}</p>
                        @if(!$notificare->citita)
                            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full">Nou</span>
                        @endif
                    </div>
                    <p class="text-gray-600 text-sm">{{ $notificare->mesaj }}</p>
                    <p class="text-gray-400 text-xs mt-1">{{ $notificare->created_at->format('d.m.Y H:i') }}</p>
                </div>
                <form action="{{ route('notificari.destroy', $notificare->id) }}" method="POST" class="ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 text-sm">✕</button>
                </form>
            </div>
        @empty
            <div class="bg-white rounded shadow p-6 text-center text-gray-500">
                Nu ai notificari noi.
            </div>
        @endforelse

    </div>
</x-app-layout>