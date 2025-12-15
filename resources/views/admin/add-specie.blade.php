<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('Diersoort Toevoegen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-bold">Er zijn fouten opgetreden:</p>
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-xl font-bold mb-6">Nieuwe Diersoort</h3>

                <form action="{{ route('admin.storeSpecie') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Naam <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">
                    </div>

                    {{--                    deze veranderen later--}}
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Habitat Tag <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="habitat_tag" required value="{{ old('habitat_tag') }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Wetenschappelijke Naam
                        </label>
                        <input type="text" name="scientific_name" value="{{ old('scientific_name', '-') }}" required
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Afbeelding URL <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="image" value="{{ old('image', '/images/placeholder.png') }}" required
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Beheerder
                        </label>
                        <input type="text" name="beheerder" value="{{ old('beheerder', '-') }}" required
                               class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Informatie
                        </label>
                        <textarea name="info" rows="4"
                                  class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">{{ old('info', '-') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="locked"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-green-500">
                            <option value="1" selected>Vergrendeld</option>
                            <option value="0">Ontgrendeld</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Annuleren
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                            Toevoegen
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
