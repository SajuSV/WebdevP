{{-- All projects page (/projects) --}}
@extends('layouts.app')

@section('title', 'Projects — '.$site->name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
@endpush

@section('content')
<div class="pg-projects">
<main class="main" id="top">
    <div class="container">
        <header class="header">
            <span class="mono-label">Projects</span>
            <h1 class="title">
                {{ $site->projects_page_title }}
                <span class="muted">{{ $site->projects_page_muted_title }}</span>
            </h1>
            <p class="desc">{{ $site->projects_page_description }}</p>
        </header>

        <div class="grid">
            {{-- @forelse = foreach + what to show when the list is empty --}}
            @forelse ($projects as $project)
                <a href="{{ route('projects.show', $project) }}" class="card">
                    <figure class="media">
                        @if ($project->cover)
                            <img src="{{ asset($project->cover) }}" alt="{{ $project->cover_alt }}" class="cover">
                        @endif
                    </figure>
                    <div class="card-head">
                        <div>
                            <span class="mono-label">{{ $project->tools }}</span>
                            <h2 class="card-title">{{ $project->title }}</h2>
                        </div>
                        <span class="arrow" aria-hidden="true">↗</span>
                    </div>
                    <p class="card-desc">{{ $project->description }}</p>
                </a>
            @empty
                <p>No projects yet.</p>
            @endforelse
        </div>
    </div>
</main>
</div>
@endsection
