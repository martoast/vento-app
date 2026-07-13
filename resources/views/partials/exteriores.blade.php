{{-- ============================== GALERÍA DE EXTERIORES / ARQUITECTURA ============================== --}}
@php
    $exteriores = [
        ['img' => 'vento-fachada.jpg',            't' => 'Fachada principal', 'span' => 'lg:col-span-2 lg:row-span-2'],
        ['img' => 'vento-fachada-dia.jpg',        't' => 'Vista exterior', 'span' => ''],
        ['img' => 'vento-hero-movil.jpg',         't' => 'Fachada al atardecer', 'span' => ''],
        ['img' => 'vento-roofdeck-atardecer.jpg', 't' => 'Roof deck al atardecer', 'span' => 'lg:col-span-2'],
        ['img' => 'vento-acceso.jpg',             't' => 'Acceso peatonal', 'span' => ''],
        ['img' => 'vento-detalle.jpg',            't' => 'Detalles arquitectónicos', 'span' => ''],
        ['img' => 'vento-roofdeck.jpg',           't' => 'Roof deck', 'span' => 'lg:col-span-2'],
    ];
    $lb = collect($exteriores)->map(fn ($e) => ['src' => asset('images/' . $e['img']), 't' => $e['t']])->values();
@endphp

<section id="exteriores" class="bg-sand-50 py-24 lg:py-32"
    x-data="gallery(@js($lb))"
    @keydown.escape.window="open = false"
    @keydown.arrow-right.window="open && next()"
    @keydown.arrow-left.window="open && prev()">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal-group max-w-2xl">
            <p class="eyebrow text-wood-500">Arquitectura</p>
            <h2 class="display mt-5 text-4xl font-light text-ink sm:text-5xl">Exteriores que reflejan la identidad de <span class="accent-italic">Vento</span></h2>
            <p class="mt-4 text-base leading-relaxed text-ink-soft">Fachada, accesos y áreas compartidas con una estética contemporánea, funcional y coherente con la experiencia residencial del proyecto.</p>
        </div>

        <div class="reveal mt-12 grid auto-rows-[220px] grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ($exteriores as $e)
                <button type="button" @click="show({{ $loop->index }})"
                    class="group relative overflow-hidden rounded-2xl bg-olive-950 {{ $e['span'] }}">
                    <img src="{{ asset('images/' . $e['img']) }}" alt="{{ $e['t'] }} — Vento" loading="lazy"
                        class="h-full w-full object-cover transition-transform duration-[1.2s] ease-out group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-olive-950/60 via-transparent to-transparent opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <span class="eyebrow absolute bottom-4 left-4 text-[0.6rem] text-sand-50 opacity-0 transition-opacity group-hover:opacity-100">{{ $e['t'] }}</span>
                </button>
            @endforeach
        </div>
    </div>

    @include('partials.lightbox')
</section>
