<x-app-layout innerClass="p-season-index">
    <a href="{{ route('season.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add</a>

    <table class="table table-striped">
        @foreach ($seasons as $season)
            <tr>
                <td>{{ $season->name }}</td>
                <td
                    style="
            color: {{ $season->colour }};
            background-color: {{ $season->colour }};
        ">
                    {{ $season->colour }}</td>
                <td>{{ $season->description }}</td>
                <td></td>
            </tr>
        @endforeach
    </table>
</x-app-layout>
