<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Training Session') }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('trainingSession.store') }}">
            @csrf
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
                <input type="datetime" name="happened_at" id="happened_at">
            </label>
            <div class="flex">
                <select name="trainees[]" id="trainees" multiple>
                    @foreach($people as $person)
                        <option
                            value="{{ $person->id }}"
                            >{{ $person->name }}
                        </option>
                    @endforeach
                </select>
                <select name="training_items[]" id="training_items" multiple>
                    @foreach($trainingItems as $trainingItem)
                        <option
                            value="{{ $trainingItem->id }}"
                            >{{ $trainingItem->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit">Create Training Session</button>
        </form>
    </div>
</x-app-layout>
