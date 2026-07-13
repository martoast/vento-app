{{-- Vento wordmark (text-based — pending the real logo asset; the renders show
     a serif "VE" ligature + sun emblem we can swap in when the client sends files).
     variant 'white' → fixed light wordmark (footer, preloader)
     variant 'auto'  → inherits currentColor so the nav can crossfade light ↔ dark. --}}
@php
    $variant = $variant ?? 'white';
    $color = $variant === 'auto' ? 'text-current' : 'text-sand-50';
@endphp
<span class="flex flex-col leading-none {{ $color }}" role="img" aria-label="Vento — departamentos residenciales en Tijuana">
    <span class="display text-2xl font-light uppercase tracking-[0.3em] xl:text-3xl">Vento</span>
    <span class="eyebrow mt-1.5 text-[0.5rem] tracking-[0.32em] text-wood-400">City Inmobiliaria</span>
</span>
