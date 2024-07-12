@props(['class', 'rightAligned'])
@php
    $class ??= '';
    $rightAligned ??= false;
@endphp
<div class="c-dropdown {{ $class }}" x-data="{ open: false }" @click.outside="open = false"
    @close.stop="open = false">
    <div @click="open = ! open" class="c-dropdown__trigger">
        {{ $trigger }}
        <i class="fa-solid c-dropdown__indicator" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'">
        </i>
    </div>

    <div @click="open = false" class="c-dropdown__content {{ $rightAligned ? 'c-dropdown__content--right-aligned' : '' }}"
        :class="open ? 'c-dropdown__content--active' : ''">
        {{ $content }}
    </div>
</div>
