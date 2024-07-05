<form method="POST" action="{{
    $performance->id
    ? route(
        'show.performance.update',
        [
            'show' => $show,
            'performance' => $performance
        ]
    )
    : route(
        'show.performance.create',
        [
            'show' => $show
        ]
    )
}}">
    @csrf
    @if($performance->id)
    @method('PUT')
    @endif
    <label for="show_start">
        Show Start

    </label>
