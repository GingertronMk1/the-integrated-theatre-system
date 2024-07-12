<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('Edit :title', ['title' => $show->title]) }}
        </h2>
    </x-slot>

    <x-form.show-form :$show :$seasons :$venues />
</x-app-layout>
