{{-- Home page --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<div class="pg-home">
<main id="top">

    {{-- 1. Hero + scroll statements --}}
    <section class="experience">
        <div class="video-bg">
            <div class="frame" id="heroFrame">
                <div class="canvas">
                    @if ($site->hero_video_url)
                        <video class="video" src="{{ $site->hero_video_url }}" autoplay loop muted playsinline></video>
                    @endif
                </div>
            </div>
        </div>

        <div class="overlay">
            <div class="container hero-inner">
                <h1 class="heading">
                    {{ $site->hero_title_line1 }}<br>
                    {{ $site->hero_title_line2 }}
                </h1>
                <div class="hero-bottom">
                    <h2 class="hero-text">{{ $site->hero_subtitle }}</h2>
                    @include('partials.arrow-button', ['label' => $site->hero_cta_label ?: 'View Projects', 'href' => route('projects.index')])
                </div>
            </div>

            <section class="what-we-do" id="whatWeDo">
                <div class="sticky">
                    <div class="body">
                        <div class="progress">
                            <div class="progress-bar" id="progressBar" style="transform: scaleX(0)"></div>
                        </div>

                        <div class="container what-content">
                            <aside class="index-badge">
                                <span id="statementNumber">01</span>
                                <span class="index-divider">/</span>
                                <span class="index-total">{{ str_pad($statements->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            </aside>

                            <div class="statements-wrap">
                                @foreach ($statements as $statement)
                                    {{-- $loop->first is true for the first item --}}
                                    <p class="statement {{ $loop->first ? 'is-active' : '' }}">{{ $statement->body }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    {{-- 2. About --}}
    <section class="about-section" id="about">
        <div class="about-hero">
            <div class="container">
                <span class="mono-label">About</span>
                <h2 class="about-title">{{ $site->about_title }}</h2>
            </div>
        </div>

        <div class="container bento">
            <figure class="card portrait-card">
                @if ($site->avatar)
                    <img src="{{ asset($site->avatar) }}" alt="Portrait of {{ $site->name }}" class="portrait">
                @endif
            </figure>

            <div class="card exp-card">
                <span class="mono-label">Experience</span>
                <ul class="timeline">
                    @foreach ($experiences as $item)
                        <li class="timeline-item">
                            <div>
                                <strong class="exp-role">{{ $item->role }}</strong>
                                <span class="exp-place">{{ $item->place }}</span>
                            </div>
                            <time class="exp-period">{{ $item->period }}</time>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card toolkit-card">
                <span class="mono-label">Toolkit</span>
                <div class="pills">
                    @foreach ($toolkits as $pill)
                        <span class="pill">{{ $pill->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="card facts-card">
                <span class="mono-label">Quick facts</span>
                <ul class="facts-list">
                    @foreach ($quickFacts as $fact)
                        <li class="fact-item">
                            <span class="mono-label">{{ $fact->label }}</span>
                            <span class="fact-value">{{ $fact->value }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card stats-card">
                <span class="mono-label">My Journey in Numbers</span>
                <div class="stats-grid">
                    @foreach ($stats as $stat)
                        <div class="stat-item">
                            <span class="stat-value">{{ $stat->value }}</span>
                            <span class="stat-label">{{ $stat->label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- 3. Services --}}
    <section class="usp-section" id="services">
        <div class="container services-head">
            <span class="mono-label">Services</span>
            <h2 class="services-heading">{{ $site->services_heading }}</h2>
        </div>

        <div class="usp-cards">
            @foreach ($services as $card)
                @php
                    $rawLink = trim((string) $card->slug);
                    $cardHref = $rawLink !== ''
                        ? (\Illuminate\Support\Str::startsWith($rawLink, ['http://', 'https://', '#']) ? $rawLink : url($rawLink))
                        : null;
                    $cardTag = $cardHref ? 'a' : 'div';
                @endphp
                <{{ $cardTag }} @if ($cardHref) href="{{ $cardHref }}" @endif
                    @if ($cardHref && \Illuminate\Support\Str::startsWith($cardHref, ['http://', 'https://']) && ! \Illuminate\Support\Str::startsWith($rawLink, '/')) target="_blank" rel="noopener noreferrer" @endif
                    class="usp-card {{ $card->variant }}">
                    <span class="usp-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.</span>
                    <div class="usp-icon">
                        @if ($card->icon)
                            <img src="{{ asset($card->icon) }}" alt="{{ $card->title }}">
                        @endif
                    </div>
                    <div class="usp-content">
                        <h4 class="usp-title">{{ $card->title }}</h4>
                        <p class="usp-text">{{ $card->text }}</p>
                    </div>
                </{{ $cardTag }}>
            @endforeach
        </div>
    </section>

    {{-- 4. Portfolio with tabs. All panels are in the page; JavaScript shows one at a time --}}
    <section class="newsroom-section" id="projects">
        <div class="container newsroom-inner">
            <div class="newsroom-head">
                <div class="newsroom-title-wrap">
                    <span class="mono-label">Portfolio</span>
                    <h2 class="newsroom-title">{{ $site->work_in_focus_title }}</h2>
                </div>
                @include('partials.arrow-button', ['label' => 'View all projects', 'href' => route('projects.index')])
            </div>

            <div class="portfolio-tabs" role="tablist" aria-label="Portfolio categories">
                <button type="button" role="tab" class="portfolio-tab is-active" data-tab="all" aria-selected="true">All</button>
                @foreach ($projects as $project)
                    <button type="button" role="tab" class="portfolio-tab" data-tab="{{ $project->slug }}" aria-selected="false">{{ $project->title }}</button>
                @endforeach
            </div>

            {{-- Panel: All --}}
            @if ($projects->isNotEmpty())
                <div class="portfolio-split" data-panel="all">
                    @include('partials.featured-card', ['project' => $projects->first()])

                    <div class="portfolio-side">
                        <div class="posts">
                            {{-- skip(1)->take(1) = the 2nd project --}}
                            @foreach ($projects->skip(1)->take(1) as $project)
                                <a href="{{ route('projects.show', $project) }}" class="post">
                                    <figure class="post-image">
                                        @if ($project->cover)
                                            <img src="{{ asset($project->cover) }}" alt="{{ $project->cover_alt }}" loading="lazy">
                                        @endif
                                    </figure>
                                    <div class="post-content">
                                        <div class="meta">
                                            <span class="tag">
                                                <span class="dot" aria-hidden="true"></span>
                                                <span class="mono-label">{{ $project->title }}</span>
                                            </span>
                                            <span class="date">{{ $project->tools }}</span>
                                        </div>
                                        <h4 class="post-title">{{ $project->headline_dim }} {{ $project->headline_rest }}</h4>
                                        <div class="foot">
                                            <span class="read-label">View project</span>
                                            <span class="chip" aria-hidden="true">→</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @if ($projects->count() === 1)
                                <a href="{{ route('projects.show', $projects->first()) }}" class="portfolio-cta-card">
                                    <span class="portfolio-cta-label">View project</span>
                                    <span class="portfolio-cta-chip" aria-hidden="true">→</span>
                                </a>
                            @elseif ($projects->count() > 2)
                                <a href="{{ route('projects.index') }}" class="portfolio-cta-card">
                                    <span class="portfolio-cta-label">View all projects</span>
                                    <span class="portfolio-cta-chip" aria-hidden="true">→</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- One hidden panel for each project --}}
            @foreach ($projects as $project)
                <div class="portfolio-split" data-panel="{{ $project->slug }}" hidden>
                    @include('partials.featured-card', ['project' => $project])

                    <div class="portfolio-side">
                        <div class="tab-gallery">
                            @foreach ($project->images->take(2) as $image)
                                <a href="{{ route('projects.show', $project) }}" class="tab-gallery-item">
                                    <img src="{{ asset($image->src) }}" alt="{{ $image->alt }}" loading="lazy">
                                </a>
                            @endforeach

                            @if ($project->images->count() < 2)
                                <a href="{{ route('projects.show', $project) }}" class="portfolio-cta-card">
                                    <span class="portfolio-cta-label">View project</span>
                                    <span class="portfolio-cta-chip" aria-hidden="true">→</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 5. Contact --}}
    <section class="contact-section" id="contact-info">
        <div class="container contact-inner">
            <div class="contact-head">
                <span class="mono-label">Contact</span>
                <h2 class="contact-heading">{{ $site->contact_heading }}</h2>
            </div>

            <div class="contact-grid">
                @foreach ($contactItems as $item)
                    {{-- With a link the card is an <a>, without a link it is a <div> --}}
                    @php $tag = $item->href ? 'a' : 'div'; @endphp
                    <{{ $tag }} class="contact-card contact-card--{{ $item->variant }} {{ $item->href ? 'contact-link' : '' }}"
                        @if ($item->href) href="{{ $item->href }}" @endif
                        @if (str_starts_with((string) $item->href, 'http')) target="_blank" rel="noopener noreferrer" @endif>

                        <span class="contact-icon {{ $item->icon === 'phone' && ! $item->icon_image ? 'contact-icon--badge' : '' }}" aria-hidden="true">
                            @if ($item->icon_image)
                                <img src="{{ asset($item->icon_image) }}" alt="{{ $item->label }}">
                            @else
                                @include('partials.icon', ['name' => $item->icon])
                            @endif
                        </span>

                        {{-- % 4 repeats the 4 shapes: 0,1,2,3,0,1... --}}
                        @include('partials.watermark', ['shape' => $loop->index % 4])

                        <span class="contact-value">{{ $item->value }}</span>
                    </{{ $tag }}>
                @endforeach
            </div>
        </div>
    </section>
</main>
</div>
@endsection
