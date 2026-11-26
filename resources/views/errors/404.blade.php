<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Page Not Found</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <style>
        .pg-404 {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(24px, 4vw, 48px);
            background-color: var(--color-bone-white);
            color: var(--color-abyssal-ink);
        }
        .pg-404 .error-card {
            width: 100%;
            max-width: 640px;
            background-color: var(--color-paper);
            border-radius: var(--radius-2xl);
            padding: clamp(32px, 5vw, 56px);
            display: flex;
            flex-direction: column;
            gap: var(--spacing-20);
        }
        .pg-404 .error-badge {
            align-self: flex-start;
            font-family: var(--font-roboto-mono);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 6px 14px;
            border-radius: var(--radius-pill);
            background-color: var(--color-bioluminescent-lime);
            color: var(--color-abyssal-ink);
        }
        .pg-404 .error-code {
            font-size: clamp(56px, 10vw, 104px);
            line-height: 0.95;
            letter-spacing: -0.04em;
            margin: 0;
        }
        .pg-404 .error-title {
            font-size: clamp(24px, 3vw, 36px);
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin: 0;
        }
        .pg-404 .error-muted {
            color: var(--color-graphite);
        }
        .pg-404 .error-desc {
            font-size: 16px;
            line-height: 1.5;
            color: var(--color-graphite);
            margin: 0;
            max-width: 44ch;
        }
        .pg-404 .error-actions {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-12);
            padding-top: var(--spacing-8);
        }
        .pg-404 .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--color-tissue);
            background-color: var(--color-bone-white);
            color: var(--color-abyssal-ink);
            font-family: var(--font-roboto-mono);
            font-size: 13px;
            text-transform: uppercase;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        .pg-404 .btn-secondary:hover {
            background-color: var(--color-tissue);
            border-color: var(--color-abyssal-ink);
        }
    </style>
</head>
<body>
    <main class="pg-404">
        <section class="error-card" aria-labelledby="errorTitle">
            <span class="error-badge">Error 404</span>
            <p class="error-code" aria-hidden="true">404</p>
            <h1 class="error-title" id="errorTitle">
                Page <span class="error-muted">not found.</span>
            </h1>
            <p class="error-desc">
                The page or path you are looking for doesn’t exist or may have been moved.
            </p>
            <div class="error-actions">
                @include('partials.arrow-button', ['label' => 'Back to Home', 'href' => url('/')])
                <a href="{{ url('/projects') }}" class="btn-secondary">View Projects</a>
            </div>
        </section>
    </main>
</body>
</html>
