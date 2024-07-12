<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Performances for :title', ['title' => $show->title]) }}
        </h2>
    </x-slot>

    <div class="space-y-2">

        <a href="{{ route('show.performance.create', ['show' => $show]) }}">Add</a>
        @foreach ($show->performances as $performance)
            <div class="flex flex-col">
                <span class="flex justify-between">
                    <h3 class="text-lg">{{ $performance->show_start }}</h3>
                    <a
                        href="{{ route('show.performance.edit', ['show' => $show, 'performance' => $performance]) }}">Edit</a>
                </span>
                <h5 class="text-md">Doors at {{ $performance->doors }}</h5>
                <ul>
                    <li>{{ $performance->venue?->name ?? $show->venue->name }}</li>
                    <li>{{ $performance->venue?->capacity ?? $show->venue->capacity }}</li>
                </ul>
            </div>
        @endforeach
    </div>
</x-app-layout>
