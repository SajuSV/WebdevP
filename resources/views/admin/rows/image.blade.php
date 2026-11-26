<div class="sub-card" data-row>
    <div class="item-head">
        <span class="mono-label">Gallery image</span>
        <button type="button" class="btn-danger" data-remove>Delete</button>
    </div>
    <div class="grid-2">
        @include('partials.image-field', [
            'label' => 'Image',
            'name' => "images[$i][src]",
            'fileName' => "images[$i][file]",
            'value' => $row['src'] ?? '',
        ])
        <div class="field field-full">
            <label class="mono-label field-label">Alt Text (describes the image)</label>
            <input type="text" class="input @error("images.$i.alt") is-invalid @enderror" name="images[{{ $i }}][alt]" value="{{ $row['alt'] ?? '' }}" maxlength="100">
            @include('partials.field-error', ['name' => "images[$i][alt]"])
        </div>
        <div class="field field-full">
            <label class="mono-label field-label">Website Link (optional)</label>
            <input type="url" class="input @error("images.$i.href") is-invalid @enderror" name="images[{{ $i }}][href]" value="{{ $row['href'] ?? '' }}" maxlength="300">
            @include('partials.field-error', ['name' => "images[$i][href]"])
        </div>
    </div>
</div>
