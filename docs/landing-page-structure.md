# Real-Estate Landing Page — Structural Blueprint

How the Riviera Residencial one-pager is organized, documented **structure-only** so we
can rebuild the same skeleton for any other development. Colors, fonts, and copy are the
per-project skin — swap them freely; this doc is about *what sections exist, in what
order, and how each one is laid out*.

Stack assumption: Laravel Blade + Tailwind + Alpine.js, one section = one partial in
`resources/views/partials/`, composed in `home.blade.php`. Static-exported with
`build-static.sh` and deployed to Netlify.

---

## 1. The narrative arc

The page is a single scroll that alternates between **emotion** (full-bleed photo bands)
and **information** (light content sections), tightening toward conversion. The order
matters more than any individual section:

| # | Section (partial) | Job in the funnel | Type |
|---|-------------------|-------------------|------|
| 1 | `hero` | Instant identity: where you are, what this is | Immersive band |
| 2 | `proyecto` | "What is this project?" — numbers + proof photo | Split 50/50 |
| 3 | `video` | Let the drone video sell the dream | Framed embed |
| 4 | `casa-club` | First amenity tease (signature amenity) | Immersive band |
| 5 | `modelos` | The product: house models side by side | Card grid |
| 6 | `aspiracional` | Emotional palate-cleanser + first hard CTA | Immersive band |
| 7 | `precios` | Prices — after desire, before logistics | Dark stat cards |
| 8 | `zona` | Master-community amenities (the lifestyle) | Horizontal slider + modal |
| 9 | `ubicacion` | "How far from X?" — drive times + map | Split 50/50 |
| 10 | `interiores` | Photo proof: inside the homes | Bento gallery |
| 11 | `exteriores` | Photo proof: outside the homes | Bento gallery |
| 12 | `asesoria` | **The conversion point** — lead form | Narrow form |
| 13 | `brokers` | Secondary audience (broker recruitment) | Boxed banner |
| 14 | `cta-final` | Last emotional push back to the form | Immersive band |

Rules of thumb baked into this order:

- **Never two immersive (dark full-bleed photo) bands in a row.** Light info section →
  dark emotional band → light info section. The rhythm is the design.
- **Desire before price.** Models and an aspirational band come *before* `precios`.
- **Proof before ask.** Both galleries sit right before the contact form.
- **Every section's CTA points at `#contacto`** (or the next logical anchor). The page
  is a funnel; there are no dead ends.
- Secondary-audience content (`brokers`) goes *after* the form so it never interrupts
  the buyer path.

## 2. The section shell (shared skeleton)

Every non-immersive section uses the same wrapper, so spacing is uniform page-wide:

```html
<section id="…" class="{bg} py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <!-- header block -->
        <div class="reveal-group max-w-2xl">
            <p class="eyebrow …">Section label</p>
            <h2 class="display mt-5 text-4xl font-light sm:text-5xl">
                Headline with an <span class="accent-italic">italic accent</span>
            </h2>
            <p class="mt-4 text-lg …">Optional lead paragraph.</p>
        </div>
        <!-- body, usually mt-12 / mt-14 -->
    </div>
</section>
```

Constants to keep when porting:

- **Vertical rhythm**: `py-24 lg:py-32` (a slightly tighter `py-20 lg:py-28` is fine for
  minor sections like `brokers`).
- **Container**: `max-w-7xl px-6 lg:px-10`; drop to `max-w-5xl` for framed media
  (`video`), `max-w-3xl` for centered manifesto copy, `max-w-xl` for the form.
- **Header pattern**: eyebrow → `display` h2 (always one italic accent phrase) → lead.
  Left-aligned with `max-w-2xl` by default; centered only in immersive bands and the form.
- **Scroll reveals**: `.reveal` on single blocks, `.reveal-group` on header stacks
  (IntersectionObserver in `resources/js/reveal.js`).
- **Radius language**: big media/cards `rounded-3xl`, gallery tiles `rounded-2xl`,
  pills/CTAs `rounded-full`.
- **CTA anatomy**: pill button, `eyebrow` type at ~`text-[0.7rem]`, `px-8 py-4`, solid
  accent fill for primary / thin outline for secondary.

## 3. Section archetypes (the reusable layouts)

Fourteen sections but only **seven layouts**. Reuse these instead of inventing new ones.

### A. Immersive band (`hero`, `casa-club`, `aspiracional`, `cta-final`)
Full-bleed photo with a gradient scrim and a small copy block. The workhorse for emotion.

- `relative flex min-h-svh` (hero) or `min-h-[80svh]` (all others) `items-end|items-center overflow-hidden` on a dark bg.
- Photo: `absolute inset-0` + `object-cover`; scrim: `bg-gradient-to-t` from ~75–90%
  dark at the bottom to transparent/light at top, tuned per photo.
- Copy variants: hero = bottom-center; mid-page tease (`casa-club`) = bottom-left
  `max-w-xl` with a CTA to the *next* section; manifesto (`aspiracional`, `cta-final`) =
  dead-center `max-w-3xl`, headline + short paragraph + CTA(s) to `#contacto`.
- Text gets `drop-shadow` since it sits on photography. Subtle `grain` texture class.
- Hero extras: `<picture>` desktop/mobile crops, `fetchpriority="high"`, slow Ken Burns
  zoom on the photo, `reveal-group is-revealed` (visible without scroll).

### B. Split 50/50 (`proyecto`, `ubicacion`)
Text column + media column: `grid items-center gap-12 lg:grid-cols-2 lg:gap-16`.

