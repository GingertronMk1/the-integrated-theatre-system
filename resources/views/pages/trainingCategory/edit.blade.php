<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Update :name', ['name' => $trainingCategory->name]) }}
        </h2>
    </x-slot>

    <x-form.training-category-form class="training-category-form" :category="$trainingCategory" />
</x-app-layout>
