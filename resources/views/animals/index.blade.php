<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl leading-tight">
            {{ __('Kies een dier') }}
        </h1>
    </x-slot>
    <!doctype html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mijn Dieren</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100">

    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold mb-8">Mijn dieren</h1>

        @if ($animals->isEmpty())
            <p class="text-gray-600">Je hebt nog geen dieren.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($animals as $animal)
                    <a href="{{ url('/animal/' . $animal->id . '/show') }}" class="block bg-white rounded-lg shadow p-4 hover:shadow-lg hover:scale-[1.01] transition">
                        <div class="">
                            <div class="mb-4">
                                <img
                                    src="{{ asset($animal->species->image) }}"
                                    alt="{{ $animal->name }}"
                                    class="w-full h-48 object-cover rounded"
                                >
                            </div>

                            <h2 class="text-xl font-semibold">{{ $animal->name }}</h2>

                            <p class="text-sm text-gray-600 mb-2">
                                Soort: {{ $animal->species->name ?? 'Onbekend' }}
                            </p>

                            <div class="text-sm space-y-1">
                                <p>Geluk: {{ $animal->happiness }}</p>
                                <p>Honger: {{ $animal->hunger }}</p>
                                <p>Schoonheid: {{ $animal->cleanliness }}</p>
                            </div>

                            <p class="text-xs text-gray-400 mt-3">
                                Geadopteerd op: {{ $animal->adopted_at?->format('d-m-Y') }}
                            </p>
                        </div>
                    </a>


                @endforeach
            </div>
        @endif
    </div>

    </body>
    </html>
</x-app-layout>




