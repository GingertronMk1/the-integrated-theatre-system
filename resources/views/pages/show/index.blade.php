<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <a href="{{ route('show.create') }}">Add</a>
            @foreach ($shows as $show)
                <div class="flex flex-col">
                    <span class="flex flex-row justify-between">
                        <h3 class="text-xl">{{ $show->title }}</h3>
                        <a href="{{ route('show.edit', ['show' => $show]) }}">Edit</a>
                    </span>
                    <div class="flex flex-row divide-x-2">
                        <div class="flex-1 px-2">
                            @toparagraphs($show->description)
                        </div>
                        <div class="flex-1 px-2">
                            <ul>
                                <li>Year: {{ $show->year }}</li>
                                <li>Season: {{ $show->season ?? 'Unknown' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
