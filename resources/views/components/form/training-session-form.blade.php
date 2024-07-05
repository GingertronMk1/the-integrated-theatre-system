<form class="flex flex-col space-y-2" method="POST"
    action="{{ $trainingSession->id
        ? route('trainingSession.update', ['trainingSession' => $trainingSession])
        : route('trainingSession.store') }}">
    @csrf
    @if ($trainingSession->id)
        @method('PUT')
    @endif
    <label for="trainer_id">
        Trainer
        <select name="trainer_id" id="trainer_id">
            @foreach ($people as $person)
                <option value="{{ $person->id }}">{{ $person->name }}</option>
            @endforeach
        </select>
    </label>
    <label for="happened_at">
        Happened At
        <input type="datetime" name="happened_at" id="happened_at" value="{{ $trainingSession->happened_at }}">
    </label>

    <div class="flex">
        <select name="trainees[]" id="trainees" multiple>
            @foreach ($people as $person)
                <option value="{{ $person->id }}"
                    {{ $trainingSession->trainees()->where('id', $person->id)->exists()? 'selected': '' }}>
                    {{ $person->name }}
                </option>
            @endforeach
        </select>
        <select name="training_items[]" id="training_items" multiple>
            @foreach ($trainingItems as $trainingItem)
                <option value="{{ $trainingItem->id }}"
                    {{ $trainingSession->trainingItems()->where('id', $trainingItem->id)->exists()? 'selected': '' }}>
                    {{ $trainingItem->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit">{{ $trainingSession->id ? 'Update' : 'Create' }} Training Session</button>
</form>
