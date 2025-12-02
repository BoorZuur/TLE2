<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 ring-1 ring-gray-100">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Welcome back</h2>
                <p class="mt-1 text-sm text-gray-500">Sign in to your account to continue</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700"/>
                    <x-text-input id="email"
                                  class="block mt-1 w-full border border-gray-200 bg-white placeholder-gray-400 text-gray-800 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300"
                                  type="email" name="email" :value="old('email')" required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700"/>

                    <x-text-input id="password"
                                  class="block mt-1 w-full border border-gray-200 bg-white placeholder-gray-400 text-gray-800 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-300"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600"/>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-200"
                               name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-700 font-medium"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-300 text-white rounded-lg py-2">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
