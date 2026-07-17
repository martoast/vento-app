{{-- ============================== CONOCE VENTO ============================== --}}
<section id="proyecto" class="bg-sand-50 py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            {{-- Text --}}
            <div class="reveal-group">
                <p class="eyebrow text-wood-500">Conoce Vento</p>
                <h2 class="display mt-5 text-4xl font-light text-ink sm:text-5xl">Un proyecto en preventa <span class="accent-italic">85% terminado</span></h2>
                <p class="mt-6 text-lg leading-relaxed text-ink-soft">
                    Vento es un edificio departamental de tres niveles ubicado en la Colonia Obrera 1A Sección, dentro de la Delegación San Antonio de los Buenos. El proyecto reúne diseño contemporáneo, espacios funcionales y una atmósfera pensada para el descanso, la calma y la conexión con tus raíces.
                </p>

                <dl class="mt-8 grid grid-cols-2 gap-x-6 gap-y-5 sm:grid-cols-4">
                    @foreach ([
                        ['n' => '3', 'l' => 'Niveles'],
                        ['n' => '88 y 107', 'l' => 'm² por depto'],
                        ['n' => '2', 'l' => 'Recámaras'],
                        ['n' => '2', 'l' => 'Baños completos'],
                    ] as $stat)
                        <div>
                            <dt class="display whitespace-nowrap text-4xl font-light text-ink">{{ $stat['n'] }}</dt>
                            <dd class="eyebrow mt-1 text-[0.55rem] text-ink-soft">{{ $stat['l'] }}</dd>
                        </div>
                    @endforeach
                </dl>

                <ul class="mt-8 flex flex-wrap gap-2.5">
                    @foreach (['2 cajones de estacionamiento', 'Balcón o patio privado', 'Bodega opcional', 'Roof deck compartido', 'Acceso peatonal controlado', 'Portones eléctricos'] as $tag)
                        <li class="rounded-full bg-olive-500/10 px-4 py-2 text-xs font-medium text-olive-700">{{ $tag }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Image --}}
            <div class="reveal overflow-hidden rounded-3xl shadow-xl shadow-ink/10">
                <img src="{{ asset('images/vento-fachada.jpg') }}" alt="Fachada de Vento al atardecer" loading="lazy"
                    class="aspect-[4/3] w-full object-cover">
            </div>
        </div>
    </div>
</section>
