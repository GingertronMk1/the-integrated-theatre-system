<form method="POST" action="{{
    $person->id ? route('person.update', ['person' => $person]) : route('person.store') }}">
    @csrf
    @if($person->id)
    @method('PUT')
    @endif
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
                <option value="{{ $user->id }}" {{ $person->user?->id === $user->id ? 'selected' : '' }}>
                    {{ $user->name }}</option>
            @endforeach
        </select>
    </label>
    <button type="submit">{{ $person->id ? 'Update' : 'Create'}} Person</button>
</form>
