{{-- ============================== AMENIDADES / CARACTERÍSTICAS ============================== --}}
@php
    $amenities = [
        [
            't' => 'Roof deck',
            'sub' => 'Área compartida',
            'desc' => 'Área compartida para disfrutar momentos al aire libre: descansar, convivir y cerrar el día con la ciudad de fondo.',
            'tags' => ['Pérgola', 'Área lounge', 'Al aire libre'],
            'imgs' => ['vento-roofdeck', 'vento-roofdeck-atardecer'],
        ],
        [
            't' => 'Estacionamiento',
            'sub' => 'Comodidad diaria',
            'desc' => 'Dos cajones de estacionamiento por departamento, dentro del acceso vehicular controlado del edificio.',
            'tags' => ['2 cajones por depto'],
            'imgs' => ['vento-estacionamiento'],
        ],
        [
            't' => 'Acceso controlado',
            'sub' => 'Tranquilidad',
            'desc' => 'Control de acceso peatonal para entrar y salir con tranquilidad todos los días.',
            'tags' => ['Acceso peatonal'],
            'imgs' => ['vento-acceso'],
        ],
        [
            't' => 'Portones eléctricos',
            'sub' => 'Comodidad diaria',
            'desc' => 'Portones eléctricos para un ingreso vehicular más cómodo y seguro.',
            'tags' => ['Ingreso vehicular'],
            'imgs' => ['vento-portones'],
        ],
        [
            't' => 'Bodega',
            'sub' => 'Almacenamiento',
            'desc' => 'Espacio de almacenamiento asignado por departamento.',
            'tags' => ['Por departamento'],
            'imgs' => ['vento-bodega'],
        ],
        [
            't' => 'Servicios integrados',
            'sub' => 'Infraestructura',
            'desc' => 'Nichos de CFE y CESPT integrados al proyecto.',
            'tags' => ['CFE', 'CESPT'],
            'imgs' => ['vento-servicios'],
        ],
    ];

    $amenitiesJs = collect($amenities)->map(fn ($a) => [
        't' => $a['t'],
        'sub' => $a['sub'],
        'desc' => $a['desc'],
        'tags' => $a['tags'] ?? [],
        'icon' => $a['icon'] ?? null,
        'cover' => isset($a['imgs']) ? asset('images/' . $a['imgs'][0] . '.jpg') : null,
        'gallery' => isset($a['imgs']) ? collect($a['imgs'])->map(fn ($i) => asset('images/' . $i . '.jpg'))->values() : [],
    ])->values();
@endphp

