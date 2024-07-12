<x-app-layout innerClass="training-item-index">
    <x-slot name="header">
        <h2>
            {{ __('Training Items') }}
        </h2>
    </x-slot>

    <a class="btn btn-primary" href="{{ route('trainingItem.create') }}">
        Add
        <i class="fa-solid fa-plus"></i>
    </a>
    <table class="training-item-index__table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Dangerous?</th>
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
                <td>
                    <div class="action-column">
                        <a href="{{ route('trainingItem.edit', ['trainingItem' => $trainingItem]) }}">Update</a>
                        <form method="POST"
                            action="{{ route('trainingItem.destroy', ['trainingItem' => $trainingItem]) }}">
                            @method('DELETE')
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

</x-app-layout>
