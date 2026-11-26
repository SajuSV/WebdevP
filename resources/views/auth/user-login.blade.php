{{-- Login page --}}
@extends('layouts.bare')

@section('title', 'Login')

@section('content')
<main class="split-layout" id="top">
    <section class="visual-pane" aria-hidden="true">
        @if ($site->hero_video_url)
            <video class="video" src="{{ $site->hero_video_url }}" autoplay loop muted playsinline></video>
        @endif
        <div class="visual-overlay">
            <a class="brand" href="{{ url('/') }}" tabindex="-1">
                <span class="brand-dot"></span>
                <span>{{ $site->name }}</span>
            </a>
            <div class="visual-copy">
                <span class="pill-label">Member Access</span>
                <p class="visual-tagline">{{ $site->tagline }}</p>
            </div>
        </div>
    </section>

    <section class="form-pane">
        <div class="login-shell">
            <div class="top-bar">
                <span class="mono-label">User Login</span>
                <span class="mono-label">{{ $site->name }}</span>
            </div>

            <div class="login-card">
                <div class="card-head">
                    <h1 class="title">Welcome <span class="muted">back.</span></h1>
                    <p class="subtitle">Sign in with your account credentials to continue.</p>
                </div>

                <form class="form" method="POST" action="{{ route('login') }}">
                    {{-- @csrf adds a hidden security token. Laravel requires it on every POST form --}}
                    @csrf

                    <div class="field">
                        <label for="email" class="mono-label field-label">User ID / Email<span class="req-star" aria-hidden="true">*</span></label>
                        <input id="email" type="text" name="email" value="{{ old('email') }}" maxlength="255" required
                               autocomplete="username" placeholder="Enter user ID or email"
                               class="input @error('email') is-invalid @enderror">
                        @include('partials.field-error', ['name' => 'email'])
                    </div>

                    <div class="field">
                        <div class="field-top">
                            <label for="password" class="mono-label field-label">Password<span class="req-star" aria-hidden="true">*</span></label>
                            <button type="button" class="toggle-btn" data-toggle-password="password">Show</button>
                        </div>
                        <input id="password" type="password" name="password" maxlength="255" required
                               autocomplete="current-password" placeholder="••••••••" class="input @error('password') is-invalid @enderror">
                        @include('partials.field-error', ['name' => 'password'])
                    </div>

                    @if ($errors->any())
                        <div class="form-alert" role="alert">{{ $errors->first() }}</div>
                    @endif

                    <div class="actions">
                        <button type="submit" class="button">
                            <span class="button_lg">
                                <span class="button_sl"></span>
                                <span class="button_text">Sign in</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
