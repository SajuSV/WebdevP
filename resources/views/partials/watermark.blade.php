{{-- Large background shape on each contact card ($shape is 0, 1, 2 or 3) --}}
@switch($shape)
    @case(0)
        <svg class="contact-watermark" viewBox="0 0 160 120" fill="none" aria-hidden="true">
                    <circle cx="80" cy="95" r="58" stroke="currentColor" stroke-width="26" />
                  </svg>
        @break
    @case(1)
        <svg class="contact-watermark" viewBox="0 0 160 120" fill="currentColor" aria-hidden="true">
                    <path d="M80 12C83 62 96 76 144 80C96 84 83 98 80 148C77 98 64 84 16 80C64 76 77 62 80 12Z" />
                  </svg>
        @break
    @case(2)
        <svg class="contact-watermark" viewBox="0 0 160 120" fill="currentColor" aria-hidden="true">
                    <path d="M70 10h20v44l31-31 14 14-31 31h44v20h-44l31 31-14 14-31-31v44H70v-44l-31 31-14-14 31-31H12V68h44L25 37l14-14 31 31V10Z" />
                  </svg>
        @break
    @default
        <svg class="contact-watermark" viewBox="0 0 160 120" fill="none" aria-hidden="true">
                    <rect x="28" y="26" width="104" height="104" rx="28" stroke="currentColor" stroke-width="22" />
                  </svg>
@endswitch
