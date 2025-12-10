<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Profiel Informatie') }}
        </h2>

        <p class="mt-1 text-sm text-white">
            {{ __("Update je profiel informatie en email adres.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label class="text-white" for="username" :value="__('Naam')"/>
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                          :value="old('username', $user->username)"
                          required autofocus autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('username')"/>
        </div>

        <div>
            <x-input-label class="text-white" for="email" :value="__('Email')"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="username"/>
            <x-input-error class="mt-2" :messages="$errors->get('email')"/>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-white">
                        {{ __('Je email adres is niet bevestigd.') }}

                        <button form="send-verification"
                                class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Klik hier om de verificatie email opnieuw te sturen.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Een nieuwe verificatie link is opnieuw naar je email adres gestuurd.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Opslaan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-white"
                >{{ __('Opgeslagen.') }}</p>
            @endif
        </div>
    </form>
</section>
