{{-- ============================== BROKERS ============================== --}}
<section id="brokers" class="bg-sand-50 py-20 lg:py-28">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="reveal overflow-hidden rounded-3xl bg-olive-950 text-sand-50">
            <div class="grid lg:grid-cols-2">
                <div class="p-10 lg:p-14">
                    <p class="eyebrow text-wood-300">Aliados comerciales</p>
                    <h2 class="display mt-5 text-3xl font-light sm:text-4xl">Comercializa <span class="accent-italic">Vento</span></h2>
                    <p class="mt-6 text-base leading-relaxed text-sand-100/80">
                        Conoce la información comercial, disponibilidad, tipologías y materiales disponibles para presentar Vento a tus clientes.
                    </p>
                    <a href="#contacto" id="cta-brokers"
                        onclick="var s = document.getElementById('interes'); if (s) s.value = 'Información para brokers';"
                        class="eyebrow mt-8 inline-flex items-center justify-center rounded-full bg-wood-500 px-8 py-4 text-center text-[0.7rem] leading-snug text-sand-50 transition-colors hover:bg-wood-400">Quiero recibir información para brokers</a>
                </div>
                <div class="relative min-h-[260px] lg:min-h-full">
                    <img src="{{ asset('images/vento-cocina-luz.jpg') }}" alt="Interior de departamento Vento" loading="lazy"
                        class="absolute inset-0 h-full w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>
