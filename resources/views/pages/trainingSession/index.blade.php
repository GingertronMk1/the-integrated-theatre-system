<x-app-layout class="training-session-index">
    <x-slot name="header">
        <h2>
            {{ __('Training Sessions') }}
        </h2>
    </x-slot>

    <a class="btn btn-primary" href="{{ route('trainingSession.create') }}"><i class="fa-solid fa-plus"></i> Add</a>
    @foreach ($trainingSessions as $session)
        <div class="card mt-3">
            <div class="card-header d-flex">
                <h2 class="text-xl">
                    {{ $session->trainer->name }} @
                    <span x-data="{ date: '{{ $session->happened_at }}' }" x-text="(new Date(date)).toLocaleString()">
                    </span>
                </h2>
                <a class="btn btn-primary ms-auto"
                    href="{{ route('trainingSession.edit', ['trainingSession' => $session]) }}">Edit</a>
            </div>
            <div class="row">
                <div class="col-6">
                    <h3 class="p-2">Training Items</h3>
                    <ul class="list-group list-group-flush">
                        @foreach ($session->trainingItems as $item)
                            <li class="list-group-item">{{ $item->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-6">
                    <h3 class="p-2">Trainees</h3>
                    <ul class="list-group list-group-flush">
                        @foreach ($session->trainees as $trainee)
                            <li class="list-group-item">{{ $trainee->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
