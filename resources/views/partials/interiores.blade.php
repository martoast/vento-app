{{-- ============================== GALERÍA DE INTERIORES ============================== --}}
@php
    $interiores = [
        ['img' => 'vento-sala.jpg',                 't' => 'Sala', 'span' => 'lg:col-span-2 lg:row-span-2'],
        ['img' => 'vento-cocina.jpg',               't' => 'Cocina y comedor', 'span' => ''],
        ['img' => 'vento-recamara-principal.jpg',   't' => 'Recámara principal', 'span' => ''],
        ['img' => 'vento-bano-2.jpg',               't' => 'Baño principal', 'span' => ''],
        ['img' => 'vento-recamara-balcon.jpg',      't' => 'Recámara secundaria', 'span' => ''],
        ['img' => 'vento-cocina-isla.jpg',          't' => 'Cocina con isla', 'span' => 'lg:col-span-2'],
        ['img' => 'vento-estancia.jpg',             't' => 'Estancia', 'span' => ''],
        ['img' => 'vento-bano-vanity.jpg',          't' => 'Segundo baño', 'span' => ''],
    ];
    $lb = collect($interiores)->map(fn ($e) => ['src' => asset('images/' . $e['img']), 't' => $e['t']])->values();
@endphp

<section id="interiores" class="bg-sand-100 py-24 lg:py-32"
    x-data="gallery(@js($lb))"
    @keydown.escape.window="open = false"
    @keydown.arrow-right.window="open && next()"
    @keydown.arrow-left.window="open && prev()">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal-group max-w-2xl">
            <p class="eyebrow text-wood-500">Interiores</p>
            <h2 class="display mt-5 text-4xl font-light text-ink sm:text-5xl">Espacios pensados para la <span class="accent-italic">vida diaria</span></h2>
            <p class="mt-4 text-base leading-relaxed text-ink-soft">Conoce interiores funcionales, cálidos y contemporáneos, diseñados para aprovechar la luz, la distribución y cada metro del departamento.</p>
        </div>

        <div class="reveal mt-12 grid auto-rows-[220px] grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ($interiores as $i)
                <button type="button" @click="show({{ $loop->index }})"
                    class="group relative overflow-hidden rounded-2xl bg-olive-950 {{ $i['span'] }}">
                    <img src="{{ asset('images/' . $i['img']) }}" alt="{{ $i['t'] }} — departamento Vento" loading="lazy"
                        class="h-full w-full object-cover transition-transform duration-[1.2s] ease-out group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-olive-950/60 via-transparent to-transparent opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <span class="eyebrow absolute bottom-4 left-4 text-[0.6rem] text-sand-50 opacity-0 transition-opacity group-hover:opacity-100">{{ $i['t'] }}</span>
                </button>
            @endforeach
        </div>

        <div class="reveal mt-10">
            <a href="#contacto" class="eyebrow inline-flex items-center justify-center rounded-full bg-wood-500 px-8 py-4 text-center text-[0.7rem] leading-snug text-sand-50 transition-colors hover:bg-wood-400">Agendar recorrido</a>
        </div>
    </div>

    @include('partials.lightbox')
</section>
