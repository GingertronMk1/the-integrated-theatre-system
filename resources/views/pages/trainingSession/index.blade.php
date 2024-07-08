<x-app-layout class="training-session-index">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training Sessions') }}
        </h2>
    </x-slot>

            <a class="c-button" href="{{ route('trainingSession.create') }}"><i class="fa-solid fa-plus"></i> Add</a>
                @foreach ($trainingSessions as $session)
                    <div>
                        <div class="training-session-index__session-header">
                            <h2 class="text-xl">{{ $session->trainer->name }} @ {{ $session->happened_at }}</h2>
                            <a class="c-button" href="{{ route('trainingSession.edit', ['trainingSession' => $session]) }}">Edit</a>
                        </div>
                        <div class="training-session-index__items-and-trainees">
                            <div class="training-session-index__items">
                                <h3>Training Items</h3>
                            <ul>
                                @foreach ($session->trainingItems as $item)
                                    <li>{{ $item->name }}</li>
                                @endforeach
                            </ul>
                            </div>
                            <div class="training-session-index__trainees">
                                <h3>Trainees</h3>
                            <ul>
                                @foreach ($session->trainees as $trainee)
                                    <li>{{ $trainee->name }}</li>
                                @endforeach
                            </ul>
                            </div>
                        </div>
                    </div>
                    @if(!$loop->last)
                        <hr />
                    @endif
                @endforeach
</x-app-layout>
