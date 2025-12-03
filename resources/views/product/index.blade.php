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
                    <p>Welkom in de winkel!</p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @if($products->isEmpty())
                    <p class="text-gray-700">Er zijn geen producten beschikbaar.</p>
                @else
                @foreach($products as $product)
                    <div class="border bg-lime-400 rounded-lg p-4 flex flex-col">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-4 h-48 w-full object-cover">
                        <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-700 mb-4">{{ $product->description }}</p>
                        <div class="mt-auto">
                            <span class="text-xl font-bold">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('product.show', $product) }}" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kopen</a>
                        </div>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
