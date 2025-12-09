{{--<!DOCTYPE html>--}}
{{--<html lang="nl">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Dieren Collectie</title>--}}
{{--    <script defer type="module" src="/js/collection.js"></script>--}}
{{--    @vite(['resources/css/app.css'])--}}
{{--</head>--}}
{{--<body class="bg-gray-100 min-h-screen">--}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('Verzameling') }}
        </h2>
    </x-slot>
    <script defer type="module" src="/js/collection.js"></script>
    <main class="container mx-auto p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dieren binnen geselecteerde gebieden</h1>
        </header>

        <section class="mb-6">
            <form class="flex items-center gap-2">
                <label for="region" class="font-semibold">Selecteer een gebied:</label>
                <select id="region" class="border rounded p-1">
                    <option value="">Alle gebieden</option>
                    @foreach(config('animals.defaultLocalities', []) as $locality)
                        <option value="{{ $locality }}" {{ request('region') == $locality ? 'selected' : '' }}>
                            {{ $locality }}
                        </option>
                    @endforeach
                </select>
            </form>
        </section>

        <section>
            <div id="animals-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
        </section>
    </main>

    {{--</body>--}}
    {{--</html>--}}
</x-app-layout>
