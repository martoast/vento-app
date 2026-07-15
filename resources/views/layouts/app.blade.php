<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Lock scroll during the first-load preloader (safety-unlocks after 14s) --}}
    <script>
        document.documentElement.classList.add('is-loading');
        setTimeout(function () { document.documentElement.classList.remove('is-loading'); }, 14000);
    </script>

    @php
        $siteUrl = rtrim(config('app.url'), '/');
        $metaTitle = $title ?? 'Vento Tijuana | Departamentos de 2 recámaras';
        $metaDesc = $description ?? 'Conoce Vento, un proyecto residencial en Tijuana con departamentos de 88 m² y 107 m², dos recámaras, roof deck, estacionamiento y acceso controlado.';
        $ogImage = $siteUrl . '/images/og-vento.jpg';
    @endphp
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="keywords" content="Vento, departamentos Tijuana, departamentos 2 recámaras, Colonia Obrera Tijuana, City Inmobiliaria, roof deck, departamentos nuevos Tijuana, Molding Home, Taller N3">
    <meta name="author" content="City Inmobiliaria">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#191b0f">
    <link rel="canonical" href="{{ $siteUrl }}/">

    {{-- Icons --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" href="/icon-512.png" sizes="512x512">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    {{-- Open Graph (WhatsApp, Facebook, iMessage, LinkedIn) — URLs must be absolute --}}
    <meta property="og:site_name" content="Vento">
    <meta property="og:title" content="Vento · Departamentos residenciales en Tijuana">
    <meta property="og:description" content="Departamentos de 88 m² y 107 m² con dos recámaras, roof deck compartido, dos cajones de estacionamiento y acceso controlado.">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:secure_url" content="{{ $ogImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Vento — edificio departamental en Tijuana">
    <meta property="og:url" content="{{ $siteUrl }}/">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_MX">

    {{-- Twitter / X card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Vento · Departamentos residenciales en Tijuana">
    <meta name="twitter:description" content="Departamentos de 88 m² y 107 m², dos recámaras, roof deck y acceso controlado. Comercializado por City Inmobiliaria.">
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="twitter:image:alt" content="Vento — Tijuana">

    {{-- Structured data — Apartment building --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ApartmentComplex',
        'name' => 'Vento',
        'description' => $metaDesc,
        'url' => $siteUrl . '/',
        'image' => $ogImage,
        'slogan' => 'Diseño, calma y conexión para vivir una nueva etapa',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Calle General Emiliano Zapata, Lt. 002, Mz. 044, Colonia Obrera 1A Sección, San Antonio de los Buenos',
            'addressLocality' => 'Tijuana',
            'addressRegion' => 'Baja California',
            'addressCountry' => 'MX',
        ],
        'numberOfBedrooms' => 2,
        'developer' => ['@type' => 'Organization', 'name' => 'Molding Home Desarrolladora'],
        'broker' => ['@type' => 'RealEstateAgent', 'name' => 'City Inmobiliaria'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{ navSolid: false, navOpen: false }"
    @scroll.window.passive="navSolid = window.scrollY > 40"
    :class="navOpen ? 'overflow-hidden lg:overflow-auto' : ''"
>

    {{-- ============================== PRELOADER ============================== --}}
    <div id="preloader" class="fixed inset-0 z-[100] flex items-center justify-center bg-olive-950">
        <div class="preloader-mark flex flex-col items-center text-sand-50">
            @include('partials.logo')
            <div class="mt-10 h-px w-44 overflow-hidden rounded-full bg-sand-50/15">
                <div id="preloader-bar" class="h-full w-0 rounded-full bg-wood-400 transition-[width] duration-300 ease-out"></div>
            </div>
            <p id="preloader-pct" class="eyebrow mt-4 text-[0.55rem] text-sand-200/50">0%</p>
        </div>
    </div>

    @php
        $navLinks = [
            ['label' => 'Proyecto',    'href' => '#proyecto'],
            ['label' => 'Tipologías',  'href' => '#tipologias'],
            ['label' => 'Amenidades',  'href' => '#amenidades'],
            ['label' => 'Ubicación',   'href' => '#ubicacion'],
        ];

        // Contacto comercial — pendiente: teléfono, WhatsApp y correo de City Inmobiliaria.
        // Cuando lleguen, se agregan aquí y los botones flotantes/footer se activan solos.
        $instagramUrl = 'https://www.instagram.com/vento.tij';
        $mapsUrl = 'https://maps.google.com/?q=Calle+General+Emiliano+Zapata,+Obrera+1ra.+Secci%C3%B3n,+Tijuana,+B.C.';
        $waNumber = null;  // ej. '526641234567'
        $telNumber = null; // ej. '+526641234567'
        $waText = rawurlencode('Hola, me interesa Vento. ¿Me pueden enviar información de disponibilidad?');
    @endphp

    {{-- ============================== NAV ============================== --}}
    <header
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500"
        :class="navSolid || navOpen ? 'bg-sand-50/95 backdrop-blur-sm shadow-[0_1px_0_0_rgba(35,32,25,0.08)]' : 'bg-transparent'"
    >
        <nav class="relative mx-auto flex max-w-7xl items-center justify-between px-6 py-5 lg:px-10">
            {{-- Logo --}}
            <a
                href="#inicio"
                class="group relative z-50 flex items-center gap-3 transition-colors duration-500"
                :class="navSolid || navOpen ? 'text-ink' : 'text-sand-50'"
                aria-label="Vento — inicio"
            >
                @include('partials.logo', ['variant' => 'auto'])
            </a>

            {{-- Desktop links — centered in the navbar --}}
            <div class="absolute left-1/2 hidden -translate-x-1/2 items-center gap-5 lg:flex xl:gap-10">
                @foreach ($navLinks as $item)
                    <a
                        href="{{ $item['href'] }}"
                        class="nav-link eyebrow whitespace-nowrap text-[0.65rem] transition-colors duration-300"
                        :class="navSolid ? 'text-ink-soft hover:text-wood-500' : 'text-sand-100 hover:text-white'"
                    >{{ $item['label'] }}</a>
                @endforeach
            </div>

            {{-- CTA (right) --}}
            <a
                href="#contacto"
                id="cta-nav"
                class="eyebrow z-50 hidden whitespace-nowrap rounded-full px-4 py-2.5 text-[0.65rem] text-sand-50 transition-all duration-300 bg-wood-500 hover:bg-wood-400 lg:inline-flex xl:px-5"
            ><span class="hidden xl:inline">Solicitar disponibilidad</span><span class="xl:hidden">Contacto</span></a>

            {{-- Mobile hamburger --}}
            <button
                class="relative z-50 flex h-10 w-10 flex-col items-center justify-center gap-1.5 lg:hidden"
                @click="navOpen = !navOpen"
                aria-label="Menú"
            >
                <span class="block h-px w-6 transition-all duration-300"
                    :class="[navOpen ? 'translate-y-[3.5px] rotate-45' : '', navSolid || navOpen ? 'bg-ink' : 'bg-sand-50']"></span>
                <span class="block h-px w-6 transition-all duration-300"
                    :class="[navOpen ? '-translate-y-[3.5px] -rotate-45' : '', navSolid || navOpen ? 'bg-ink' : 'bg-sand-50']"></span>
            </button>
        </nav>

        {{-- Mobile menu --}}
        <div
            x-show="navOpen"
            x-collapse.duration.400ms
            class="lg:hidden"
        >
            <div class="space-y-1 border-t border-ink/5 bg-sand-50 px-6 pb-8 pt-4">
                @foreach ($navLinks as $item)
                    <a href="{{ $item['href'] }}" @click="navOpen = false"
                        class="display block py-3 text-2xl text-ink transition-colors hover:text-wood-500">{{ $item['label'] }}</a>
                @endforeach
                <a href="#contacto" @click="navOpen = false"
                    class="display block py-3 text-2xl text-ink transition-colors hover:text-wood-500">Contacto</a>
                <a href="#contacto" @click="navOpen = false"
                    class="eyebrow mt-4 inline-block rounded-full bg-wood-500 px-6 py-3 text-[0.65rem] text-sand-50">Solicitar disponibilidad</a>
            </div>
        </div>
    </header>

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    {{-- ============================== FOOTER ============================== --}}
    <footer class="bg-olive-950 text-sand-200">
        <div class="mx-auto max-w-7xl px-6 py-16 lg:px-10">
            <div class="grid gap-12 md:grid-cols-3">
                {{-- Brand + address --}}
                <div class="text-sand-50">
                    @include('partials.logo')
                    <p class="mt-6 max-w-xs text-sm leading-relaxed text-sand-200/70">
                        Calle General Emiliano Zapata, Lt. 002, Mz. 044,<br>
                        Colonia Obrera 1A Sección,<br>
                        San Antonio de los Buenos, Tijuana, B.C.
                    </p>
                    <p class="mt-5 text-xs leading-relaxed text-sand-200/55">
                        Comercializado por City Inmobiliaria.<br>
                        Un proyecto de Molding Home Desarrolladora · Taller N3 Arquitectos.
                    </p>
                </div>

                {{-- Quick links --}}
                <div>
                    <p class="eyebrow mb-5 text-[0.6rem] text-wood-300">El proyecto</p>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#proyecto" class="transition-colors hover:text-wood-300">Conoce Vento</a></li>
                        <li><a href="#tipologias" class="transition-colors hover:text-wood-300">Tipologías</a></li>
                        <li><a href="#disponibilidad" class="transition-colors hover:text-wood-300">Disponibilidad</a></li>
                        <li><a href="#amenidades" class="transition-colors hover:text-wood-300">Amenidades</a></li>
                        <li><a href="#ubicacion" class="transition-colors hover:text-wood-300">Ubicación</a></li>
                        <li><a href="#interiores" class="transition-colors hover:text-wood-300">Interiores</a></li>
                    </ul>
                </div>

                {{-- Contacto --}}
                <div>
                    <p class="eyebrow mb-5 text-[0.6rem] text-wood-300">Contacto</p>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 transition-colors hover:text-wood-300">
                                <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.2 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.2 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.2-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.2-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4 1.3-.1 1.7-.1 4.9-.1zm0 2c-3.1 0-3.5 0-4.8.1-1.1.1-1.5.2-1.8.3-.4.2-.7.3-1 .6-.3.3-.5.6-.6 1-.1.3-.3.7-.3 1.8-.1 1.3-.1 1.6-.1 4.8s0 3.5.1 4.8c.1 1.1.2 1.5.3 1.8.2.4.3.7.6 1 .3.3.6.5 1 .6.3.1.7.3 1.8.3 1.3.1 1.6.1 4.8.1s3.5 0 4.8-.1c1.1-.1 1.5-.2 1.8-.3.4-.2.7-.3 1-.6.3-.3.5-.6.6-1 .1-.3.3-.7.3-1.8.1-1.3.1-1.6.1-4.8s0-3.5-.1-4.8c-.1-1.1-.2-1.5-.3-1.8-.2-.4-.3-.7-.6-1-.3-.3-.6-.5-1-.6-.3-.1-.7-.3-1.8-.3-1.3-.1-1.6-.1-4.8-.1zm0 3.4a4.4 4.4 0 1 1 0 8.8 4.4 4.4 0 0 1 0-8.8zm0 7.2a2.8 2.8 0 1 0 0-5.6 2.8 2.8 0 0 0 0 5.6zm5.6-7.4a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
                                Instagram · @vento.tij
                            </a>
                        </li>
                        <li>
                            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 transition-colors hover:text-wood-300">
                                <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
                                Ver en Google Maps
                            </a>
                        </li>
                        {{-- TODO: WhatsApp, teléfono y correo de City Inmobiliaria (pendientes de confirmación) --}}
                    </ul>
                    <a href="#contacto" class="eyebrow mt-7 inline-flex items-center justify-center rounded-full bg-wood-500 px-7 py-3.5 text-[0.65rem] text-sand-50 transition-colors hover:bg-wood-400">Solicitar información</a>
                </div>
            </div>

            <div class="mt-14 border-t border-sand-50/10 pt-8 text-xs leading-relaxed text-sand-200/50">
                <p>© {{ date('Y') }} Vento · Comercializado por City Inmobiliaria. Todos los derechos reservados. · Aviso de Privacidad <span class="text-sand-200/30">· v1.0.6</span></p>
                <p class="mt-2">
                    Las imágenes mostradas son representaciones ilustrativas del proyecto y pueden variar respecto al producto final.
                    La información de tipologías, medidas, precios, acabados y disponibilidad está sujeta a cambios sin previo aviso.
                </p>
            </div>
        </div>
    </footer>

    {{-- ============================== FLOATING ACTIONS ============================== --}}
    <div class="fixed right-3 top-1/2 z-40 flex -translate-y-1/2 flex-col items-center gap-2.5 sm:right-6 sm:gap-3">
        {{-- Maps --}}
        <a href="{{ $mapsUrl }}" target="_blank" rel="noopener" aria-label="Ver ubicación en Google Maps"
            class="flex h-10 w-10 items-center justify-center rounded-full bg-olive-900 text-sand-50 shadow-lg shadow-ink/20 transition-transform duration-300 hover:scale-110 sm:h-12 sm:w-12">
            <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current sm:h-6 sm:w-6"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
        </a>
        {{-- Instagram --}}
        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" aria-label="Instagram de Vento"
            class="flex h-10 w-10 items-center justify-center rounded-full bg-wood-500 text-sand-50 shadow-lg shadow-ink/20 transition-transform duration-300 hover:scale-110 sm:h-12 sm:w-12">
            <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.2 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.2 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.2-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.2-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4 1.3-.1 1.7-.1 4.9-.1zm0 2c-3.1 0-3.5 0-4.8.1-1.1.1-1.5.2-1.8.3-.4.2-.7.3-1 .6-.3.3-.5.6-.6 1-.1.3-.3.7-.3 1.8-.1 1.3-.1 1.6-.1 4.8s0 3.5.1 4.8c.1 1.1.2 1.5.3 1.8.2.4.3.7.6 1 .3.3.6.5 1 .6.3.1.7.3 1.8.3 1.3.1 1.6.1 4.8.1s3.5 0 4.8-.1c1.1-.1 1.5-.2 1.8-.3.4-.2.7-.3 1-.6.3-.3.5-.6.6-1 .1-.3.3-.7.3-1.8.1-1.3.1-1.6.1-4.8s0-3.5-.1-4.8c-.1-1.1-.2-1.5-.3-1.8-.2-.4-.3-.7-.6-1-.3-.3-.6-.5-1-.6-.3-.1-.7-.3-1.8-.3-1.3-.1-1.6-.1-4.8-.1zm0 3.4a4.4 4.4 0 1 1 0 8.8 4.4 4.4 0 0 1 0-8.8zm0 7.2a2.8 2.8 0 1 0 0-5.6 2.8 2.8 0 0 0 0 5.6zm5.6-7.4a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
        </a>
        {{-- Contacto (formulario) --}}
        <a href="#contacto" aria-label="Ir al formulario de contacto"
            class="flex h-14 w-14 items-center justify-center rounded-full bg-olive-600 shadow-lg shadow-ink/20 transition-transform duration-300 hover:scale-110">
            <svg viewBox="0 0 24 24" class="h-5 w-5 fill-white sm:h-7 sm:w-7"><path d="M20 2H4a2 2 0 0 0-2 2v18l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
        </a>
        {{-- TODO: botón flotante de WhatsApp — activar cuando exista el número comercial:
        @if ($waNumber)
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" ...>WhatsApp</a>
        @endif --}}
    </div>

</body>
</html>
