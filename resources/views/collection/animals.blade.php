<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl leading-tight">
            {{ __('Verzameling') }}
        </h1>
    </x-slot>
    <main id="main-content" class="container mx-auto p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dieren binnen geselecteerde gebieden</h1>
        </header>

        <section class="mb-6">
            <form class="flex items-center gap-3">
                <label for="region" class="font-semibold text-gray-800">
                    Selecteer een gebied:
                </label>

                <div class="relative">
                    <select
                        id="region"
                        class="
                appearance-none
                bg-lime-300 hover:bg-lime-300
                text-black font-bold
                px-4 py-2 pr-10
                rounded-lg
                shadow
                cursor-pointer
                focus:outline-none
                focus:ring-2 focus:ring-lime-300
                transition
            "
                        onchange="this.form.submit()"
                    >
                        <option value="">Alle gebieden</option>
                        @foreach(\App\Models\Habitat::orderBy('name')->get() as $habitat)
                            <option value="{{ $habitat->name }}"
                                {{ request('region') == $habitat->name ? 'selected' : '' }}>
                                {{ $habitat->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        ▼
                    </div>
                </div>
            </form>

            <div id="progress-bar">

            </div>
        </section>

        <section>
            <div id="animals-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
        </section>

        <div id="animal-modal"
             class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded p-6 w-[600px] relative">
                <button id="close-modal"
                        class="absolute top-2 right-2 text-black hover:text-black text-xl">&times;
                </button>

                <div class="flex justify-center">
                    <img id="modal-image" class="w-48 h-48 object-cover rounded mb-4" alt="animal image"/>
                </div>

                <h2 id="modal-name" class="text-xl font-bold mb-1"></h2>
                <p id="modal-scientific" class="italic text-black text-sm mb-3"></p>

                <p><strong>Gebied:</strong> <span id="modal-location"></span></p>
                <p><strong>Beheerder:</strong> <span id="modal-beheerder"></span></p>
                <p class="mt-4 text-black" id="modal-info"></p>
            </div>
        </div>
    </main>

    <script defer src="/js/collection.js"></script>
</x-app-layout>
