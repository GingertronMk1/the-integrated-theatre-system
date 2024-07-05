<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Training Item') }}
        </h2>
    </x-slot>

    <div>
        <form method="POST" action="{{ route('trainingItem.store') }}">
            @csrf
            <label for="name">
                Name
                <input type="text" name="name">
            </label>
            <label for="description">
                Description
                <textarea name="description" id="description"></textarea>
            </label>
            <label for="dangerous">
                Dangerous?
                <input
                    type="hidden"
                    name="dangerous"
                    value="0">
                <input
                    type="checkbox"
                    name="dangerous"
                    id="dangerous"
                    value="1">
            </label>

            <label for="training_category_id">
                Training Category
                <select name="training_category_id">
                    @foreach ($trainingCategories as $training_category)
                        <option value="{{ $training_category->id }}">{{ $training_category->name }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit">Create Training Item</button>
        </form>
    </div>
</x-app-layout>
