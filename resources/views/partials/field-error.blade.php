@php
    $dotKey = rtrim(str_replace(['[', ']'], ['.', ''], $name), '.');
@endphp
@error($dotKey)
    <span class="field-error" role="alert">{{ $message }}</span>
@enderror
