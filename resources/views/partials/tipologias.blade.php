{{-- ============================== TIPOLOGÍAS VENTO ============================== --}}
@php
    $tipologias = [
        [
            'nombre' => 'Tipología A 01',
            'estado' => 'Disponible', // editable: Disponible · Apartado · Vendido
            'img' => 'vento-sala.jpg',
            'plano' => 0,
            'specs' => ['107 m² de construcción', 'Patio privado', 'Sala · cocina · comedor', 'Área de lavado', 'Recámara principal king size con walk-in closet', 'Recámara secundaria', '2 baños completos', 'Salidas para aire acondicionado'],
        ],
        [
            'nombre' => 'Tipología A 02',
            'estado' => 'Disponible',
            'img' => 'vento-sala-2.jpg',
            'plano' => 1,
            'specs' => ['88 m² de construcción', 'Balcón privado', 'Sala · cocina · comedor', 'Área de lavado', 'Recámara principal king size con walk-in closet', 'Recámara secundaria', '2 baños completos', 'Salidas para aire acondicionado'],
        ],
        [
            'nombre' => 'Tipología B 01',
            'estado' => 'Disponible',
            'img' => 'vento-estancia.jpg',
            'plano' => 2,
            'specs' => ['Versión de 107 m² con patio privado', 'Versión de 88 m² con balcón privado', 'Sala · cocina · comedor', 'Área de lavado', 'Recámara principal con walk-in closet', 'Recámara secundaria', '2 baños completos', 'Salidas para aire acondicionado'],
        ],
    ];

    // Planos shown in the lightbox — B 01 has both versions (arrows navigate).
    $planos = [
        ['src' => asset('images/vento-plano-a01.jpg?v=1784081349'), 't' => 'Tipología A 01 — 107 m² · patio privado'],
        ['src' => asset('images/vento-plano-a02.jpg?v=1784081349'), 't' => 'Tipología A 02 — 88 m² · balcón privado'],
        ['src' => asset('images/vento-plano-b01-107.jpg?v=1784081349'), 't' => 'Tipología B 01 — 107 m² · patio privado'],
        ['src' => asset('images/vento-plano-b01-88.jpg?v=1784081349'), 't' => 'Tipología B 01 — 88 m² · balcón privado'],
    ];
@endphp

<section id="tipologias" class="bg-sand-100 py-24 lg:py-32"
    x-data="gallery(@js(collect($planos)))"
    @keydown.escape.window="open = false"
    @keydown.arrow-right.window="open && next()"
    @keydown.arrow-left.window="open && prev()">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal-group max-w-2xl">
            <p class="eyebrow text-wood-500">Tipologías Vento</p>
            <h2 class="display mt-5 text-4xl font-light text-ink sm:text-5xl">Elige el espacio que mejor se <span class="accent-italic">adapta a ti</span></h2>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($tipologias as $t)
                <article class="reveal group flex flex-col overflow-hidden rounded-3xl bg-white shadow-lg shadow-ink/5 ring-1 ring-ink/5 {{ $loop->last ? 'md:col-span-2 md:mx-auto md:max-w-md xl:col-span-1 xl:max-w-none' : '' }}">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('images/' . $t['img'] . '?v=1784081464') }}" alt="{{ $t['nombre'] }} — interior Vento" loading="lazy"
                            class="aspect-[16/10] w-full object-cover transition-transform duration-[1.2s] ease-out group-hover:scale-105">
                        <span class="absolute left-5 top-5 rounded-full bg-olive-950/70 px-4 py-1.5 text-xs font-medium text-sand-50 backdrop-blur-sm">{{ $t['estado'] }}</span>
                    </div>
                    <div class="flex grow flex-col p-8">
                        <h3 class="display text-3xl font-light text-ink">{{ $t['nombre'] }}</h3>
                        <ul class="mt-5 space-y-2.5">
                            @foreach ($t['specs'] as $spec)
                                <li class="flex items-start gap-2 text-sm text-ink-soft">
                                    <svg class="mt-1 h-3.5 w-3.5 shrink-0 text-wood-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.3 3.3 6.8-6.8a1 1 0 0 1 1.4 0z" clip-rule="evenodd"/></svg>
                                    <span>{{ $spec }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-auto flex flex-col gap-3 pt-7">
                            <button type="button" @click="show({{ $t['plano'] }})" id="plano-{{ $loop->index }}"
                                class="eyebrow inline-flex items-center justify-center rounded-full bg-city-blue px-6 py-3 text-[0.65rem] text-city-white transition-colors hover:bg-wood-400">Ver distribución</button>
                            <a href="#contacto"
                                class="eyebrow inline-flex items-center justify-center rounded-full border border-ink/20 px-6 py-3 text-[0.65rem] text-ink transition-colors hover:border-ink hover:bg-ink hover:text-sand-50">Consultar disponibilidad</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="reveal mt-8 text-center text-xs text-ink-soft/70">Tipologías, medidas y acabados sujetos a cambio sin previo aviso. Estado de disponibilidad actualizado con el equipo comercial.</p>
    </div>

    @include('partials.lightbox')
</section>
