<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Update :name', ['name' => $person->name]) }}
        </h2>
    </x-slot>

    <div>
        <x-form.person-form :person="$person" :users="$users" />
    </div>
</x-app-layout>
