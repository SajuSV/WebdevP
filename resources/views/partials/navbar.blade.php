{{-- Top menu. The "scrolled" class is added by public/js/app.js --}}
@php
    $links = [
        ['label' => 'Home', 'href' => url('/'), 'external' => false],
        ['label' => 'About', 'href' => url('/').'#about', 'external' => false],
        ['label' => 'Projects', 'href' => route('projects.index'), 'external' => false],
    ];
    if ($site->resume_url) {
        $links[] = ['label' => 'Resume', 'href' => $site->resume_url, 'external' => true];
    }
@endphp

<div class="site-navbar">
    {{-- Inner pages always use the solid header; the home page becomes solid after scrolling --}}
    <header class="header {{ request()->routeIs('home') ? '' : 'scrolled' }}" id="siteHeader"
            data-home="{{ request()->routeIs('home') ? '1' : '0' }}">
        <div class="container inner">
            <a class="logo" href="{{ url('/') }}" aria-label="{{ $site->name }}">
                <span class="logo-dot" aria-hidden="true"></span>
                <span>{{ $site->name }}</span>
            </a>

            <nav class="nav">
                <ul class="menu">
                    @foreach ($links as $link)
                        <li>
                            <a class="menu-item" href="{{ $link['href'] }}"
                               @if ($link['external']) target="_blank" rel="noopener noreferrer" @endif>{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                    <li><a class="cta" href="mailto:{{ $site->email }}">Contact me</a></li>
                    @if ($site->require_user_login && auth()->check())
                        <li>
                            <button type="submit" form="user-logout-form" class="logout-icon-btn" aria-label="Logout" title="Logout">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                            </button>
                        </li>
                    @endif
                </ul>

                <button type="button" class="burger" data-menu-toggle aria-label="Open menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                </button>
            </nav>
        </div>

        {{-- Mobile full-screen menu --}}
        <div class="popup" data-menu role="dialog" aria-modal="true" aria-label="Menu">
            <div class="popup-inner">
                <ul class="popup-menu">
                    @foreach ($links as $link)
                        <li>
                            <a class="popup-item" href="{{ $link['href'] }}" data-menu-close
                               @if ($link['external']) target="_blank" rel="noopener noreferrer" @endif>{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                    <li><a class="popup-item" href="mailto:{{ $site->email }}" data-menu-close>Contact me</a></li>
                    @if ($site->require_user_login && auth()->check())
                        <li>
                            <button type="submit" form="user-logout-form" class="popup-item popup-logout" data-menu-close>Logout</button>
                        </li>
                    @endif
                </ul>
                <a class="popup-mail" href="mailto:{{ $site->email }}">{{ $site->email }}</a>
            </div>
        </div>
    </header>
    @if ($site->require_user_login && auth()->check())
        <form id="user-logout-form" method="POST" action="{{ route('logout') }}" hidden>@csrf</form>
    @endif
</div>
