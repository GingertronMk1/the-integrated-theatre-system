<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ $trainingCategory->name }}
        </h2>
    </x-slot>

    <ul>
        @forelse($trainingCategory->trainingItems as $item)
            <li>{{ $item->name }}</li>
        @empty
            <li>No items</li>
        @endforelse
    </ul>

</x-app-layout>
