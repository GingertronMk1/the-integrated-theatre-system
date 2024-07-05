<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training Items') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <a href="{{ route('trainingItem.create') }}">Add</a>
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
                    <td>{{ $trainingItem->description }}</td>
                    <td class="text-center">{{ $trainingItem->dangerous ? 'Yes' : 'No' }}</td>
                    <td>{{ $trainingItem->trainingCategory->name }}</td>
                    <td class="flex justify-evenly space-x-2">
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
        </div>
    </div>

</x-app-layout>
