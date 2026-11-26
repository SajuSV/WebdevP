{{-- One form used for BOTH "create" and "edit" --}}
@extends('layouts.admin')

@section('title', $project->exists ? 'Edit Project' : 'New Project')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">{{ $project->exists ? 'Edit Project' : 'New Project' }}</h1>
        </div>
        <a class="btn-outline" href="{{ route('admin.projects.index') }}">← Back to list</a>
    </div>

    <form method="POST" enctype="multipart/form-data" novalidate
          action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
        @csrf
        @if ($project->exists)
            @method('PUT')
        @endif

        <section class="section-card">
            <div class="section-head"><h2 class="section-title">Project Details</h2></div>
            <div class="grid-2">
                <div class="field">
                    <label class="mono-label field-label">Title<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" class="input @error('title') is-invalid @enderror" name="title" value="{{ old('title', $project->title) }}" maxlength="50" required>
                    @include('partials.field-error', ['name' => 'title'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">URL Slug<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" class="input @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $project->slug) }}" maxlength="60" required>
                    <span class="field-hint">Letters, numbers, - and _ only. Used in /projects/slug</span>
                    @include('partials.field-error', ['name' => 'slug'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Headline (grey start)<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" class="input @error('headline_dim') is-invalid @enderror" name="headline_dim" value="{{ old('headline_dim', $project->headline_dim) }}" maxlength="50" required>
                    @include('partials.field-error', ['name' => 'headline_dim'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Headline (dark end)<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" class="input @error('headline_rest') is-invalid @enderror" name="headline_rest" value="{{ old('headline_rest', $project->headline_rest) }}" maxlength="50" required>
                    @include('partials.field-error', ['name' => 'headline_rest'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Focus<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" class="input @error('focus') is-invalid @enderror" name="focus" value="{{ old('focus', $project->focus) }}" maxlength="60" required>
                    @include('partials.field-error', ['name' => 'focus'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Tools<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" class="input @error('tools') is-invalid @enderror" name="tools" value="{{ old('tools', $project->tools) }}" maxlength="100" required>
                    @include('partials.field-error', ['name' => 'tools'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Gallery Label</label>
                    <input type="text" class="input @error('gallery_label') is-invalid @enderror" name="gallery_label" value="{{ old('gallery_label', $project->gallery_label) }}" maxlength="40">
                    @include('partials.field-error', ['name' => 'gallery_label'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Order (0 = first)<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" inputmode="numeric" class="input @error('sort_order') is-invalid @enderror" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" maxlength="5" required>
                    @include('partials.field-error', ['name' => 'sort_order'])
                </div>
                @include('partials.image-field', [
                    'label' => 'Cover Image',
                    'name' => 'cover',
                    'fileName' => 'cover_file',
                    'value' => old('cover', $project->cover),
                    'required' => true,
                ])
                <div class="field field-full">
                    <label class="mono-label field-label">Cover Alt Text<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="text" class="input @error('cover_alt') is-invalid @enderror" name="cover_alt" value="{{ old('cover_alt', $project->cover_alt) }}" maxlength="100" required>
                    @include('partials.field-error', ['name' => 'cover_alt'])
                </div>
                <div class="field field-full">
                    <label class="mono-label field-label">Description<span class="req-star" aria-hidden="true">*</span></label>
                    <textarea class="textarea @error('description') is-invalid @enderror" name="description" minlength="100" maxlength="500" data-char-count="500" required>{{ old('description', $project->description) }}</textarea>
                    <div class="field-meta">
                        <span class="field-hint">Minimum 100, maximum 500 characters.</span>
                        <span class="char-counter" data-char-counter>{{ mb_strlen((string) old('description', $project->description)) }} / 500</span>
                    </div>
                    @include('partials.field-error', ['name' => 'description'])
                </div>
                <label class="checkbox-label field-full">
                    <input type="checkbox" class="checkbox-input" name="enable_lightbox" value="1"
                           @checked($errors->any() ? old('enable_lightbox') : $project->enable_lightbox)>
                    <span>Enable full-screen image view</span>
                </label>
            </div>
        </section>

        <section class="section-card section-full" data-repeater>
            <div class="section-head">
                <h2 class="section-title">Gallery Images</h2>
                <button type="button" class="btn-outline" data-add>+ Add Image</button>
            </div>

            <div class="cards-auto-grid" data-rows>
                @foreach (old('images', $images) as $i => $row)
                    @include('admin.rows.image', ['i' => $i, 'row' => $row])
                @endforeach
            </div>

            {{-- JavaScript copies this blank row and replaces __INDEX__ with a new number --}}
            <template>
                @include('admin.rows.image', ['i' => '__INDEX__', 'row' => []])
            </template>
        </section>

        <p class="field-hint">PHP uploads 20 files at most per save by default. Add more in a second save.</p>
        @include('partials.save-bar', ['label' => 'Save Project'])
    </form>
@endsection
