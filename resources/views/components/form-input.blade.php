<div class="mb-3">
    @error($name)
        <h4 class="text-red">{{ $message }}</h4>
    @enderror
    @if ($type !== 'checkbox')
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
        </label>

        @switch($type)
            @case('textarea')
                <textarea name="{{ $name }}" id="{{ $id }}" cols="30" rows="10" class="form-control"
                    @foreach ($inputAttributes as $attrKey => $attrVal)
                    {{ $attrKey }}="{{ $attrVal }}" @endforeach>{{ $currentValue }}</textarea>
            @break

            @case('select')
                <select name="{{ $name }}" id="{{ $id }}" class="form-control"
                    @foreach ($inputAttributes as $attrKey => $attrVal)
                    {{ $attrKey }}="{{ $attrVal }}" @endforeach>
                    @foreach ($options as $option)
                        <option value="{{ $optionValue($option) }}"
                            {{ in_array($optionValue($option), $currentValue) ? 'selected' : '' }}>
                            {{ $optionLabel($option) }}
                        </option>
                    @endforeach
                </select>
            @break

            @default
                <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                    value="{{ $currentValue }}" class="form-control"
                    @foreach ($inputAttributes as $attrKey => $attrVal)
                    {{ $attrKey }}="{{ $attrVal }}" @endforeach />
            @break
        @endswitch
    @else
        <div class="form-check">
            <label for="{{ $id }}" class="form-check-label">
                {{ $label }}
            </label>
            <input type="hidden" name="{{ $name }}" value="0" />
            <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="1"
                class="form-check-input" {{ $currentValue ? 'checked' : '' }} />
        </div>
    @endif
</div>
