<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <span class="text-white bold text-xl">{{ config('app.name', 'Dossier') }}</span>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register.completed', ['id' => request()->route('id'), 'hash' => request()->route('hash')]) }}">
            @csrf
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Complete') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
