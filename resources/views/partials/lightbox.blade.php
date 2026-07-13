{{-- Reusable slideshow lightbox — expects an x-data="gallery([...])" on an ancestor. --}}
<div x-show="open" x-cloak x-transition.opacity
    class="fixed inset-0 z-[90] flex items-center justify-center bg-olive-950/95 p-4 lg:p-8"
    @click="open = false">

    {{-- Close --}}
    <button @click="open = false" aria-label="Cerrar"
        class="absolute right-4 top-4 z-10 flex h-11 w-11 items-center justify-center rounded-full bg-sand-50/10 text-sand-50 transition-colors hover:bg-sand-50/20">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
    </button>

    {{-- Prev --}}
    <button @click.stop="prev()" aria-label="Anterior"
        class="absolute left-3 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-sand-50/10 text-sand-50 transition-colors hover:bg-sand-50/20 lg:left-6">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    </button>

    {{-- Next --}}
    <button @click.stop="next()" aria-label="Siguiente"
        class="absolute right-3 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-sand-50/10 text-sand-50 transition-colors hover:bg-sand-50/20 lg:right-6">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </button>

    {{-- Stage --}}
    <div class="relative flex max-h-full w-full max-w-5xl flex-col items-center" @click.stop>
        <img :src="imgs[i] && imgs[i].src" :alt="imgs[i] && imgs[i].t"
            class="max-h-[80vh] w-auto rounded-xl object-contain shadow-2xl">
        <div class="mt-4 flex items-center gap-3 text-sand-100">
            <span class="text-sm" x-text="imgs[i] && imgs[i].t"></span>
            <span class="text-sand-100/40">·</span>
            <span class="eyebrow text-[0.6rem] text-sand-100/60"><span x-text="i + 1"></span> / <span x-text="imgs.length"></span></span>
        </div>
    </div>
</div>
