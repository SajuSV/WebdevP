<div class="item-box" data-row>
    <div class="item-row">
        <div class="grid-2 item-row-fields">
            <div class="field">
                <label class="mono-label field-label">Label<span class="req-star" aria-hidden="true">*</span></label>
                <input type="text" class="input @error("facts.$i.label") is-invalid @enderror" name="facts[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" maxlength="30" required>
                @include('partials.field-error', ['name' => "facts[$i][label]"])
            </div>
            <div class="field">
                <label class="mono-label field-label">Value<span class="req-star" aria-hidden="true">*</span></label>
                <input type="text" class="input @error("facts.$i.value") is-invalid @enderror" name="facts[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}" maxlength="80" required>
                @include('partials.field-error', ['name' => "facts[$i][value]"])
            </div>
        </div>
        <button type="button" class="btn-icon-danger" data-remove aria-label="Delete" title="Delete">✕</button>
    </div>
</div>
