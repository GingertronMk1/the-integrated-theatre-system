<x-app-layout innerClass="p-person-index">
    <x-slot name="header">
        <h2>
            {{ __('People') }}
        </h2>
    </x-slot>

            <a class="c-button" href="{{ route('person.create') }}"><i class="fa-solid fa-plus"></i>Add</a>
            <table>
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
                        <td class="p-person-index__person-name">{{ $person->name }}</td>
                        <td class="p-person-index__person-user-name">{{ $person->user?->name ?? 'No user associated' }}</td>
                        <td class="p-person-index__person-start-year">{{ $person->start_year ?? 'Start Year unknown' }}</td>
                        <td class="p-person-index__person-end-year"">{{ $person->end_year ?? 'End Year unknown' }}</td>
                        <td class="p-person-index__actions">
                            <a href="{{ route('person.edit', ['person' => $person]) }}">Update</a>
                            <form method="POST" action="{{ route('person.destroy', ['person' => $person]) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
</x-app-layout>
