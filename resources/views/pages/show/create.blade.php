<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Create Show') }}
        </h2>
    </x-slot>

    <x-form.show-form :$seasons :$venues />
</x-app-layout>
