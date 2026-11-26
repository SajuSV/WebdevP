<div class="item-box" data-row>
    <div class="item-row">
        <div class="grid-2 item-row-fields">
            <div class="field field-full">
                <label class="mono-label field-label">Statement<span class="req-star" aria-hidden="true">*</span></label>
                <textarea class="textarea @error("statements.$i.body") is-invalid @enderror" name="statements[{{ $i }}][body]" maxlength="250" required>{{ $row['body'] ?? '' }}</textarea>
                @include('partials.field-error', ['name' => "statements[$i][body]"])
            </div>
        </div>
        <button type="button" class="btn-icon-danger" data-remove aria-label="Delete" title="Delete">✕</button>
    </div>
</div>
