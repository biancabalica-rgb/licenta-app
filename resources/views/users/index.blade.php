<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Utilizatori</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('users.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Adauga utilizator
        </a>

        <table class="w-full mt-6 border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 p-2 text-left">Nume</th>
                    <th class="border border-gray-300 p-2 text-left">Email</th>
                    <th class="border border-gray-300 p-2 text-left">Firme asociate</th>
                    <th class="border border-gray-300 p-2 text-left">Actiuni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 p-2">{{ $user->name }}</td>
                    <td class="border border-gray-300 p-2">{{ $user->email }}</td>
                    <td class="border border-gray-300 p-2">
                        @if($user->firme->isEmpty())
                            <span class="text-gray-400">Nicio firma</span>
                        @else
                            {{ $user->firme->pluck('nume')->join(', ') }}
                        @endif
                    </td>
                    <td class="border border-gray-300 p-2">
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="text-yellow-600 hover:underline mr-2">Editeaza</a>
                        <form action="{{ route('users.destroy', $user->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Stergi utilizatorul?')"
                                    class="text-red-600 hover:underline">Sterge</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>