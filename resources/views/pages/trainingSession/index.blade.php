<x-app-layout>
    <ul>
        @foreach($trainingSessions as $session)
            <li>
                {{ $session->trainer->name }} @ {{ $session->happened_at }}
                <ul>
                    @foreach($session->trainingItems as $item)
                    <li>{{ $item->name }}</li>
                    @endforeach
                </ul>
                <ul>
                    @foreach($session->trainees as $trainee)
                    <li>{{ $trainee->name }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</x-app-layout>
