<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Training Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('trainingCategory.create') }}">Add</a>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Advanced?</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                @foreach ($trainingCategories as $trainingCategory)
                    <tr data-trainingCategory-id="{{ $trainingCategory->id }}">
                        <td><a
                                href="{{ route('trainingCategory.show', ['trainingCategory' => $trainingCategory]) }}">{{ $trainingCategory->name }}</a>
                        </td>
                        <td>{{ $trainingCategory->description }}</td>
                        <td class="text-center">{{ $trainingCategory->advanced ? 'Yes' : 'No' }}</td>
                        <td class="flex justify-evenly space-x-2">
                            <a
                                href="{{ route('trainingCategory.edit', ['trainingCategory' => $trainingCategory]) }}">Update</a>
                            <form method="POST"
                                action="{{ route('trainingCategory.destroy', ['trainingCategory' => $trainingCategory]) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

</x-app-layout>
