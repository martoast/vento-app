{{-- ============================== HERO ============================== --}}
<section id="inicio" class="grain relative flex min-h-svh items-end justify-center overflow-hidden bg-olive-950">
    {{-- Backdrop --}}
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/vento-hero.jpg') }}"
            alt="Vento — edificio departamental en Tijuana"
            class="h-full w-full object-cover object-[47%_center] lg:object-[41%_center]"
            fetchpriority="high"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-olive-950/80 via-transparent to-olive-950/10"></div>
    </div>

    {{-- Copy --}}
    <div class="reveal-group is-revealed relative z-10 mx-auto w-full max-w-5xl px-6 pb-32 text-center sm:pb-20">
        <p class="eyebrow text-[0.7rem] text-sand-100/95 drop-shadow-[0_2px_16px_rgba(25,27,15,0.75)]">
            5 Departamentos boutique en Tijuana
        </p>
        <h1 class="mt-4">
            <img
                src="{{ asset('images/vento-logo.png') }}"
                alt="Vento"
                class="mx-auto w-full max-w-[240px] object-contain drop-shadow-[0_2px_28px_rgba(25,27,15,0.7)] sm:max-w-xs lg:max-w-md"
            >
        </h1>
        <p class="mx-auto mt-4 max-w-xl font-sans text-base font-light leading-snug tracking-wide text-sand-100/95 drop-shadow-[0_2px_16px_rgba(25,27,15,0.75)] sm:text-lg">
            Diseño y <span class="font-bold text-sand-50">conexión</span> para vivir una nueva etapa.
        </p>
    </div>
</section>
