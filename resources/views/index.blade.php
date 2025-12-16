<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NMklikker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            height: 100vh;
            max-height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<nav class="bg-[#89B934] shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="/">
                <x-application-logo class="w-52 fill-current text-gray-500"/>
            </a>
            <div class="flex-grow"></div>
            <div class="flex space-x-4">
                <a href="{{ route('login') }}"
                   class="px-4 py-2 text-black hover:text-[#36298B] transition">Inloggen</a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 bg-[#E2006A] text-white rounded-lg hover:bg-[#B3004E] transition">Registreren</a>
            </div>
        </div>
    </div>
</nav>
<header class="bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6 py-16 text-center">
        <div class="mx-auto max-w-lg">
            <h1 class="text-3xl font-bold text-black dark:text-white md:text-4xl">Welkom bij <span
                    class="bowlby-one-sc-regular">NMklikker</span></h1>
            <p class="mt-6 text-black dark:text-gray-300">NMklikker is een clicker game waar je dieren en gebieden
                van Natuurmonumenten ingame kan verzamelen.</p>
            <p class="mt-6 text-black dark:text-gray-300">Je leert welke dieren in welke soorten gebieden binnen
                Nederland kunnen leven door ze in de gebieden te verzorgen waar ze thuis horen. Door dieren te verzorgen
                vergroot je de biodiversiteit binnen die gebieden.</p>
            <a href="{{ route('register') }}">
            <button
                class="mt-6 rounded-lg bg-[#E2006A] hover:bg-[#B3004E] px-6 py-2.5 text-center text-sm font-medium capitalize leading-5 text-white focus:outline-none lg:mx-0 lg:w-auto">
                <span>Start met spelen</span>
            </button>
            </a>
        </div>
    </div>
</header>

<main id="main-content" class="bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6 py-10">
        <h2 class="text-center text-3xl font-semibold capitalize text-black dark:text-white lg:text-4xl">Hoe speel je
            het spel?</h2>

        <div class="mt-8 grid grid-cols-1 gap-8 md:grid-cols-2 xl:mt-12 xl:grid-cols-3">
            <div class="rounded-lg border p-8 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-black dark:text-white">1. Aai je dier</h3>
                <p class="mt-4 text-black dark:text-gray-300">
                    Verdien muntjes door op je dier te klikken. Hoe meer je aait, hoe meer je verdient!
                </p>
            </div>

            <div class="rounded-lg border p-8 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-black dark:text-white">2. Verzorg je dier</h3>
                <p class="mt-4 text-black dark:text-gray-300">
                    Houd je dieren gelukkig en gezond door ze te voeren, te wassen en te laten rusten.
                </p>
            </div>

            <div class="rounded-lg border p-8 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-black dark:text-white">3. Koop nieuwe dieren</h3>
                <p class="mt-4 text-black dark:text-gray-300">
                    Gebruik je verdiende muntjes om nieuwe dieren en items te kopen in de winkel.
                </p>
            </div>
        </div>

        <div class="mt-16">
            <h2 class="text-center text-3xl font-semibold capitalize text-black dark:text-white lg:text-4xl">
                Verschillende pagina's</h2>
            <div class="mt-8 grid grid-cols-1 gap-8 md:grid-cols-2 xl:mt-12">
                <div class="rounded-lg border p-8 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-black dark:text-white">Dieren</h3>
                    <p class="mt-4 text-black dark:text-gray-300">
                        Verzorg je dieren door ze te voeren, wassen en laten rusten om ze gelukkig en gezond te houden.
                    </p>
                </div>
                <div class="rounded-lg border p-8 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-black dark:text-white">Gebieden</h3>
                    <p class="mt-4 text-black dark:text-gray-300">
                        Ontdek verschillende natuurgebieden en plaats je dieren in hun natuurlijke habitat.
                    </p>
                </div>
                <div class="rounded-lg border p-8 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-black dark:text-white">Collectie</h3>
                    <p class="mt-4 text-black dark:text-gray-300">
                        Bekijk je verzameling dieren, leer meer over hun eigenschappen, waar ze leven en hun bedreigde
                        status.
                    </p>
                </div>
                <div class="rounded-lg border p-8 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-black dark:text-white">Winkel</h3>
                    <p class="mt-4 text-black dark:text-gray-300">
                        Verzamel nieuwe dieren en andere items om je verzameling uit te breiden.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="bg-[#E2006A] text-center p-4">
        <p class="text-white">&copy; 2025 NMklikker. Alle rechten voorbehouden.</p>
    </div>
</footer>
</body>
</html>
