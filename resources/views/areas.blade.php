<!doctype html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verzamelde gebieden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-50 min-h-screen">

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('Gebieden') }}
        </h2>
    </x-slot>

    <div class=" flex flex-col items-center pt-2">

        <!-- Area Title -->
        <div class="flex justify-center items-center  space-x-4">
            <h2 id="area-title" class="text-3xl font-bold text-gray-800 m-0">Bos</h2>
            <img id="info-button" alt="info" src="/images/info.png"
                 class="w-10 h-10 cursor-pointer hover:scale-110 transition-transform">
        </div>

        <!-- Info Modal -->
        <div id="info-modal"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-xl p-6 w-11/12 md:w-2/3 lg:w-1/2 relative">
                <!-- Close button -->
                <img id="close-modal" src="/images/close.png" alt="Close"
                     class="w-8 h-8 absolute top-4 right-4 cursor-pointer hover:scale-110 transition-transform">

                <!-- Modal content -->
                <h3 id="modal-title" class="text-2xl font-bold mb-4"></h3>
                <p id="modal-text" class="text-gray-700 py-2"></p>
                <img id="modal-img"
                     class="w-full h-auto pt-4 rounded-lg"
                     src="/images/flamingo.png">
            </div>
        </div>


        <!-- Progress Bar -->
        <div class="w-11/12 md:w-3/4 lg:w-2/3 py-6">
            <div class="w-full bg-red-400 rounded-lg h-6 overflow-hidden">
                <div id="progress-bar" class="bg-green-500 h-6 w-0 transition-all"></div>
            </div>
            <div id="progress-text" class="text-center mt-2 text-gray-800 font-medium">0 / 0 Verzameld</div>
        </div>

        <!-- image-->
        <div class="p-6 bg-green-200 rounded-xl">
            <img id="area-image" class="w-xl h-96 transition-all duration-300" src="" alt="">
        </div>

        <!-- Arrows -->
        <div class="flex gap-4 py-4">
            <button id="prev-area"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                ← Vorige
            </button>
            <button id="next-area"
                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                Volgende →
            </button>
        </div>

    </div>

</x-app-layout>

<script src="{{ asset('js/area.js') }}"></script>
</body>
</html>
