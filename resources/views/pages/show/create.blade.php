<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Show') }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('show.store') }}" class="flex flex-col">
            @csrf
            <label for="title">
                Name
                <input type="text" name="title">
            </label>
            <label for="description">
                Description
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
            </label>
            <label for="year">
                Year
                <input type="number" name="year" min="0" max="9999" id="year">
            </label>
            <label for="season">
                Season
                <input type="text" name="season" id="season">
            </label>
            <button type="submit">Create Show</button>
        </form>
    </div>
</x-app-layout>
