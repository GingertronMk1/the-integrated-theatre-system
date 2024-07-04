<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Person') }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('person.store') }}">
            @csrf
            <label for="name">
                Name
                <input type="text" name="name">
            </label>
            <label for="start_year">
                Start Year
                <input type="number" name="start_year" min="0" max="9999">
            </label>
            <label for="end_year">
                End Year
                <input type="number" name="end_year" min="0" max="9999">
            </label>
            <label for="user_id">
                User
                <select name="user_id">
                    <option value="{{ null }}">No User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit">Create Person</button>
        </form>
    </div>
</x-app-layout>
