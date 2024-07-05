<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performances for :title', ['title' => $show->title]) }}
        </h2>
    </x-slot>

    <div class="space-y-2">

    @foreach($show->performances as $performance)
        <div class="flex flex-col">
            <h3 class="text-lg">{{ $performance->show_start }}</h3>
            <h5 class="text-md">Doors at {{ $performance->doors }}</h5>
            <ul>
                <li>{{ $performance->location }}</li>
                <li>{{ $performance->capacity }}</li>
            </ul>
        </div>
    @endforeach
    </div>
</x-app-layout>
