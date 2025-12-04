<x-guest-layout>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Naam')" class="text-gray-900" />
                <x-text-input id="username" class="block mt-1 w-full bg-white border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-gray-900" />
                <x-text-input id="email" class="block mt-1 w-full bg-white border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Wachtwoord')" class="text-[#89B934]" />

                <x-text-input id="password" class="block mt-1 w-full bg-white border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500"
                              type="password"
                              name="password"
                              required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Herhaal Wachtwoord')" class="text-gray-900" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white border-gray-300 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-900 hover:text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Al een account?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Registreer') }}
                </x-primary-button>
            </div>
        </form>
</x-guest-layout>
