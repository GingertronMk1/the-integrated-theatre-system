<x-app-layout>
    <x-slot name="class">training-item</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training Items') }}
        </h2>
    </x-slot>

        <a class="button" href="{{ route('trainingItem.create') }}">
            Add
            <i class="fa-solid fa-plus"></i>
        </a>
        <table class="w-full">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Advanced?</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            @foreach ($trainingItems as $trainingItem)
                <tr data-trainingItem-id="{{ $trainingItem->id }}">
                    <td>{{ $trainingItem->name }}</td>
                    <td>@toparagraphs($trainingItem->description)</td>
                    <td class="text-center">{{ $trainingItem->dangerous ? 'Yes' : 'No' }}</td>
                    <td>{{ $trainingItem->trainingCategory->name }}</td>
                    <td class="action-column">
                        <a href="{{ route('trainingItem.edit', ['trainingItem' => $trainingItem]) }}">Update</a>
                        <form
                            method="POST"
                            action="{{ route('trainingItem.destroy', ['trainingItem' => $trainingItem]) }}" >
                            @method('DELETE')
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

</x-app-layout>
