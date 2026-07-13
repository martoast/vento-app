# Component Library

Reusable front-end components we've built for Real del Mar, documented so we can
drop them into other sites (any Laravel + Blade + Tailwind v4 + Alpine.js + Three.js
project — the same stack as Bolt and Real del Mar).

Each doc explains **what it is**, **how it works**, and **how to reuse it** (files to
copy, dependencies, and the knobs you can tune).

> Looking for the page-level blueprint instead of individual components? See
> **[landing-page-structure.md](landing-page-structure.md)** — the section order,
> layout archetypes, and porting checklist for replicating this landing page's
> structure on other real-estate developments. And for the **end-to-end process**
> of launching a new sibling site (clone → rebrand → QA → deploy → repo + CI), see
> **[new-landing-playbook.md](new-landing-playbook.md)**.

## Catalog

| Codename | What it is | Files | Deps |
|----------|-----------|-------|------|
| **[Tideband](components/tideband.md)** | Full-bleed animated WebGL ocean band — layered noise swell, mouse-reactive "sun path", static gradient fallback | `resources/js/ocean-bg.js` + CSS gradient host | `three` |
| **[Driftrow](components/driftrow.md)** | Dual-row infinite horizontal marquee gallery with opposite-direction scroll, pause-on-hover, and an Alpine lightbox | `partials/galeria.blade.php` + `.marquee*` CSS | `alpinejs` |
| **[Cinebar](components/cinebar.md)** | Full-bleed autoplay video banner with poster fallback and centered headline | `partials/cta-video.blade.php` | none |

## Shared conventions

These components assume a few project-wide primitives that live in
`resources/css/app.css` (`@theme` block). When porting to a new site, either copy these
tokens or remap the class names:

- **Palette**: `sand-*` (backgrounds), `ocean-*` (dark bands/accents), `terra-*` (warm CTA accent), `ink` / `ink-soft` (text). Defined as `--color-*` in `@theme`.
- **Type**: `.display` (Fraunces serif, with italic `em` accent) and `.eyebrow` (uppercase tracked label).
- **Motion**: `.reveal` / `.reveal-group` scroll-reveal classes driven by `resources/js/reveal.js` (IntersectionObserver adds `.is-revealed`). All components degrade gracefully under `prefers-reduced-motion`.

## How these get bootstrapped

`resources/js/app.js` imports the JS modules and starts Alpine:

```js
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import './ocean-bg.js';   // Tideband — auto-mounts on [data-ocean-bg]
import './reveal.js';     // scroll reveals

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();
```

`@vite(['resources/css/app.css', 'resources/js/app.js'])` in the layout `<head>` loads everything.
