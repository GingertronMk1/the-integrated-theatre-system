<x-app-layout>
    <div class="py-12">
        <a href="{{ route('person.create') }}">Add</a>
        <table>
            @foreach ($people as $person)
                <tr>
                    <td>{{ $person->name }}</td>
                    <td>{{ $person->user?->name ?? 'No user associated' }}</td>
                    <td>{{ $person->start_year ?? 'Start Year unknown' }}</td>
                    <td>{{ $person->end_year ?? 'End Year unknown' }}</td>
                    <td>
                        <a href="{{ route('person.edit', ['person' => $person]) }}">Update</a>
                        <form
                            method="POST"
                            action="{{ route('person.destroy', ['person' => $person]) }}" >
                            @method('DELETE')
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
