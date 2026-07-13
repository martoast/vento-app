{{-- ============================== DISPONIBILIDAD ============================== --}}
@php
    // Editable inventory summary — precios pendientes de confirmación comercial.
    $unidades = [
        [
            'n' => '88 m²',
            'l' => 'Departamentos de 88 m²',
            'specs' => ['Dos recámaras', 'Dos baños completos', 'Balcón privado según unidad', 'Dos cajones de estacionamiento', 'Bodega'],
        ],
        [
            'n' => '107 m²',
            'l' => 'Departamentos de 107 m²',
            'specs' => ['Dos recámaras', 'Dos baños completos', 'Patio privado según unidad', 'Dos cajones de estacionamiento', 'Bodega'],
        ],
    ];
@endphp

<section id="disponibilidad" class="bg-olive-950 py-24 text-sand-50 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal-group max-w-2xl">
            <p class="eyebrow text-wood-300">Disponibilidad</p>
            <h2 class="display mt-5 text-4xl font-light sm:text-5xl">Consulta unidades <span class="accent-italic">disponibles</span></h2>
            <p class="mt-5 text-lg leading-relaxed text-sand-100/80">La disponibilidad puede cambiar. Solicita información actualizada sobre tipologías, nivel, ubicación dentro del edificio, superficie, precio y condiciones de compra.</p>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-2">
            @foreach ($unidades as $u)
                <div class="reveal rounded-3xl border border-sand-50/15 bg-sand-50/[0.04] p-10 backdrop-blur-sm">
                    <p class="eyebrow text-[0.6rem] text-wood-300">{{ $u['l'] }}</p>
                    <p class="display mt-4 text-5xl font-light lg:text-6xl">{{ $u['n'] }}</p>
                    <ul class="mt-7 space-y-2.5">
                        @foreach ($u['specs'] as $spec)
                            <li class="flex items-start gap-2.5 text-sm text-sand-100/85">
                                <svg class="mt-1 h-3.5 w-3.5 shrink-0 text-wood-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.3 3.3 6.8-6.8a1 1 0 0 1 1.4 0z" clip-rule="evenodd"/></svg>
                                <span>{{ $spec }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-7 border-t border-sand-50/10 pt-5 text-sm text-sand-200/60">Precio · <span class="font-medium text-sand-50">Consultar</span></p>
                </div>
            @endforeach
        </div>

        <p class="reveal mt-8 text-center text-xs text-sand-200/45">Disponibilidad, precios, medidas, acabados y condiciones sujetos a cambio sin previo aviso.</p>
        <div class="reveal mt-8 text-center">
            <a href="#contacto" class="eyebrow inline-flex items-center justify-center rounded-full bg-wood-500 px-8 py-4 text-[0.7rem] text-sand-50 transition-colors hover:bg-wood-400">Solicitar disponibilidad actualizada</a>
        </div>
    </div>
</section>
