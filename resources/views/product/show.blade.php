<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Shop') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-lime-400 border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">{{ $product->name }}</h1>
                    <div class="flex flex-col md:flex-row md:space-x-6">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-4 md:mb-0 w-full md:w-1/2 h-auto object-cover rounded-lg">
                        <div class="flex flex-col justify-between">
                            <p class="text-gray-700 mb-4">{{ $product->description }}</p>
                            <div>
                                <span class="text-xl font-bold">${{ number_format($product->price, 2) }}</span>
                                <button class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kopen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
