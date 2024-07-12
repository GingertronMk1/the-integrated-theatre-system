<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Update :name', ['name' => $trainingItem->name]) }}
        </h2>
    </x-slot>

    <x-form.training-item-form :trainingItem="$trainingItem" :trainingCategories="$trainingCategories" />
</x-app-layout>
