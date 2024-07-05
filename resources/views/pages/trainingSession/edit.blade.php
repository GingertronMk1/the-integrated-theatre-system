<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Session held by :name at :time', [
                'name' => $trainingSession->trainer->name,
                'time' => $trainingSession->happened_at
            ]) }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('trainingSession.update', ['trainingSession' => $trainingSession]) }}">
            @csrf
            @method('PUT')
            <label for="trainer_id">
                Trainer
                <select name="trainer_id" id="trainer_id">
                    @foreach($people as $person)
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
                    @foreach($people as $person)
                        <option
                            value="{{ $person->id }}"
                            {{ $trainingSession->trainees()->where('id', $person->id)->exists() ? 'selected' : '' }}>
                            {{ $person->name }}
                        </option>
                    @endforeach
                </select>
                <select name="training_items[]" id="training_items" multiple>
                    @foreach($trainingItems as $trainingItem)
                        <option
                            value="{{ $trainingItem->id }}"
                            {{ $trainingSession->trainingItems()->where('id', $trainingItem->id)->exists() ? 'selected' : '' }}>
                            {{ $trainingItem->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit">Update Training Session</button>
        </form>
    </div>
</x-app-layout>
