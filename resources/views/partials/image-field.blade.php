{{-- Image field: type a link OR choose a file from your computer.
     Needs: $label, $name (text input), $fileName (file input), $value --}}
@php
    $nameKey = rtrim(str_replace(['[', ']'], ['.', ''], $name), '.');
    $fileKey = rtrim(str_replace(['[', ']'], ['.', ''], $fileName), '.');
@endphp
<div class="field field-full">
    <label class="mono-label field-label">{{ $label }}@if (! empty($required))<span class="req-star" aria-hidden="true">*</span>@endif</label>
    <div class="file-field">
        @if ($value)
            <img src="{{ asset($value) }}" alt="Preview" class="file-preview">
        @endif
        <input type="file" class="file-input @error($fileKey) is-invalid @enderror" name="{{ $fileName }}" accept=".jpg,.jpeg,.png,.webp,.gif">
    </div>
    @include('partials.field-error', ['name' => $fileName])
    <input type="text" class="input @error($nameKey) is-invalid @enderror" name="{{ $name }}" value="{{ $value }}" maxlength="500" placeholder="https://...  (or choose a file above)">
    @include('partials.field-error', ['name' => $name])
</div>
