<form class="flex flex-col space-y-2" method="POST" action="{{
    $performance->id
    ? route(
        'show.performance.update',
        [
            'show' => $show,
            'performance' => $performance
        ]
    )
    : route(
        'show.performance.store',
        [
            'show' => $show
        ]
    )
}}">
    @csrf
    @if($performance->id)
    @method('PUT')
    @endif
    <label for="show_start">
        Show Start
        <input type="datetime-local" name="show_start" id="show_start" value="{{ $performance->show_start }}">
    </label>
    <label for="doors">
        Doors
        <input type="datetime-local" name="doors" id="doors" value="{{ $performance->doors }}">
    </label>
    <label for="venue">
        Venue
        <input type="text" name="venue" id="venue" value="{{ $performance->venue }}">
    </label>
    <label for="capacity">
        Capacity
        <input type="number" name="capacity" id="capacity" min="0" value="{{ $performance->capacity }}">
    </label>
    <button type="submit">{{ $performance->id ? 'Update' : 'Create' }} Performance</button>
</form>
