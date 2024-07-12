<form action="{{ $action }}" method="POST" data-form-class="{{ $calledClass }}">
    @csrf
    @if ($update)
        @method('PUT')
    @endif
    @foreach ($inputs as $input)
        @if (is_array($input))
            <div class="row">
                @foreach ($input as $sxsInput)
                    <div class="col-{{ intdiv(12, count($input)) }}">
                        {{ $sxsInput->render() }}
                    </div>
                @endforeach
            </div>
        @else
            {{ $input->render() }}
        @endif
    @endforeach
    <button type="submit" class="btn btn-primary" name="submit">
        {{ $update ? 'Update' : 'Create' }}
    </button>
</form>
