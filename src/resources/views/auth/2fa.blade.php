<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <span class="text-white bold text-xl">{{ config('app.name', 'Dossier') }}</span>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div>
            <div class="mt-4">
                <p>Set up your two factor authentication by scanning the barcode below.</p>
                <div class="flex justify-center my-8">
                    {!! $request->user()->twoFactorQrCodeSvg() !!}
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="/admin" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Complete') }}
                </a>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
