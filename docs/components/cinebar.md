# Cinebar

A full-bleed horizontal banner with a looping background video and a single centered
headline over a darkening overlay. A cinematic "beat" between content sections. Inspired
by the CTA banner on cande.mx.

## Where it lives

- **`partials/cta-video.blade.php`** — the whole component, no JS and no extra CSS (just Tailwind utilities + the shared `.display` / `.eyebrow` / `.reveal-group` classes).
- **Assets**: `public/videos/<clip>.mp4` and `public/images/<clip>-poster.jpg`.

## How it works

- A native `<video>` set to `autoplay loop muted playsinline` with `object-cover` fills the band at any width. **`muted` is required** for autoplay to work in modern browsers; **`playsinline`** stops iOS from forcing fullscreen.
- A `poster` image shows instantly while the video buffers — and stays as the frame on any device/policy that blocks autoplay, so the section never looks empty.
- A `bg-ocean-950/40` overlay sits between the video and the text for legibility.
- The headline uses `.display` (serif, with an italic `em` accent) and fades up via `.reveal-group`.
- Band height is `70vh` with a `min-h-[28rem]` floor so it never collapses on short viewports.

## How to reuse

**No dependencies.** Pure markup.

**1. Add the assets** to the new project:
- Video → `public/videos/<name>.mp4`
- A poster frame → `public/images/<name>-poster.jpg` (grab frame 0 of the clip)

> Tip: host the video **locally** rather than hot-linking a CDN, so the template is
> self-contained. To download one from another site:
> `curl -sL "<url>" -o public/videos/<name>.mp4`

**2. Copy `partials/cta-video.blade.php`** and point it at your asset + headline:

```blade
<section class="relative h-[70vh] min-h-[28rem] w-full overflow-hidden bg-ocean-950">
    <video class="absolute inset-0 h-full w-full object-cover"
           autoplay loop muted playsinline
           poster="{{ asset('images/<name>-poster.jpg') }}">
        <source src="{{ asset('videos/<name>.mp4') }}" type="video/mp4">
    </video>

    <div class="absolute inset-0 bg-ocean-950/40"></div>

    <div class="relative flex h-full items-center justify-center px-6 text-center">
        <div class="reveal-group">
            <p class="eyebrow text-sand-200/90">Eyebrow</p>
            <h2 class="display mt-5 text-4xl font-light text-sand-50 sm:text-6xl lg:text-7xl">
                Your headline<br><em>with an accent</em>
            </h2>
        </div>
    </div>
</section>
```

**3. Include it**: `@include('partials.cta-video')`.

## Knobs to tune

| What | Where |
|------|-------|
| **Height** | `h-[70vh]` (use `h-screen` for full-bleed drama, or smaller for a tighter band). |
| **Overlay darkness** | `bg-ocean-950/40` — raise the `/40` for more text contrast over a bright video. |
| **Headline** | the `<h2>` text; `<em>` gets the italic serif accent. |
| **Add a CTA** | drop a button under the `<h2>` inside `.reveal-group`. |

## Gotchas

- **`muted` + `playsinline` are mandatory** for reliable autoplay (especially iOS/Safari). Without `muted`, the browser blocks autoplay and you'll only see the poster.
- Keep the clip **short and compressed** (the Candé clip is ~5 MB). Big videos hurt LCP. For a content-heavy page, consider serving a smaller/poster-only version on mobile.
- Provide a real poster frame — it's both the loading state and the no-autoplay fallback.
- `object-cover` crops the video; make sure the subject stays roughly centered across aspect ratios.
