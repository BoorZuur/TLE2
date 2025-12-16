<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                     role="status" aria-live="polite">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                     aria-live="polite">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200
                    {{ $product->requiresRealMoney() ? 'bg-gradient-to-br from-purple-400 to-pink-400' : '' }}
                    {{ $product->requiresQRCode() ? 'bg-gradient-to-br from-yellow-300 to-yellow-500' : '' }}
                    {{ !$product->requiresRealMoney() && !$product->requiresQRCode() ? 'bg-lime-400' : '' }}">

                    <!-- Back Button -->
                    <a href="{{ route('product.index') }}" class="inline-block mb-4 text-gray-700 hover:text-gray-900">
                        ← Terug naar winkel
                    </a>

                    <div class="flex flex-col md:flex-row md:space-x-6">

                        <!-- Product Image -->
                        <div class="md:w-1/2">
                            <div class="relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                     class="w-full h-auto object-cover rounded-lg shadow-lg">
                                <span
                                    class="absolute top-4 left-4 px-3 py-1 rounded text-sm font-bold {{ $product->isAnimal() ? 'bg-green-500' : 'bg-blue-500' }} text-white">
                                    {{ $product->isAnimal() ? '🐾 Dier' : '⚡ Powerup' }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Info + Betalingen / QR -->
                        <div class="md:w-1/2 flex flex-col mt-6 md:mt-0">

                            <!-- Product Details -->
                            <div class="flex-grow">
                                <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                                <p class="text-gray-800 mb-6 text-lg">{{ $product->description }}</p>

                                @if($product->isAnimal())
                                    <div class="bg-white bg-opacity-50 rounded-lg p-4 mb-4">
                                        <h3 class="font-semibold mb-2">🐾 Over dit dier:</h3>
                                        <p class="text-sm text-gray-700">
                                            @if($product->requiresQRCode())
                                                Dit dier wordt toegevoegd aan je verzameling als je de QR-code scant bij
                                                een bezoekerscentrum van Natuurmonumenten. Je kunt ermee spelen en
                                                zorgen!
                                            @else
                                                Dit dier wordt toegevoegd aan je verzameling bij aankoop. Je kunt ermee
                                                spelen en zorgen!
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                <!-- User Coins / QR-instructie -->
                                <div class="bg-white bg-opacity-50 rounded-lg p-4 mb-6">
                                    @if($product->requiresQRCode())
                                        <p class="text-sm text-gray-700">Scan hieronder de QR-code om te zien waar dit
                                            dier zich bevindt!</p>
                                    @else
                                        <p class="text-sm text-gray-700">
                                            Jouw munten: <span class="font-bold text-yellow-600 text-lg"
                                                               aria-label="{{ number_format($user->coins) }} munten">🪙 {{ number_format($user->coins) }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Betalingen / QR -->
                            <div class="mt-6">
                                <div class="bg-white rounded-lg p-6 shadow-lg">

                                    @if($product->requiresQRCode() && $product->qr_filename)
                                        <div class="text-center">
                                            <img src="{{ asset('qrcodes/' . $product->qr_filename) }}"
                                                 alt="QR-code voor {{ $product->name }}"
                                                 class="mx-auto w-64 h-64 object-contain rounded-lg shadow-lg">
                                            <p class="text-sm text-gray-700 mt-3">Scan deze QR-code en zoek jouw
                                                dier!</p>
                                        </div>
                                    @else
                                        <div class="mb-4">
                                            <span class="text-3xl font-bold">
                                                @if($product->requiresRealMoney())
                                                    €{{ number_format($product->price, 2) }}
                                                @else
                                                    🪙 {{ number_format($product->price, 0) }}
                                                @endif
                                            </span>
                                            <span class="text-gray-600 ml-2">
                                                {{ $product->requiresRealMoney() ? '(Echt geld)' : '(Munten)' }}
                                            </span>
                                        </div>

                                        @if($hasPurchased)
                                            <div
                                                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"
                                                role="status" aria-live="polite">
                                                <p class="font-semibold">✓ Je hebt dit product al gekocht!</p>
                                            </div>
                                        @else
                                            @if($product->canBuyWithCoins())
                                                <form method="POST" action="{{ route('product.purchase', $product) }}">
                                                    @csrf
                                                    @if($user->coins >= $product->price)
                                                        <button type="submit"
                                                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 px-6 rounded-lg text-lg transition-colors">
                                                            🪙 Koop met munten
                                                        </button>
                                                    @else
                                                        <button type="button" disabled aria-disabled="true"
                                                                class="w-full bg-gray-400 text-white font-bold py-4 px-6 rounded-lg text-lg cursor-not-allowed">
                                                            ❌ Niet genoeg munten
                                                        </button>
                                                        <p class="text-red-600 text-sm mt-2">Je hebt
                                                            nog {{ number_format($product->price - $user->coins) }}
                                                            munten nodig!</p>
                                                    @endif
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('product.purchase', $product) }}"
                                                      id="payment-form">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2"
                                                               for="payment_method">Betaalmethode:</label>
                                                        <select name="payment_method" id="payment_method" required
                                                                aria-required="true"
                                                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                                            <option value="">Kies een betaalmethode</option>
                                                            <option value="ideal">iDEAL</option>
                                                            <option value="creditcard">Creditcard</option>
                                                            <option value="paypal">PayPal</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit"
                                                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg text-lg transition-colors">
                                                        💳 Koop met geld (€{{ number_format($product->price, 2) }})
                                                    </button>
                                                    <p class="text-xs text-gray-600 mt-2 text-center">* Met deze aankoop
                                                        steun je Natuurmonumenten.</p>
                                                </form>
                                            @endif
                                        @endif
                                    @endif

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
