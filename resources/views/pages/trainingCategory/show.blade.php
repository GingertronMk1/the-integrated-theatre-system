<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
