<div class="sub-card" data-row>
    <div class="item-head">
        <span class="mono-label">{{ $row['title'] ?? 'New service' }}</span>
        <button type="button" class="btn-danger" data-remove>Delete</button>
    </div>
    <div class="grid-2">
        <div class="field">
            <label class="mono-label field-label">Title<span class="req-star" aria-hidden="true">*</span></label>
            <input type="text" class="input @error("services.$i.title") is-invalid @enderror" name="services[{{ $i }}][title]" value="{{ $row['title'] ?? '' }}" maxlength="50" required>
            @include('partials.field-error', ['name' => "services[$i][title]"])
        </div>
        <div class="field">
            <label class="mono-label field-label">Card Colour<span class="req-star" aria-hidden="true">*</span></label>
            <select class="select @error("services.$i.variant") is-invalid @enderror" name="services[{{ $i }}][variant]">
                @foreach (['lime' => 'Lime', 'ink' => 'Dark Ink', 'tissue' => 'Tissue'] as $value => $text)
                    <option value="{{ $value }}" @selected(($row['variant'] ?? 'lime') === $value)>{{ $text }}</option>
                @endforeach
            </select>
            @include('partials.field-error', ['name' => "services[$i][variant]"])
        </div>
        <div class="field field-full">
            <label class="mono-label field-label">Redirect Link</label>
            <input type="text" class="input @error("services.$i.slug") is-invalid @enderror" name="services[{{ $i }}][slug]" value="{{ $row['slug'] ?? '' }}" maxlength="100" placeholder="/projects/lorem-alpha">
            @include('partials.field-error', ['name' => "services[$i][slug]"])
        </div>
        @include('partials.image-field', [
            'label' => 'Icon Image',
            'name' => "services[$i][icon]",
            'fileName' => "services[$i][icon_file]",
            'value' => $row['icon'] ?? '',
            'required' => true,
        ])
        <div class="field field-full">
            <label class="mono-label field-label">Description<span class="req-star" aria-hidden="true">*</span></label>
            <textarea class="textarea @error("services.$i.text") is-invalid @enderror" name="services[{{ $i }}][text]" maxlength="250" required>{{ $row['text'] ?? '' }}</textarea>
            @include('partials.field-error', ['name' => "services[$i][text]"])
        </div>
    </div>
</div>
