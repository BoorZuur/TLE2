<nav class="bg-[#89B934] border-b border-gray-200">
    <div class="max-w-8xl gap-4 mx-auto px-4 sm:px-6 lg:px-8 flex items-center h-16">
        <button id="menu-button" class="text-black focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        @isset($header)
            <header class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 bowlby-one-sc-regular ">
                <h2 class="text-black">{{ $header }}</h2>
            </header>
        @endisset
    </div>

    <div id="mobile-menu" class="fixed inset-0 z-40 hidden">
        <div id="menu-overlay" class="fixed inset-0 bg-black bg-opacity-50"></div>

        <div id="menu-panel"
             class="fixed top-0 left-0 w-72 h-full bg-white shadow-lg transform -translate-x-full transition-transform duration-300">
            <div class="bg-[#89B934] p-4 flex justify-between items-center border-b">
                <h2 class="text-lg bowlby-one-sc-regular">Menu</h2>
                <button id="menu-close" class="text-black text-2xl">&times;</button>
            </div>

            <nav class="p-3 flex flex-col gap-2 items-center ">
                <x-menu-link href="{{ route('home') }}" :active="Route::is('home')">
                    <div class="flex gap-9 py-3 w-56 text-center sm:rounded-lg r-10 bg-[#89B934] hover:bg-[#6F962B]">
                        <img src="{{ asset('images/home-icon.webp') }}" alt="House icon"
                             class="ml-3 w-8 h-8 object-cover">
                        Dieren
                    </div>
                </x-menu-link>

                <x-menu-link href="{{ route('areas') }}" :active="Route::is('areas')">
                    <div class="flex gap-9 py-3 w-56 text-center sm:rounded-lg r-10 bg-[#319E88] hover:bg-[#007866]">
                        <img src="{{ asset('images/tree-icon.png') }}" alt="Tree icon"
                             class="ml-3 w-8 h-8 object-cover">
                        Gebieden
                    </div>
                </x-menu-link>

                <x-menu-link href="{{ route('collectie') }}" :active="Route::is('collectie')">
                    <div class="flex gap-9 py-3 w-56 text-center sm:rounded-lg r-10 bg-[#89B934] hover:bg-[#6F962B]">
                        <img src="{{ asset('images/list-icon.png') }}" alt="Collection icon"
                             class="ml-3 w-8 h-8 object-cover">
                        Verzameling
                    </div>
                </x-menu-link>

                <x-menu-link href="{{ route('product.index') }}" :active="Route::is('product.index')">
                    <div class="flex gap-9 py-3 w-56 text-center sm:rounded-lg r-10 bg-[#319E88] hover:bg-[#007866]">
                        <img src="{{ asset('images/shop-icon.png') }}" alt="Shop icon"
                             class="ml-3 w-8 h-8 object-cover">
                        Winkel
                    </div>
                </x-menu-link>

                @if (Route::has('login'))
                    @auth
                        @if (Auth::user()->is_admin == 1)
                            <x-menu-link href="{{ route('admin.index') }}" :active="Route::is('admin.index')">
                                <div
                                    class="flex gap-9 py-3 w-56 text-center sm:rounded-lg r-10 bg-[#89B934] hover:bg-[#6F962B]">
                                    <img src="{{ asset('images/admin-icon.png') }}" alt="Admin icon"
                                         class="ml-3 w-8 h-8 object-cover"> Admin
                                </div>
                            </x-menu-link>

                        @endif
                    @endauth
                @endif

                <div class="border-t mt-4 pt-4 flex flex-col space-y-2">
                    @auth
                        <a href="{{ route('profile.edit') }}"
                           class="text-black hover:underline">{{ Auth::user()->username }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-red-500 hover:underline">Uitloggen</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-black hover:text-gray-700">Login</a>
                        <a href="{{ route('register') }}" class="text-black hover:text-gray-700">Register</a>
                    @endauth
                </div>
            </nav>
        </div>
    </div>
</nav>

<script>
    const menuButton = document.getElementById('menu-button');
    const menuClose = document.getElementById('menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuPanel = document.getElementById('menu-panel');
    const menuOverlay = document.getElementById('menu-overlay');

    function openMenu() {
        mobileMenu.classList.remove('hidden');
        setTimeout(() => {
            menuPanel.classList.remove('-translate-x-full');
        }, 10);
    }

    function closeMenu() {
        menuPanel.classList.add('-translate-x-full');
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
        }, 300);
    }

    menuButton.addEventListener('click', openMenu);
    menuClose.addEventListener('click', closeMenu);
    menuOverlay.addEventListener('click', closeMenu);
</script>
