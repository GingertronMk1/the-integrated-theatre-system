<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training Sessions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <ul class="space-y-3">
                @foreach ($trainingSessions as $session)
                    <li>
                        {{ $session->trainer->name }} @ {{ $session->happened_at }}
                        <div class="flex justify-evenly">

                            <ul class="flex-1">
                                <h3>Training Items</h3>
                                @foreach ($session->trainingItems as $item)
                                    <li>{{ $item->name }}</li>
                                @endforeach
                            </ul>
                            <ul class="flex-1">
                                <h3>Trainees</h3>
                                @foreach ($session->trainees as $trainee)
                                    <li>{{ $trainee->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
