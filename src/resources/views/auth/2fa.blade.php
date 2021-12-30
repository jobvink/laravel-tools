<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <span class="text-white bold text-xl">{{ config('app.name', 'Dossier') }}</span>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mt-4">
                <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                <div>
                    <img src="{{ $QR_Image }}">
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Complete') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
