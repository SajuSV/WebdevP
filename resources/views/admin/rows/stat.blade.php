<div class="item-box" data-row>
    <div class="item-row">
        <div class="grid-2 item-row-fields">
            <div class="field">
                <label class="mono-label field-label">Value (e.g. 2+)<span class="req-star" aria-hidden="true">*</span></label>
                <input type="text" class="input @error("stats.$i.value") is-invalid @enderror" name="stats[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}" maxlength="15" required>
                @include('partials.field-error', ['name' => "stats[$i][value]"])
            </div>
            <div class="field">
                <label class="mono-label field-label">Label<span class="req-star" aria-hidden="true">*</span></label>
                <input type="text" class="input @error("stats.$i.label") is-invalid @enderror" name="stats[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" maxlength="40" required>
                @include('partials.field-error', ['name' => "stats[$i][label]"])
            </div>
        </div>
        <button type="button" class="btn-icon-danger" data-remove aria-label="Delete" title="Delete">✕</button>
    </div>
</div>
