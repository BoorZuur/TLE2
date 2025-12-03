<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Verander wachtwoord') }}
        </h2>

        <p class="mt-1 text-sm text-white">
            {{ __('Zorg ervoor dat je account een lang, willekeurig wachtwoord gebruikt om veilig te blijven.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label class="text-white" for="update_password_current_password" :value="__('Huidig Wachtwoord')"/>
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                          class="mt-1 block w-full" autocomplete="current-password"/>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2"/>
        </div>

        <div>
            <x-input-label class="text-white" for="update_password_password" :value="__('Nieuw Wachtwoord')"/>
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full"
                          autocomplete="new-password"/>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2"/>
        </div>

        <div>
            <x-input-label class="text-white" for="update_password_password_confirmation"
                           :value="__('Bevestig Wachtwoord')"/>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                          class="mt-1 block w-full" autocomplete="new-password"/>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Opslaan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
