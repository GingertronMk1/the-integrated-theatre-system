<x-app-layout innerClass="p-person-index">
    <x-slot name="header">
        <h2>
            {{ __('People') }}
        </h2>
    </x-slot>

    <a class="btn btn-primary" href="{{ route('person.create') }}"><i class="fa-solid fa-plus"></i>Add</a>
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>User's Name</th>
                <th>Start Year</th>
                <th>End Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        @foreach ($people as $person)
            <tr data-person-id="{{ $person->id }}">
                <td>{{ $person->name }}</td>
                <td>{{ $person->user?->name ?? 'No user associated' }}</td>
                <td>{{ $person->start_year ?? 'Start Year unknown' }}</td>
                <td>{{ $person->end_year ?? 'End Year unknown' }}</td>
                <td class="text-center">
                    <a class="btn btn-secondary" href="{{ route('person.edit', ['person' => $person]) }}">Update</a>
                    <form method="POST" action="{{ route('person.destroy', ['person' => $person]) }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger text-decoration-none">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</x-app-layout>
