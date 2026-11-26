{{-- Layout for all admin pages --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Admin: @yield('title') — {{ $site->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    @php
        // Menu: label => [route name, pattern used to highlight the current page]
        $menu = [
            'Site & Hero' => ['admin.site.edit', 'admin.site.*'],
            'Services' => ['admin.services.edit', 'admin.services.*'],
            'About' => ['admin.about.edit', 'admin.about.*'],
            'Projects' => ['admin.projects.index', 'admin.projects.*'],
        ];
    @endphp

    <div class="admin-navbar">
        <header class="header" id="siteHeader">
            <div class="container inner">
                <a class="logo" href="{{ route('admin.site.edit') }}">
                    <span class="logo-dot" aria-hidden="true"></span>
                    <span>{{ $site->name }}</span>
                </a>
                <nav class="nav" aria-label="Admin navigation">
                    <ul class="menu">
                        @foreach ($menu as $label => [$route, $pattern])
                            <li><a class="menu-item {{ request()->routeIs($pattern) ? 'is-active' : '' }}" href="{{ route($route) }}">{{ $label }}</a></li>
                        @endforeach
                        <li><a class="menu-item" href="{{ route('home') }}">View Site</a></li>
                        <li><button type="submit" form="logout-form" class="cta">Logout</button></li>
                    </ul>
                    <button type="button" class="burger" data-menu-toggle aria-label="Open menu">
                        <span></span><span></span>
                    </button>
                </nav>
            </div>

            <div class="popup" data-menu>
                <div class="popup-inner">
                    <ul class="popup-menu">
                        @foreach ($menu as $label => [$route, $pattern])
                            <li><a class="popup-item" href="{{ route($route) }}">{{ $label }}</a></li>
                        @endforeach
                        <li><a class="popup-item" href="{{ route('home') }}">View Site</a></li>
                        <li><button type="submit" form="logout-form" class="popup-item">Logout</button></li>
                    </ul>
                </div>
            </div>
        </header>
    </div>

    {{-- Logout must be a POST request, so the buttons above submit this form --}}
    <form id="logout-form" method="POST" action="{{ route('logout') }}">@csrf</form>

    <div class="pg-admin">
        <main class="admin-main">
            <div class="container admin-container">
                {{-- Popup modal for form submission success or failure --}}
                @if (session('status') || $errors->any())
                    @php $isSuccess = (bool) session('status') && ! $errors->any(); @endphp
                    <div class="admin-popup-backdrop" id="statusPopup" role="dialog" aria-modal="true" aria-labelledby="statusPopupTitle">
                        <div class="admin-popup-card {{ $isSuccess ? 'admin-popup-card--success' : 'admin-popup-card--error' }}">
                            <div class="admin-popup-head">
                                <span class="admin-popup-badge">{{ $isSuccess ? 'Success' : 'Failed' }}</span>
                                <button type="button" class="btn-icon-danger" data-popup-close aria-label="Close popup">✕</button>
                            </div>
                            <h2 class="admin-popup-title" id="statusPopupTitle">
                                {{ $isSuccess ? 'Saved successfully' : 'Submission failed' }}
                            </h2>
                            @if ($isSuccess)
                                <p class="admin-popup-msg">{{ session('status') }}</p>
                            @else
                                @php $errorCount = $errors->count(); @endphp
                                <p class="admin-popup-msg">
                                    Found <strong>{{ $errorCount }}</strong> {{ $errorCount === 1 ? 'validation error' : 'validation errors' }}. Please fix the highlighted {{ $errorCount === 1 ? 'field' : 'fields' }} below and try again.
                                </p>
                            @endif
                            <div class="admin-popup-actions">
                                <button type="button" class="btn-outline" data-popup-close>OK</button>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
