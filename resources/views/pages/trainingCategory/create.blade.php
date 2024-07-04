<x-app-layout>
    <div>
        <form method="POST" action="{{ route('trainingCategory.store') }}">
            @csrf
            <label for="name">
                Name
                <input type="text" name="name" id="name">
            </label>
            <label for="description">
                Description
                <textarea name="description" id="description"></textarea>
            </label>
            <label for="advanced">
                Advanced?
                <input
                    type="hidden"
                    name="advanced"
                    value="0">
                <input
                    type="checkbox"
                    name="advanced"
                    id="advanced"
                    value="1">
            </label>
            <button type="submit">Create Training Category</button>
        </form>
    </div>
</x-app-layout>
