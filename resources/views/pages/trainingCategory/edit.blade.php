<x-app-layout>
    <div>
        <form method="POST" action="{{ route('trainingCategory.update', ['trainingCategory' => $trainingCategory]) }}">
            @csrf
            @method('PUT')
            <label for="name">
                Name
                <input type="text" name="name" value="{{ $trainingCategory->name }}">
            </label>
            <label for="start_year">
                Description
                <textarea name="description">{{ $trainingCategory->description }}</textarea>
            </label>
            <label for="advanced">
                Advanced?
                <input
                    type="hidden"
                    name="advanced"
                    value="0"
                >
                <input
                    type="checkbox"
                    name="advanced"
                    {{ $trainingCategory->advanced ? 'checked' : '' }}
                    value="1"
                >
            </label>
            <button type="submit">Update Training Category</button>
        </form>
    </div>
</x-app-layout>
