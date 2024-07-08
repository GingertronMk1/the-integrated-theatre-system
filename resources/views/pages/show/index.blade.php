<x-app-layout innerClass="p-show-index">
    <x-slot name="header">
        <h2>
            {{ __('Shows') }}
        </h2>
    </x-slot>

            <a class="c-button" href="{{ route('show.create') }}">
                Add
                <i class="fa-solid fa-plus"></i>
            </a>
            @foreach ($shows as $show)
                <div class="p-show-index__show">
                    <span class="p-show-index__show-header">
                        <h3 class="text-xl">{{ $show->title }}</h3>
                        <a class="c-button" href="{{ route('show.edit', ['show' => $show]) }}">Edit</a>
                    </span>
                    <div class="p-show-index__show-details">
                        <div class="flex-1 px-2">
                            @toparagraphs($show->description)
                        </div>
                        <div class="flex-1 px-2">
                            <ul>
                                <li>Year: {{ $show->year }}</li>
                                <li>Season: {{ $show->season ?? 'Unknown' }}</li>
                                <li><a href="{{ route('show.performance.index', ['show' => $show]) }}">Performances</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
</x-app-layout>
