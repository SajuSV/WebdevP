<div class="item-box" data-row>
    <div class="item-row">
        <div class="grid-3 item-row-fields">
            <div class="field">
                <label class="mono-label field-label">Role<span class="req-star" aria-hidden="true">*</span></label>
                <input type="text" class="input @error("experiences.$i.role") is-invalid @enderror" name="experiences[{{ $i }}][role]" value="{{ $row['role'] ?? '' }}" maxlength="60" required>
                @include('partials.field-error', ['name' => "experiences[$i][role]"])
            </div>
            <div class="field">
                <label class="mono-label field-label">Period<span class="req-star" aria-hidden="true">*</span></label>
                <input type="text" class="input @error("experiences.$i.period") is-invalid @enderror" name="experiences[{{ $i }}][period]" value="{{ $row['period'] ?? '' }}" maxlength="30" required>
                @include('partials.field-error', ['name' => "experiences[$i][period]"])
            </div>
            <div class="field">
                <label class="mono-label field-label">Place / Details<span class="req-star" aria-hidden="true">*</span></label>
                <input type="text" class="input @error("experiences.$i.place") is-invalid @enderror" name="experiences[{{ $i }}][place]" value="{{ $row['place'] ?? '' }}" maxlength="80" required>
                @include('partials.field-error', ['name' => "experiences[$i][place]"])
            </div>
        </div>
        <button type="button" class="btn-icon-danger" data-remove aria-label="Delete" title="Delete">✕</button>
    </div>
</div>
