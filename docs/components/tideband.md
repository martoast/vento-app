# Tideband

A full-bleed, animated WebGL ocean surface used as the background of a dark section
(on Real del Mar it's the **Ubicación** band). Layered simplex-noise fractal motion
reads as a slow Pacific swell at dusk, with foam glints on the wave crests and a warm
"sun path" that pools toward the cursor. Falls back to a static CSS gradient when WebGL
is unavailable or the user prefers reduced motion.

> Sibling of Bolt's `hero-bg.js` (smoke shader). Same architecture, different palette and
> noise tuning. If you've seen one, you understand the other.

## Where it lives

- **`resources/js/ocean-bg.js`** — the whole component (shader + Three.js plumbing + auto-mount).
- **Host markup**: any element with `data-ocean-bg` inside a section that already has a gradient background (the gradient is the fallback; the canvas paints over it).

## How it works

1. **Auto-mount.** On `DOMContentLoaded` the module finds every `[data-ocean-bg]` element and calls `mountOceanBg(el)`. Each returns a `destroy()` cleanup fn.
2. **Reduced motion / no WebGL.** If `prefers-reduced-motion: reduce`, it bails immediately and the section's CSS gradient remains. (WebGL context failure also just leaves the gradient.)
3. **Full-screen shader.** A single `OrthographicCamera` + a `PlaneGeometry(2,2)` fills clip space. All the work is in the fragment shader.
4. **The shader.**
   - Ashima 3D simplex noise (public domain) → `fbm()` (5 octaves) for organic layered motion.
   - Coordinates are stretched horizontally (`p.y * 2.2`) so the noise reads as water seen at a low angle, not smoke.
   - Two noise fields (slow wide *swell* + faster *chop*) are mixed, then `smoothstep`-ed.
   - Palette ramps from `abyss` → `deep` → `swellBlue`; wave **crests** (`smoothstep(0.78, 0.97, n)`) get a touch of `foam`.
   - A mouse "sun" (`exp(-mouseDist * 2.2)`) mixes in warm `sunGold` near the cursor.
   - Vignette + hashed grain finish it.
5. **Mouse smoothing.** Pointer position and intensity are lerped each frame (`u_mouse`, `u_mouse_intensity`) so the sun glides instead of snapping. Intensity fades to 0 on `pointerleave`.
6. **Performance.**
   - Renders at **60% resolution** (`setPixelRatio(dpr * 0.6)`) then upscales — invisible on water.
   - **IntersectionObserver** pauses the render loop when the band scrolls off-screen.
   - `antialias: false`, `powerPreference: 'high-performance'`.
   - Canvas fades in (`opacity 0 → 1`) once the first frame renders.

## How to reuse

**1. Dependency:** `npm i three`

**2. Copy** `resources/js/ocean-bg.js` into the new project's `resources/js/`.

**3. Import it** in `app.js` (it self-boots, no manual call needed):

```js
import './ocean-bg.js';
```

**4. Add the host** inside any dark section. Give the section a gradient (the fallback)
and drop a `data-ocean-bg` layer over it:

```blade
<section class="relative overflow-hidden bg-gradient-to-b from-ocean-950 via-ocean-900 to-ocean-950 py-28">
    <div data-ocean-bg class="absolute inset-0"></div>

    <div class="relative mx-auto max-w-7xl px-6">
        {{-- your headline / content here, on top of the water --}}
    </div>
</section>
```

The host element must be **positioned** (it is, via `absolute inset-0`) and the content
above it needs `relative` so it stacks over the canvas.

## Knobs to tune

All in `ocean-bg.js`:

| What | Where | Notes |
|------|-------|-------|
| **Palette** | `abyss / deep / swellBlue / foam / sunGold` vec3s in the fragment shader | Use linear-ish RGB (0–1). For a different water mood (Caribbean, night) re-pick these. |
| **Swell speed** | `float t = u_time * 0.045;` | Higher = faster water. |
| **Wave scale / chop** | `stretched * 1.1` (swell), `* 3.4` (chop) | Bigger numbers = smaller, busier waves. |
| **Sun warmth/reach** | `sun = ... exp(-mouseDist * 2.2) * 0.8` | Lower the `2.2` for a wider glow. |
| **Render scale** | `const scale = 0.6` | Drop to 0.5 on heavy scenes; raise toward 1 for crisper crests. |
| **Default sun position** | `new THREE.Vector2(0.5, 0.35)` | Where the glow sits before the mouse moves. |

## Gotchas

- It paints **over** whatever background the host has — always set a gradient fallback so reduced-motion users and WebGL failures still see something on-brand.
- One scene per page is the budget. Don't mount several Tidebands at once.
- The shader assumes a wide, short band. For a tall hero it still works but the horizontal stretch may need lowering.
