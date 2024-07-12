<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Create Training Item') }}
        </h2>
    </x-slot>

    <x-form.training-item-form :trainingCategories="$trainingCategories" />
</x-app-layout>
