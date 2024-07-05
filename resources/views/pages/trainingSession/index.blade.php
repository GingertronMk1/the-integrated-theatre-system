<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training Sessions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('trainingSession.create') }}">Add</a>
            <ul class="divide-y-2">
                @foreach ($trainingSessions as $session)
                    <li class="py-2">
                        <div class="flex justify-between">
                            <h2 class="text-xl">{{ $session->trainer->name }} @ {{ $session->happened_at }}</h2>
                            <a href="{{ route('trainingSession.edit', ['trainingSession' => $session]) }}">Edit</a>
                        </div>
                        <div class="flex justify-evenly">
                            <ul class="flex-1 list-disc">
                                <h3 class="text-lg">Training Items</h3>
                                @foreach ($session->trainingItems as $item)
                                    <li>{{ $item->name }}</li>
                                @endforeach
                            </ul>
                            <ul class="flex-1 list-disc">
                                <h3 class="text-lg">Trainees</h3>
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
