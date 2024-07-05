<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Training Session') }}
        </h2>
    </x-slot>

    <div>
        <x-form.training-session-form :people="$people" :trainingItems="$trainingItems" />
    </div>
</x-app-layout>
