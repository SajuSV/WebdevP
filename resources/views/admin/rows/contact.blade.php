<div class="sub-card" data-row>
    <div class="item-head">
        <span class="mono-label">{{ $row['label'] ?? 'New contact card' }}</span>
        <button type="button" class="btn-danger" data-remove>Delete</button>
    </div>
    <div class="grid-2">
        <div class="field">
            <label class="mono-label field-label">Label<span class="req-star" aria-hidden="true">*</span></label>
            <input type="text" class="input @error("contacts.$i.label") is-invalid @enderror" name="contacts[{{ $i }}][label]" value="{{ $row['label'] ?? '' }}" maxlength="30" required>
            @include('partials.field-error', ['name' => "contacts[$i][label]"])
        </div>
        <div class="field">
            <label class="mono-label field-label">Card Colour<span class="req-star" aria-hidden="true">*</span></label>
            <select class="select @error("contacts.$i.variant") is-invalid @enderror" name="contacts[{{ $i }}][variant]">
                @foreach (['lime' => 'Lime', 'ink' => 'Dark Ink', 'paper' => 'Paper', 'tissue' => 'Tissue'] as $value => $text)
                    <option value="{{ $value }}" @selected(($row['variant'] ?? 'lime') === $value)>{{ $text }}</option>
                @endforeach
            </select>
            @include('partials.field-error', ['name' => "contacts[$i][variant]"])
        </div>
        <div class="field">
            <label class="mono-label field-label">Display Value<span class="req-star" aria-hidden="true">*</span></label>
            <input type="text" class="input @error("contacts.$i.value") is-invalid @enderror" name="contacts[{{ $i }}][value]" value="{{ $row['value'] ?? '' }}" maxlength="100" required>
            @include('partials.field-error', ['name' => "contacts[$i][value]"])
        </div>
        <div class="field">
            <label class="mono-label field-label">Link (optional)</label>
            <input type="text" class="input @error("contacts.$i.href") is-invalid @enderror" name="contacts[{{ $i }}][href]" value="{{ $row['href'] ?? '' }}" maxlength="300">
            <span class="field-hint">https://, mailto: or tel:</span>
            @include('partials.field-error', ['name' => "contacts[$i][href]"])
        </div>
        <div class="field">
            <label class="mono-label field-label">Icon<span class="req-star" aria-hidden="true">*</span></label>
            <select class="select @error("contacts.$i.icon") is-invalid @enderror" name="contacts[{{ $i }}][icon]">
                @foreach (['email' => 'Email', 'location' => 'Location', 'phone' => 'Phone', 'linkedin' => 'LinkedIn', 'github' => 'GitHub', 'behance' => 'Behance', 'dribbble' => 'Dribbble', 'globe' => 'Website'] as $value => $text)
                    <option value="{{ $value }}" @selected(($row['icon'] ?? 'globe') === $value)>{{ $text }}</option>
                @endforeach
            </select>
            @include('partials.field-error', ['name' => "contacts[$i][icon]"])
        </div>
        @include('partials.image-field', [
            'label' => 'Custom Icon (optional)',
            'name' => "contacts[$i][icon_image]",
            'fileName' => "contacts[$i][icon_file]",
            'value' => $row['icon_image'] ?? '',
        ])
    </div>
</div>
