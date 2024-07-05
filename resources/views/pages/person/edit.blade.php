<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update :name', ['name' => $person->name]) }}
        </h2>
    </x-slot>

    <div>
        <x-form.person-form :person="$person" :users="$users" />
    </div>
</x-app-layout>
