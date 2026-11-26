{{-- Main layout for the public pages: navbar + page content + footer.
     Each page fills the @yield spots. (Replaces app.component.html) --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $site->name.' — '.$site->role)</title>
    <meta name="description" content="@yield('description', $site->description)">
    @if ($site->avatar)
        <link rel="icon" href="{{ asset($site->avatar) }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <div class="page-content">
        @yield('content')
    </div>

    @include('partials.footer')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
