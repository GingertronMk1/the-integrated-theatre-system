<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('People') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('person.create') }}">Add</a>
            <table class="w-full">
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
                        <td class="text-center">{{ $person->start_year ?? 'Start Year unknown' }}</td>
                        <td class="text-center">{{ $person->end_year ?? 'End Year unknown' }}</td>
                        <td class="flex justify-evenly space-x-2">
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
        </div>
    </div>
</x-app-layout>
