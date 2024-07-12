<x-app-layout>
    <x-slot name="header">
        <h2>Venues</h2>
    </x-slot>

    <a href="{{ route('venue.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i>
        Add
    </a>
    @foreach($venues as $venue)
    <div class="card mt-3">
        <div class="card-header">{{ $venue->name }}</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    {{ $venue->location }}
                </li>
                @if($venue->location_additional)
                    <li class="list-group-item">
                        {{ $venue->location_additional }}
                    </li>
                @endif
                <li
                    class="list-group-item"
                    x-data="{capacity: {{ $venue->capacity }}}"
                    x-text="`Capacity: ${capacity.toLocaleString()}`">
                </li>
            </ul>
        <div class="card-footer">
            <a href="{{ route('venue.edit', ['venue' => $venue]) }}" class="btn btn-primary">
                Edit
            </a>
        </div>
    </div>
    @endforeach
</x-app-layout>
