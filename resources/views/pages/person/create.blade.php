<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Person') }}
        </h2>
    </x-slot>

    <div>
        <x-form.person-form :users="$users" />
    </div>
</x-app-layout>