- Text column: standard header block, then structured facts — `proyecto` uses a
  4-up stat `<dl>` (big number + tiny label) and a row of feature pills; `ubicacion`
  uses a 2-col icon checklist of drive times. End with one CTA.
- Media column: one `rounded-3xl` framed asset — photo (`aspect-[4/3]`) or embedded
  Google Map iframe.
- Same archetype works on light (`proyecto`) or dark (`ubicacion`) backgrounds.

### C. Framed embed (`video`)
Minimal: narrow container (`max-w-5xl`), one `aspect-video` iframe inside a
`rounded-3xl` dark frame with ring + shadow. No header — the video *is* the section.
Use `youtube-nocookie.com/embed/{id}?rel=0` + `loading="lazy"`.

### D. Product card grid (`modelos`)
Header block, then `grid gap-8 lg:grid-cols-2` (one column per model/typology).

Card anatomy, top to bottom: photo `aspect-[16/10]` with hover zoom
(`group-hover:scale-105`, ~1.2s ease-out — the standard hover everywhere) and a
floating name badge; padded body with name, **2-col checkmark spec list**, short
positioning paragraph, CTA to `#contacto`.

### E. Bento gallery (`interiores`, `exteriores`)
Header block, then `grid auto-rows-[220px] grid-cols-2 gap-4 lg:grid-cols-4` of image
buttons. First tile spans `lg:col-span-2 lg:row-span-2` (the anchor image), one later
tile spans `lg:col-span-2` for variety, the rest are 1×1. Tiles: hover zoom + gradient
+ caption fade-in. Each tile opens the shared **lightbox** (`partials/lightbox.blade.php`,
one Alpine `gallery([...])` component on the section: arrows, Esc, counter, captions).
Data lives in a `@php` array at the top of the partial — img/title/span — so a new
project only edits the array. Used twice on purpose: interiors and exteriors get
separate sections, not one mixed gallery.

### F. Horizontal slider + detail modal (`zona`)
For master-community amenities where each amenity has its own photo set.

- Header row: title block left, prev/next round arrow buttons right
  (`flex md:items-end md:justify-between`).
- Track: `flex snap-x snap-mandatory overflow-x-auto` with hidden scrollbar; cards
  `w-[70vw] sm:w-[320px] lg:w-[360px]` portrait `aspect-[3/4]` photo cards with
  bottom-gradient caption + photo-count badge.
- Click card → **bento modal** (header with title/description/tags + scrollable bento
  grid of that amenity's gallery) → click image → fullscreen viewer with arrows/counter.
  Three z-layers: slider < modal (`z-[95]`) < viewer (`z-[97]`).
- All content is one `@php` array (title, subtitle, desc, tags, image list) serialized
  to the Alpine component via `@js()`.

### G. Boxed banner (`brokers`)
A section *inside* a rounded dark box on a light section bg — reads as an aside, not a
main act. `rounded-3xl` box, `grid lg:grid-cols-2`: padded copy half (eyebrow →
headline → paragraph → CTA) + full-bleed photo half. Use for any secondary audience
(brokers, referrals, investment program).

### H. Narrow form (`asesoria` — the conversion point)
`max-w-xl` container, centered header, then the form in a **white `rounded-3xl` card**
elevated off a distinct soft bg (the only section on that bg — it must look different).

- Keep it to **3 fields**: name, email, phone. Everything else lowers conversion.
- Netlify Forms wiring: `name="…" method="POST" data-netlify="true"
  netlify-honeypot="bot-field" action="/gracias.html"` + hidden `form-name` input +
  hidden honeypot row. Static `gracias.html` thank-you page in `public/`.
- Button row: primary submit pill + secondary outline `tel:` call button
  (with `fbq('track','Contact')` on click).

## 4. Global chrome

- **Nav**: fixed, transparent over the hero → solid bg + blur + hairline shadow after
  ~40px scroll (Alpine `navSolid` on `@scroll.window`). Logo swaps light/dark variant
  with the state. Centered anchor links (4–5 max) + a pill CTA to `#contacto` on the
  right. Mobile: hamburger → full overlay, body scroll locked.
- **Footer**: dark. Logo + blurb, link columns, contact info, and one last CTA pill.
- **Floating WhatsApp button**: fixed bottom-right, `wa.me/{number}?text={prefill}`,
  Meta Pixel `Contact` tracking on click. This is real estate in MX — WhatsApp
  converts more than the form; never ship without it.
- **Anchors**: every section that appears in the nav has a stable `id`
  (`#proyecto`, `#modelos`, `#precios`, `#zona`, `#ubicacion`, `#contacto`).

## 5. Porting checklist for a new development

1. Copy the partials as skeletons; keep `home.blade.php` include order (drop sections
   that don't apply — e.g. no `zona` if it's not inside a master community; no
   `casa-club` if there's no signature amenity).
2. Re-skin tokens in `app.css` `@theme` (palette, `display`/`eyebrow` fonts) — the
   layout classes don't change.
3. Fill the `@php` data arrays: models + specs, amenities + galleries, interior/exterior
   image lists, drive-time list, stats.
4. Swap photos, keeping each archetype's aspect ratios (hero crops, `16/10` cards,
   `3/4` slider cards, `4/3` split media).
5. Update nav anchors, WhatsApp number/prefill, `tel:` link, Netlify form name,
   map query, video ID.
6. Verify the light/dark rhythm still alternates after any section removals.
7. `./build-static.sh` → `netlify deploy --prod --dir dist` (see also
   [docs/README.md](README.md) for the reusable JS components and shared conventions).
