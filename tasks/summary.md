# Vento — Landing Page

## Qué es
Landing page one-pager para **Vento**, edificio departamental de 3 niveles en
Calle General Emiliano Zapata, Lt. 002, Mz. 044, Col. Obrera 1A Sección,
San Antonio de los Buenos, Tijuana, B.C. Departamentos de 88 m² y 107 m²
(2 recámaras, 2 baños, roof deck compartido, 2 cajones, bodega).
Comercializado por **City Inmobiliaria**; desarrolla Molding Home, arquitectura Taller N3.

Cliente: Ricardo. Proyecto hermano de Riviera Residencial y Costa Real —
mismo blueprint estructural (ver `docs/landing-page-structure.md`), skin propia
de Vento (olivo/beige/madera, serif Baskerville).

## Stack
- Laravel Blade + Tailwind CSS v4 + Alpine.js (una sección = un partial en `resources/views/partials/`)
- Export estático con `./build-static.sh` (SITE_URL horneado; aborta si el home no da 200)
- Netlify (sitio `vento-tijuana`, cuenta team Fullstack Bolt) + Netlify Forms (`name="asesoria"`)
- CI: push a `main` → GitHub Actions → build + deploy (secrets NETLIFY_AUTH_TOKEN / NETLIFY_SITE_ID)

## Secciones (orden)
hero → proyecto → roofdeck → tipologias → aspiracional → disponibilidad →
amenidades (slider + modal bento) → ubicacion → interiores → exteriores →
asesoria (form) → respaldo (marcas) → brokers → cta-final

## Contenido editable
- Tipologías y su estado (Disponible/Apartado/Vendido): array en `partials/tipologias.blade.php`
- Resumen de disponibilidad: array en `partials/disponibilidad.blade.php`
- Amenidades: array en `partials/amenidades.blade.php`
- Datos de contacto (WhatsApp/tel pendientes): `@php` block en `layouts/app.blade.php`

## Desarrollo local
```bash
composer install && npm install
npm run dev          # vite
php artisan serve    # http://127.0.0.1:8000  (?nopreload salta el preloader)
```
