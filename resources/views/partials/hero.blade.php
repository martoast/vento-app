{{-- ============================== HERO ============================== --}}
<section id="inicio" class="grain relative flex min-h-svh items-end justify-center overflow-hidden bg-olive-950">
    {{-- Backdrop --}}
    <div class="absolute inset-0">
        <picture>
            {{-- Desktop: render frontal ultra-amplio · Mobile: fachada al atardecer (crop vertical) --}}
            <source media="(min-width: 1024px)" srcset="{{ asset('images/vento-hero-desktop.jpg') }}">
            <img
                src="{{ asset('images/vento-hero-movil.jpg') }}"
                alt="Vento — edificio departamental en Tijuana"
                class="kenburns h-full w-full object-cover object-[center_38%] lg:object-center"
                fetchpriority="high"
            >
        </picture>
        <div class="absolute inset-0 bg-gradient-to-t from-olive-950/80 via-transparent to-olive-950/10"></div>
    </div>

    {{-- Copy --}}
    <div class="reveal-group is-revealed relative z-10 mx-auto w-full max-w-5xl px-6 pb-32 text-center sm:pb-20">
        <p class="eyebrow text-[0.7rem] text-sand-100/95 drop-shadow-[0_2px_16px_rgba(25,27,15,0.75)]">
            Departamentos residenciales en Tijuana
        </p>
        <h1 class="display mt-4 text-6xl font-light uppercase tracking-[0.14em] leading-[1.02] text-sand-50 drop-shadow-[0_2px_28px_rgba(25,27,15,0.7)] sm:text-7xl lg:text-8xl">
            Vento
        </h1>
        <p class="mx-auto mt-4 max-w-xl font-sans text-base font-light leading-snug tracking-wide text-sand-100/95 drop-shadow-[0_2px_16px_rgba(25,27,15,0.75)] sm:text-lg">
            Diseño, <span class="font-bold text-sand-50">calma</span> y <span class="font-bold text-sand-50">conexión</span> para vivir una nueva etapa.
        </p>
    </div>
</section>
