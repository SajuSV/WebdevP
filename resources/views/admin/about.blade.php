@extends('layouts.admin')

@section('title', 'About')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">About</h1>
            <p class="page-subtitle">Experience, toolkit, quick facts and numbers.</p>
        </div>
    </div>

    {{-- enctype is required for file uploads. @method('PUT') tells Laravel this is an update --}}
    <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <div class="sections-grid sections-grid--3-2">
            <section class="section-card" data-repeater>
                <div class="section-head">
                    <h2 class="section-title">Experience</h2>
                    <button type="button" class="btn-outline" data-add>+ Add Experience</button>
                </div>

                <div class="form-stack" data-rows>
                    @foreach (old('experiences', $experiences) as $i => $row)
                        @include('admin.rows.experience', ['i' => $i, 'row' => $row])
                    @endforeach
                </div>

                {{-- JavaScript copies this blank row and replaces __INDEX__ with a new number --}}
                <template>
                    @include('admin.rows.experience', ['i' => '__INDEX__', 'row' => []])
                </template>
            </section>

            <section class="section-card" data-repeater>
                <div class="section-head">
                    <h2 class="section-title">My Journey in Numbers</h2>
                    <button type="button" class="btn-outline" data-add>+ Add Stat</button>
                </div>

                <div class="form-stack" data-rows>
                    @foreach (old('stats', $stats) as $i => $row)
                        @include('admin.rows.stat', ['i' => $i, 'row' => $row])
                    @endforeach
                </div>

                {{-- JavaScript copies this blank row and replaces __INDEX__ with a new number --}}
                <template>
                    @include('admin.rows.stat', ['i' => '__INDEX__', 'row' => []])
                </template>
            </section>
        </div>

        <div class="sections-grid sections-grid--1-4 section-full">
            <section class="section-card">
                <div class="section-head"><h2 class="section-title">Toolkit Pills</h2></div>
                <div class="field">
                    <label class="mono-label field-label">Skills / Tools<span class="req-star" aria-hidden="true">*</span></label>
                    <textarea class="textarea @error('toolkit') is-invalid @enderror" name="toolkit" maxlength="300" required>{{ old('toolkit', $toolkit) }}</textarea>
                    <span class="field-hint">Separate each skill with a comma.</span>
                    @include('partials.field-error', ['name' => 'toolkit'])
                </div>
            </section>

            <section class="section-card" data-repeater>
                <div class="section-head">
                    <h2 class="section-title">Quick Facts</h2>
                    <button type="button" class="btn-outline" data-add>+ Add Fact</button>
                </div>

                <div class="form-stack" data-rows>
                    @foreach (old('facts', $facts) as $i => $row)
                        @include('admin.rows.fact', ['i' => $i, 'row' => $row])
                    @endforeach
                </div>

                {{-- JavaScript copies this blank row and replaces __INDEX__ with a new number --}}
                <template>
                    @include('admin.rows.fact', ['i' => '__INDEX__', 'row' => []])
                </template>
            </section>
        </div>

        @include('partials.save-bar', ['label' => 'Save About Section'])
    </form>
@endsection
