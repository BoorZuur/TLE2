<nav class="bg-blue-900 border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <div class="flex items-center space-x-8">
            <a href="{{ url('/') }}" class="text-xl text-white font-semibold">
                NMklikker
            </a>
            {{--            <x-menu-link href="{{ route('') }}" :active="Route::is('')">--}}
            <x-menu-link>
                Dieren
            </x-menu-link>

            {{--            <x-menu-link href="{{ route('') }}" :active="Route::is('')">--}}
            <x-menu-link>
                Gebieden
            </x-menu-link>

            {{--            <x-menu-link href="{{ route('') }}" :active="Route::is('')">--}}
            <x-menu-link>
                Verzameling
            </x-menu-link>

            {{--            <x-menu-link href="{{ route('') }}" :active="Route::is('')">--}}
            <x-menu-link>
                Winkel
            </x-menu-link>

        </div>
        <div class="flex items-center space-x-4">
            @auth
                <a href="{{ route('profile.edit') }}" class="text-white">{{ Auth::user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-500 hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-gray-300">Login</a>
                <a href="{{ route('register') }}" class="text-white hover:text-gray-300">Register</a>
            @endauth
        </div>
    </div>
</nav>
