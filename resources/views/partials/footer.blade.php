{{-- Footer shown at the bottom of every public page --}}
<div class="site-footer">
    <footer class="footer" id="contact">
        <div class="background" aria-hidden="true">
            @if ($site->hero_video_url)
                <video class="video" src="{{ $site->hero_video_url }}" autoplay loop muted playsinline></video>
            @endif
        </div>

        <div class="container inner">
            <div class="main">
                <div class="content">
                    <h2 class="heading">{{ $site->footer_heading }}</h2>
                    @include('partials.arrow-button', ['label' => $site->footer_cta_label ?: 'Contact me', 'href' => 'mailto:'.$site->email])
                </div>

                <div class="info">
                    <div class="col">
                        <div class="col-label">Navigate</div>
                        <ul class="col-menu">
                            <li><a class="link" href="{{ url('/') }}">Home</a></li>
                            <li><a class="link" href="{{ url('/') }}#about">About</a></li>
                            <li><a class="link" href="{{ route('projects.index') }}">Projects</a></li>
                            @if ($site->resume_url)
                                <li><a class="link" href="{{ $site->resume_url }}" target="_blank" rel="noopener noreferrer">Resume</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="col">
                        <div class="col-label">Connect</div>
                        <ul class="col-menu">
                            <li><a class="link" href="mailto:{{ $site->email }}">{{ $site->email }}</a></li>
                            <li><a class="link" href="{{ $site->phone_href }}">{{ $site->phone }}</a></li>
                            <li><span class="link">{{ $site->location }}</span></li>
                        </ul>
                    </div>

                    <button type="button" class="scroll" data-scroll-top>Top</button>
                </div>
            </div>

            <div class="footer-base">
                <div class="bottom">
                    <div class="copyright">{{ $site->copyright }}</div>
                    <p class="disclaimer">{{ $site->footer_disclaimer }} — {{ $site->name }}, {{ $site->role }}</p>
                </div>
                <div class="logo-row">
                    <span class="logo-dot" aria-hidden="true"></span>
                    <span>{{ $site->name }}</span>
                </div>
            </div>
        </div>
    </footer>
</div>
