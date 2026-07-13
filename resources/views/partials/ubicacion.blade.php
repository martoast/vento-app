{{-- ============================== UBICACIÓN ============================== --}}
<section id="ubicacion" class="bg-olive-950 py-24 text-sand-50 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Text --}}
            <div class="reveal-group">
                <p class="eyebrow text-wood-300">Ubicación</p>
                <h2 class="display mt-5 text-4xl font-light sm:text-5xl">Conectado con puntos estratégicos de <span class="accent-italic">Tijuana</span></h2>
                <p class="mt-4 text-base leading-relaxed text-wood-300">Calle General Emiliano Zapata, Lt. 002, Mz. 044, Colonia Obrera 1A Sección, Delegación San Antonio de los Buenos, Tijuana, Baja California.</p>
                <p class="mt-6 text-lg leading-relaxed text-sand-100/80">
                    Vento se ubica en una zona con conexión hacia distintos puntos de Tijuana, combinando cercanía urbana con una atmósfera residencial.
                </p>

                <ul class="mt-9 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @foreach ([
                        'Zona Centro',
                        'Zona Río',
                        'Garita de San Ysidro',
                        'Libramiento Sur Rosas Magallón',
                        'Blvd. Fundadores',
                        'Cumbres de Juárez',
                        'Colonia Madero · La Cacho',
                        'Parques y escuelas cercanos',
                    ] as $punto)
                        <li class="flex items-start gap-3 text-sm text-sand-100/85">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-wood-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
                            <span>{{ $punto }}</span>
                        </li>
                    @endforeach
                </ul>

                <a href="https://maps.google.com/?q=Calle+General+Emiliano+Zapata,+Obrera+1ra.+Secci%C3%B3n,+Tijuana,+B.C." target="_blank" rel="noopener" id="cta-mapa"
                    class="eyebrow mt-9 inline-flex items-center justify-center rounded-full bg-wood-500 px-8 py-4 text-[0.7rem] text-sand-50 transition-colors hover:bg-wood-400">Ver ubicación en mapa</a>
            </div>

            {{-- Map --}}
            <div class="reveal overflow-hidden rounded-3xl border border-sand-50/15 shadow-xl shadow-ink/20">
                <iframe
                    title="Mapa de Vento — Colonia Obrera 1A Sección, Tijuana"
                    src="https://maps.google.com/maps?q=Calle%20General%20Emiliano%20Zapata%2C%20Obrera%201ra.%20Secci%C3%B3n%2C%20Tijuana%2C%20B.C.&t=&z=14&ie=UTF8&iwloc=&output=embed"
                    class="aspect-[4/3] w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
