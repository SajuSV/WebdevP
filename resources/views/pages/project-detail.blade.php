{{-- One project (/projects/{slug}) --}}
@extends('layouts.app')

@section('title', $project->title.' — '.$site->name)
@section('description', (string) $project->description)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project-detail.css') }}">
@endpush

@section('content')
<div class="pg-project-detail">
<main class="main" id="top">
    <div class="container">
        <header class="hero">
            <div>
                <nav class="breadcrumb mono-label" aria-label="Breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <span class="breadcrumb-sep" aria-hidden="true">/</span>
                    <a href="{{ route('projects.index') }}">Projects</a>
                    <span class="breadcrumb-sep" aria-hidden="true">/</span>
                    <span class="breadcrumb-current">{{ $project->title }}</span>
                </nav>

                <h1 class="title">
                    <span class="muted">{{ $project->headline_dim }}</span>
                    {{ $project->headline_rest }}
                </h1>
                <p class="desc">{{ $project->description }}</p>

                <dl class="meta-list">
                    @foreach (['Focus' => $project->focus, 'Tools' => $project->tools] as $label => $value)
                        @if ($value)
                            <div class="meta-item">
                                <dt class="mono-label">{{ $label }}</dt>
                                <dd class="meta-value">{{ $value }}</dd>
                            </div>
                        @endif
                    @endforeach
                </dl>
            </div>

            <figure class="cover-wrap">
                @if ($project->cover)
                    <img src="{{ asset($project->cover) }}" alt="{{ $project->cover_alt }}" class="cover">
                @endif
            </figure>
        </header>

        <section class="gallery-section">
            <div class="gallery-head">
                <span class="mono-label">{{ $project->gallery_label }}</span>
            </div>

            <div class="gallery-grid">
                @foreach ($project->images as $image)
                    @if ($image->href)
                        {{-- Image that opens a website --}}
                        <a href="{{ $image->href }}" target="_blank" rel="noopener noreferrer" class="gallery-item" aria-label="Visit {{ $image->alt }}">
                            <img src="{{ asset($image->src) }}" alt="{{ $image->alt }}" loading="lazy" class="gallery-img">
                        </a>
                    @elseif ($project->enable_lightbox)
                        {{-- Image that opens full screen --}}
                        <button type="button" class="gallery-item" data-lightbox aria-label="Open {{ $image->alt }}">
                            <img src="{{ asset($image->src) }}" alt="{{ $image->alt }}" loading="lazy" class="gallery-img">
                        </button>
                    @else
                        <div class="gallery-item gallery-item--static">
                            <img src="{{ asset($image->src) }}" alt="{{ $image->alt }}" loading="lazy" class="gallery-img">
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>

    {{-- Full screen viewer (hidden until an image is clicked) --}}
    <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" hidden>
        <button type="button" class="lightbox-close" aria-label="Close">Close ×</button>
        <div class="lightbox-inner">
            <img src="data:," alt="" class="lightbox-img" id="lightboxImage">
        </div>
    </div>
</main>
</div>
@endsection
