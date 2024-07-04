<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update :name', ['name' => $person->name]) }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('person.update', ['person' => $person]) }}">
            @csrf
            @method('PUT')
            <label for="name">
                Name
                <input type="text" name="name" value="{{ $person->name }}">
            </label>
            <label for="start_year">
                Start Year
                <input type="number" name="start_year" min="0" max="9999" value="{{ $person->start_year }}">
            </label>
            <label for="end_year">
                End Year
                <input type="number" name="end_year" min="0" max="9999" value="{{ $person->end_year }}">
            </label>
            <label for="user_id">
                User
                <select name="user_id">
                    <option value="{{ null }}">No User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $person->user?->id === $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit">Create Person</button>
        </form>
    </div>
</x-app-layout>
