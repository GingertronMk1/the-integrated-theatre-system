<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit :title', ['title' => $show->title]) }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('show.update', ['show' => $show]) }}" class="flex flex-col">
            @csrf
            @method('PUT')
            <label for="title">
                Name
                <input type="text" name="title" value="{{ $show->title }}">
            </label>
            <label for="description">
                Description
                <textarea name="description" id="description" cols="30" rows="10">{{ $show->description }}</textarea>
            </label>
            <label for="year">
                Year
                <input type="number" name="year" min="0" max="9999" id="year" value="{{ $show->year }}">
            </label>
            <label for="season">
                Season
                <input type="text" name="season" id="season" value="{{ $show->season }}">
            </label>
            <button type="submit">Create Show</button>
        </form>
    </div>
</x-app-layout>
