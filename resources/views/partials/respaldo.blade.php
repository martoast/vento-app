{{-- ============================== RESPALDO Y COMERCIALIZACIÓN ============================== --}}
<section class="bg-sand-50 pb-8 pt-24 lg:pt-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal-group mx-auto max-w-2xl text-center">
            <p class="eyebrow text-wood-500">Respaldo</p>
            <h2 class="display mt-5 text-4xl font-light text-ink sm:text-5xl">Comercializado por <span class="accent-italic">City Inmobiliaria</span></h2>
            <p class="mt-5 text-lg leading-relaxed text-ink-soft">Vento es comercializado por City Inmobiliaria, con una propuesta enfocada en acercar proyectos residenciales con diseño, ubicación y valor patrimonial.</p>
        </div>

        {{-- TODO: sustituir los wordmarks por los logos oficiales (Vento, City Inmobiliaria,
             Taller N3 Arquitectos, Molding Home) cuando el cliente entregue los archivos. --}}
        <div class="reveal mx-auto mt-12 grid max-w-4xl grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ([
                ['n' => 'Vento', 'l' => 'Proyecto'],
                ['n' => 'City Inmobiliaria', 'l' => 'Comercialización'],
                ['n' => 'Taller N3', 'l' => 'Arquitectura'],
                ['n' => 'Molding Home', 'l' => 'Desarrolladora'],
            ] as $marca)
                <div class="flex min-h-[7rem] flex-col items-center justify-center gap-2 rounded-2xl bg-white px-6 py-7 text-center ring-1 ring-ink/5">
                    <span class="display text-lg font-light uppercase tracking-[0.14em] text-ink">{{ $marca['n'] }}</span>
                    <span class="eyebrow text-[0.5rem] text-ink-soft/70">{{ $marca['l'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
