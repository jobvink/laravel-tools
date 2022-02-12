<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <span class="text-purple-700 bold text-xl">{{ config('app.name', 'Dossier') }}</span>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="/two-factor-challenge">
            @csrf

            <div class="mt-4">
                @csrf

                <label>{{ __('Code') }}</label>
                <x-input id="code" class="block mt-1 w-full"
                         type="string"
                         name="code"
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
