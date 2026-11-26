{{-- Reusable button. Usage:
     @include('partials.arrow-button', ['label' => 'View Projects', 'href' => url('/projects')]) --}}
<span class="arrow-button">
    <a class="button" href="{{ $href }}" aria-label="{{ $label }}">
        <span class="button_lg">
            <span class="button_sl"></span>
            <span class="button_text">{{ $label }}</span>
        </span>
    </a>
</span>