<section id="amenidades" class="overflow-hidden bg-sand-50 py-24 lg:py-32"
    x-data="amenities(@js($amenitiesJs))">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="flex flex-col gap-8 md:flex-row md:items-end md:justify-between">
            <div class="reveal-group max-w-xl">
                <p class="eyebrow text-wood-500">Amenidades</p>
                <h2 class="display mt-5 text-4xl font-light text-ink sm:text-5xl">Detalles que hacen la <span class="accent-italic">diferencia</span></h2>
                <p class="mt-5 text-lg leading-relaxed text-ink-soft">Un edificio pensado para vivir con comodidad y tranquilidad. Selecciona una característica para conocerla.</p>
            </div>
            <div class="flex gap-3">
                <button @click="nudge(-1)" aria-label="Anterior"
                    class="flex h-12 w-12 items-center justify-center rounded-full border border-ink/15 text-ink transition-colors hover:border-ink/40 hover:bg-ink hover:text-sand-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="nudge(1)" aria-label="Siguiente"
                    class="flex h-12 w-12 items-center justify-center rounded-full border border-ink/15 text-ink transition-colors hover:border-ink/40 hover:bg-ink hover:text-sand-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Slider --}}
    <div x-ref="track"
        class="mt-12 flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth px-6 pb-2 lg:px-10 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <template x-for="(a, idx) in items" :key="idx">
            <article data-card class="group w-[70vw] shrink-0 snap-start sm:w-[320px] lg:w-[360px]">
                {{-- Photo card → opens the bento modal --}}
                <template x-if="a.cover">
                    <button type="button" @click="show(idx)"
                        class="relative block w-full overflow-hidden rounded-2xl bg-olive-950 text-left shadow-lg shadow-ink/5 ring-1 ring-transparent transition-shadow hover:ring-wood-400/60">
                        <img :src="a.cover" :alt="a.t + ' — Vento'" loading="lazy"
                            class="aspect-[3/4] w-full object-cover transition-transform duration-[1.2s] ease-out group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-olive-950/85 via-olive-950/10 to-transparent"></div>
                        <span class="absolute right-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-olive-950/55 px-3 py-1.5 text-[0.6rem] font-semibold uppercase tracking-wider text-sand-50 backdrop-blur-sm">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4z M4 15l4-4 4 4 M14 13l2-2 4 4"/></svg>
                            <span x-text="a.gallery.length"></span>
                        </span>
                        <div class="absolute inset-x-0 bottom-0 p-6">
                            <p class="eyebrow mb-1 text-[0.55rem] text-sand-50/90 drop-shadow-[0_1px_8px_rgba(25,27,15,0.9)]" x-text="a.sub"></p>
                            <h3 class="display text-2xl text-sand-50 drop-shadow-[0_1px_10px_rgba(25,27,15,0.8)]" x-text="a.t"></h3>
                            <span class="mt-2 inline-flex items-center gap-1.5 text-[0.7rem] font-medium text-sand-100/90 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                Ver galería
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </button>
                </template>

                {{-- Icon card (sin render disponible) — informativa, no abre modal --}}
                <template x-if="!a.cover">
                    <div class="relative flex aspect-[3/4] w-full flex-col justify-between overflow-hidden rounded-2xl bg-gradient-to-b from-olive-900 to-olive-950 p-6 text-left shadow-lg shadow-ink/5">
                        <span class="flex h-16 w-16 items-center justify-center rounded-full border border-wood-300/40 text-wood-300">
                            <svg x-show="a.icon === 'bodega'" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8l-9-5-9 5v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1z"/><path d="M9 21v-8h6v8"/><path d="M9 13h6"/></svg>
                            <svg x-show="a.icon === 'servicios'" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 4.5 13H11l-1 9L18.5 11H12z"/></svg>
                        </span>
                        <div>
                            <p class="eyebrow mb-1 text-[0.55rem] text-sand-50/90 drop-shadow-[0_1px_8px_rgba(25,27,15,0.9)]" x-text="a.sub"></p>
                            <h3 class="display text-2xl text-sand-50 drop-shadow-[0_1px_10px_rgba(25,27,15,0.8)]" x-text="a.t"></h3>
                            <p class="mt-3 text-sm leading-relaxed text-sand-100/75" x-text="a.desc"></p>
                        </div>
                    </div>
                </template>
            </article>
        </template>
        <div class="w-2 shrink-0 lg:w-6" aria-hidden="true"></div>
    </div>

    {{-- ============================== BENTO MODAL ============================== --}}
    <div x-show="open" x-cloak
        class="fixed inset-0 z-[95] flex items-end justify-center sm:items-center"
        @keydown.escape.window="close()" role="dialog" aria-modal="true">
        <div x-show="open" x-transition.opacity
            class="absolute inset-0 bg-olive-950/80 backdrop-blur-sm" @click="close()"></div>

        <div x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            class="relative m-0 flex max-h-[92svh] w-full max-w-5xl flex-col overflow-hidden rounded-t-3xl bg-sand-50 shadow-2xl sm:m-6 sm:max-h-[90svh] sm:rounded-3xl">
            <div class="flex items-start justify-between gap-6 border-b border-ink/10 p-6 sm:p-8">
                <div class="min-w-0" x-show="active">
                    <p class="eyebrow text-[0.6rem] text-wood-500" x-text="active?.sub"></p>
                    <h3 class="display mt-2 text-3xl font-light text-ink sm:text-4xl" x-text="active?.t"></h3>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-ink-soft" x-text="active?.desc"></p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <template x-for="(tag, ti) in (active?.tags || [])" :key="ti">
                            <span class="rounded-full bg-olive-500/10 px-3 py-1.5 text-[0.7rem] font-medium text-olive-700" x-text="tag"></span>
                        </template>
                    </div>
                </div>
                <button type="button" @click="close()" aria-label="Cerrar"
                    class="shrink-0 rounded-full border border-ink/15 p-2.5 text-ink transition-colors hover:bg-ink hover:text-sand-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>

            <div class="grow overflow-y-auto p-4 sm:p-6">
                <div class="grid auto-rows-[120px] grid-cols-2 gap-3 sm:auto-rows-[150px] sm:grid-cols-4">
                    <template x-for="(img, gi) in (active?.gallery || [])" :key="gi">
                        <button type="button" @click="lightbox(gi)"
                            class="group relative overflow-hidden rounded-xl bg-olive-950" :class="span(gi)">
                            <img :src="img" :alt="active?.t" loading="lazy"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-olive-950/0 transition-colors group-hover:bg-olive-950/15"></div>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    {{-- fullscreen image viewer (from bento) --}}
    <div x-show="viewer" x-cloak x-transition.opacity
        class="fixed inset-0 z-[97] flex items-center justify-center bg-olive-950/95 p-4"
        @keydown.escape.window="viewer = false"
        @keydown.arrow-right.window="viewer && viewNext()"
        @keydown.arrow-left.window="viewer && viewPrev()"
        @click.self="viewer = false">
        <button type="button" @click="viewPrev()" aria-label="Anterior"
            class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-sand-50/10 p-3 text-sand-50 backdrop-blur-sm transition-colors hover:bg-sand-50/25 sm:left-6">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="relative flex max-h-[88svh] max-w-full flex-col items-center gap-4">
            <img :src="(active?.gallery || [])[vi]" :alt="active?.t" class="max-h-[80svh] max-w-full rounded-xl object-contain">
            <span class="rounded-full bg-sand-50/10 px-4 py-1.5 text-[0.7rem] font-medium tracking-wider text-sand-50 backdrop-blur-sm">
                <span x-text="vi + 1"></span> / <span x-text="(active?.gallery || []).length"></span>
            </span>
        </div>
        <button type="button" @click="viewNext()" aria-label="Siguiente"
            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-sand-50/10 p-3 text-sand-50 backdrop-blur-sm transition-colors hover:bg-sand-50/25 sm:right-6">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        </button>
        <button type="button" @click="viewer = false" aria-label="Cerrar"
            class="absolute right-4 top-4 rounded-full bg-sand-50/10 p-2.5 text-sand-50 backdrop-blur-sm transition-colors hover:bg-sand-50/25">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
    </div>
</section>
