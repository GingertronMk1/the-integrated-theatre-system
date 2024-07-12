<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Edit Session held by :name at :time', [
                'name' => $trainingSession->trainer->name,
                'time' => $trainingSession->happened_at,
            ]) }}
        </h2>
    </x-slot>

    <div>
        <x-form.training-session-form :trainingSession="$trainingSession" :people="$people" :trainingItems="$trainingItems" />
    </div>
</x-app-layout>
