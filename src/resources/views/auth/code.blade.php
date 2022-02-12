<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <span class="text-purple-700 bold text-xl">{{ config('app.name', 'Dossier') }}</span>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('2fa') }}">
            @csrf

            <!-- Password -->
            <div class="mt-4">
                <x-label for="one_time_password" :value="__('one_time_password')" />

                <x-input id="one_time_password" class="block mt-1 w-full"
                                type="string"
                                name="one_time_password"
                                required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Login') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
