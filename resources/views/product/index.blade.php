<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('Winkel') }}
        </h2>
    </x-slot>
    
    <main id="main-content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-lime-400 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">Welkom in de winkel!</h3>
                                <p class="text-black">Koop dieren en powerups om je spel te verbeteren</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold">Jouw munten:</p>
                                <p class="text-3xl font-bold text-yellow-600">🪙 {{ number_format($user->coins) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="mt-6 bg-white rounded-lg shadow-sm p-4">
                    <div class="flex flex-wrap gap-4" id="filters">
                        <button onclick="filterProducts('all')"
                                class="filter-btn active px-4 py-2 rounded-lg bg-lime-400 hover:bg-lime-500 font-semibold transform transition hover:scale-105 focus-visible:scale-105">
                            Alle producten
                        </button>
                        <button onclick="filterProducts('animal')"
                                class="filter-btn px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold transform transition hover:scale-105 focus-visible:scale-105">
                            🐾 Dieren
                        </button>
                        <button onclick="filterProducts('powerup')"
                                class="filter-btn px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold transform transition hover:scale-105 focus-visible:scale-105">
                            ⚡ Powerups
                        </button>
                        <button onclick="filterProducts('coins')"
                                class="filter-btn px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold transform transition hover:scale-105 focus-visible:scale-105">
                            🪙 Met munten
                        </button>
                        <button onclick="filterProducts('real_money')"
                                class="filter-btn px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold transform transition hover:scale-105 focus-visible:scale-105">
                            💳 Met geld
                        </button>
                        <button onclick="filterProducts('qr')"
                                class="filter-btn px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold transform transition hover:scale-105 focus-visible:scale-105">
                            <x-mdi-qrcode class="w-5"></x-mdi-qrcode>
                            QR-code
                        </button>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @if($products->isEmpty())
                        <p class="text-gray-700 col-span-full text-center py-8">Er zijn geen producten beschikbaar.</p>
                    @else
                        @foreach($products as $product)
                            <div
                                class="product-card border rounded-lg p-4 flex flex-col shadow-lg hover:shadow-xl transition-shadow
                                {{ $product->requiresRealMoney() ? 'bg-gradient-to-br from-purple-400 to-pink-400' : '' }}
                                {{ $product->requiresQRCode() ? 'bg-gradient-to-br from-yellow-300 to-yellow-500' : '' }}
                                {{ !$product->requiresRealMoney() && !$product->requiresQRCode() ? 'bg-lime-400' : '' }}"
                                data-type="{{ $product->product_type }}"
                                data-currency="{{ $product->currency_type }}">
                                <a href="{{ route('product.show', $product) }}" class="flex flex-col h-full">
                                    <!-- Product Image -->
                                    <div class="relative">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                             class="mb-4 h-48 w-full object-cover rounded">
                                        <!-- Product Type Badge -->
                                        <span
                                            class="absolute top-2 left-2 px-2 py-1 rounded text-xs font-bold {{ $product->isAnimal() ? 'bg-green-500' : 'bg-blue-500' }} text-white">
                                        {{ $product->isAnimal() ? '🐾 Dier' : '⚡ Powerup' }}
                                        </span>
                                        <!-- Currency Badge -->
                                        <span
                                            class="absolute top-2 right-2 px-2 py-1 rounded text-xs font-bold {{ $product->requiresRealMoney() ? 'bg-purple-600' : 'bg-yellow-500' }} text-white">
                                        @switch($product)
                                                @case($product->requiresRealMoney())
                                                    💳
                                                    @break
                                                @case($product->canBuyWithCoins())
                                                    🪙
                                                    @break
                                                @case($product->requiresQRCode())
                                                    <x-mdi-qrcode class="w-5"/>
                                                    @break
                                            @endswitch
                                        </span>
                                    </div>

                                    <!-- Product Info -->
                                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-700 mb-4 flex-grow text-sm">{{ Str::limit($product->description, 80) }}</p>

                                    <!-- Price and Button -->
                                    <div class="mt-auto">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xl font-bold">
                                                @if($product->requiresRealMoney())
                                                    €{{ number_format($product->price, 2) }}
                                                @elseif($product->requiresQRCode())
                                                    <x-mdi-qrcode-scan class="w-5"/>
                                                @else
                                                    🪙 {{ number_format($product->price, 0) }}
                                                @endif
                                            </span>

                                            @if($user->hasPurchased($product))
                                                <span class="bg-green-500 text-white px-3 py-2 rounded text-sm font-semibold">✓ Gekocht</span>
                                            @else
                                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm font-semibold transform transition hover:scale-105 focus-visible:scale-105">
                                                    Bekijken
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        function filterProducts(filter) {
            const cards = document.querySelectorAll('.product-card');
            const buttons = document.querySelectorAll('.filter-btn');

            // Update button styles
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-lime-400');
                btn.classList.add('bg-gray-200');
            });
            event.target.classList.add('active', 'bg-lime-400');
            event.target.classList.remove('bg-gray-200');

            // Filter cards
            cards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = 'block';
                } else if (filter === 'animal' || filter === 'powerup') {
                    card.style.display = card.dataset.type === filter ? 'block' : 'none';
                } else if (filter === 'coins' || filter === 'real_money' || filter === 'qr') {
                    card.style.display = card.dataset.currency === filter ? 'block' : 'none';
                }
            });
        }
    </script>
</x-app-layout>
