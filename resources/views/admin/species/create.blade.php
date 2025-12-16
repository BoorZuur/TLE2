@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('Nieuw Dier') }}
        </h2>
    </x-slot>
    <div class="flex justify-center items-center ">
        <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-lg">
            <form method="POST" action="{{ route('admin.species.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="vernacularName" class="block mb-1 font-medium">Naam:</label>
                    <input type="text" id="vernacularName" name="vernacularName"
                           value="{{ old('vernacularName') }}"
                           class="w-full border border-gray-300 p-2 rounded">
                    @error('vernacularName')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="scientific_name" class="block mb-1 font-medium">Wetenschappelijke naam:</label>
                    <input type="text" id="scientific_name" name="scientific_name"
                           value="{{ old('scientific_name') }}"
                           class="w-full border border-gray-300 p-2 rounded">
                    @error('scientific_name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="beheerder" class="block mb-1 font-medium">Beheerder:</label>
                    <input type="text" id="beheerder" name="beheerder"
                           value="{{ old('beheerder') }}"
                           class="w-full border border-gray-300 p-2 rounded">
                    @error('beheerder')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="info" class="block mb-1 font-medium">Info:</label>
                    <input type="text" id="info" name="info" value="{{ old('info') }}"
                           class="w-full border border-gray-300 p-2 rounded">
                    @error('info')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="location" class="block mb-1 font-medium">Gebied:</label>
                    <select id="location" name="location" class="w-full border border-gray-300 p-2 rounded">
                        @foreach ($habitats as $habitat)
                            <option
                                value="{{ $habitat->id }}"
                                @selected(old('location') == $habitat->id)
                                data-name="{{ $habitat->name }}"
                            >
                                {{ $habitat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label for="image" class="block mb-1 font-medium">Afbeelding:</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="border rounded p-2">
                    @error('image')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <input type="submit" value="Maak dier"
                           class="w-full bg-[#E2006A] text-white py-3 rounded hover:bg-[#E5438F] cursor-pointer">
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
