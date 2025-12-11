<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-6">
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                <tr class="text-left text-black uppercase text-sm">
                    <th class="py-3 px-4 border-b">ID</th>
                    <th class="py-3 px-4 border-b">Naam</th>
                    <th class="py-3 px-4 border-b">Wetenschappelijke naam</th>
                    <th class="py-3 px-4 border-b">Gebied</th>
                    <th class="py-3 px-4 border-b">Beheerder</th>
                    <th class="py-3 px-4 border-b">Informatie</th>
                    <th class="py-3 px-4 border-b text-center">Status</th>
                    <th class="py-3 px-4 border-b text-center">Bewerk</th>
                    <th class="py-3 px-4 border-b text-center">Verwijder</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($species as $specie)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $specie->id }}</td>
                        <td class="py-3 px-4 font-semibold text-gray-900">{{ $specie->name }}</td>
                        <td class="py-3 px-4">{{ $specie->scientific_name }}</td>
                        <td class="py-3 px-4">{{ $specie->habitat->name }}</td>
                        <td class="py-3 px-4">{{ $specie->beheerder ?? 'Unknown' }}</td>
                        <td class="py-3 px-4">{{  Str::limit($specie->info, 40) }}</td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('species.toggleStatus', $specie->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $specie->status == 1 ? 'bg-[#E2006A] text-white' : 'bg-blue-600 text-white' }}">
                                    {{ $specie->status == 1 ? 'Gepubliceerd' : 'Ongepubliceerd' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-4 text-center">
                            {{--                            <a href="{{ route('admin.species.edit', $specie->id) }}"--}}
                            {{--                               class="text-blue-600 hover:underline">
                                                        Bewerk</a>--}}
                            <a href="{{ route('admin.edit', $specie->id) }}" class="text-blue-600 hover:underline">Bewerk</a>

                        </td>
                        {{--                        <td class="py-3 px-4 text-center">--}}
                        {{--                            <form method="POST" action="{{ route('species.destroy', $specie->id) }}">--}}
                        {{--                                @csrf--}}
                        {{--                                @method('DELETE')--}}
                        {{--                                <button type="submit"--}}
                        {{--                                        class="text-red-600 hover:underline"--}}
                        {{--                                        onclick="return confirm('Weet je het zeker dat je dit dier wilt verwijderen?')">--}}
                        {{--                                    Verwijder--}}
                        {{--                                </button>--}}
                        {{--                            </form>--}}
                        {{--                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
