<x-app-layout innerClass="p-show-index">
    <x-slot name="header">
        <h2>
            {{ __('Shows') }}
        </h2>
    </x-slot>

    <a class="btn btn-primary" href="{{ route('show.create') }}">
        Add
        <i class="fa-solid fa-plus"></i>
    </a>
    @foreach ($shows as $show)
        <div class="card mt-3">
            <div class="card-header d-flex">
                <h3 class="text-xl">{{ $show->title }}</h3>
                <a class="btn btn-primary ms-auto" href="{{ route('show.edit', ['show' => $show]) }}">Edit</a>
            </div>
            <div class="card-body row">
                <div class="col-8">
                    @toparagraphs($show->description)
                </div>
                <div class="col-4">
                    <ul>
                        <li>Year: {{ $show->year }}</li>
                        <li><a href="{{ route('season.show', ['season' => $show->season]) }}">
                                Season: {{ $show->season->name }}
                                <i style="color: {{ $show->season->colour }}" class="fa-solid fa-square"></i>
                            </a></li>
                        <li>Performances:
                            <ul>
                                @foreach ($show->performances as $performance)
                                    <li><span x-data="{ date: '{{ $performance->show_start }}' }"
                                            x-text="(new Date(date)).toLocaleString()"></span>, at
                                        {{ $performance->venue?->name ?? $show->venue->name }}</li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{ route('show.performance.index', ['show' => $show]) }}">Performances</a></li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
