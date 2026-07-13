# Driftrow

A full-bleed gallery of two horizontal image rows that scroll **in opposite directions**,
loop forever and seamlessly, pause when you hover anywhere over them, and open any image
in a click-to-enlarge lightbox. Inspired by the marquee on cande.mx. The motion is pure
CSS; only the lightbox needs JS (Alpine).

## Where it lives

- **`partials/galeria.blade.php`** — markup, the two rows, and the Alpine lightbox.
- **`.marquee*` CSS** in `resources/css/app.css` (the "Dual-row horizontal marquee gallery" block).

## How it works

### The seamless loop (the important part)

Each track contains **two identical copies** of the image list. The animation translates
the track by exactly `-50%`:

```css
@keyframes marquee-rtl { from { transform: translateX(0); }   to { transform: translateX(-50%); } }
@keyframes marquee-ltr { from { transform: translateX(-50%); } to { transform: translateX(0); } }
```

Because the track is two identical halves, when it has scrolled `-50%` the second copy
sits exactly where the first started — so the jump back to `0%` is invisible.

**The subtle bit:** for `-50%` to land perfectly on the seam, the spacing must be uniform
*including* between the last image of copy 1 and the first of copy 2. We achieve that by
putting the gap on each **image** (`mr-5`, a right margin) rather than using flex `gap`.
With flex `gap`, there's no gap at the very end of a copy, so `-50%` would be off by one
gap-width and you'd see a stutter. Per-image margin keeps every interval identical.

### Opposite directions + pause

- Row 1 uses `.marquee-track--rtl` (right-to-left), Row 2 uses `.marquee-track--ltr` (left-to-right). Different durations (`70s` / `85s`) so they never visually sync up.
- Both rows live inside one `.marquee-stage`. `.marquee-stage:hover .marquee-track { animation-play-state: paused; }` freezes **both** on hover.
- `.marquee` has a CSS mask (`linear-gradient(to right, transparent, #000 6%, #000 94%, transparent)`) for the soft edge fade.

### Lightbox

The `<section>` holds Alpine state: `{ lbOpen, lbSrc, lbAlt, open(s,a) }`. Each image is a
`<button>` that calls `open(...)`. The overlay is a `fixed inset-0 z-[60]` panel shown with
`x-show` + `x-transition`, closed by Esc (`@keydown.escape.window`) or click-outside.

### Accessibility / perf

- The duplicated (second) copy is `aria-hidden="true"` and its buttons are `tabindex="-1"` so screen readers and keyboard tab order only see each image once.
- Images are `loading="lazy"`.
- Under `prefers-reduced-motion`, the animation is removed and `.marquee` becomes a normal horizontal scroll container.

## How to reuse

**1. Dependency:** `alpinejs` (already in the stack; only needed for the lightbox — drop the lightbox and it's zero-JS).

**2. Copy the CSS block** ("Dual-row horizontal marquee gallery") from `app.css`.

**3. Copy `partials/galeria.blade.php`** and edit the two `$row*` arrays at the top:

```php
$rowCasas = [
    ['img' => 'cande-exterior.png', 'alt' => 'Fachada de casa Candé'],
    // ...
];
$rowComunidad = [ /* ... */ ];
```

**4. Include it** where you want it: `@include('partials.galeria')`.

The core markup pattern (repeat per row, with the copy loop for seamlessness):

```blade
<div class="marquee">
    <div class="marquee-track marquee-track--rtl">  {{-- or --ltr for the opposite row --}}
        @foreach (range(1, 2) as $copy)
            <div class="flex" @if ($copy === 2) aria-hidden="true" @endif>
                @foreach ($row as $item)
                    <button @click="open('{{ asset('images/'.$item['img']) }}', '{{ $item['alt'] }}')"
                            class="group mr-5 block shrink-0 overflow-hidden rounded-2xl"
                            tabindex="{{ $copy === 2 ? '-1' : '0' }}">
                        <img src="{{ asset('images/'.$item['img']) }}"
                             alt="{{ $copy === 1 ? $item['alt'] : '' }}" loading="lazy"
                             class="h-64 w-auto max-w-none object-cover transition-transform duration-700 group-hover:scale-105 lg:h-80">
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
```

## Knobs to tune

| What | Where |
|------|-------|
| **Scroll speed** | `animation: marquee-rtl 70s ...` / `... 85s ...` in CSS. Bigger = slower. |
| **Direction** | Swap `--rtl` / `--ltr` classes per row. |
| **Image height** | `h-64 ... lg:h-80` on the `<img>`. |
| **Gap between images** | `mr-5` on the `<button>` (keep it consistent — it's load-bearing for the seam). |
| **Edge fade width** | the `6%` / `94%` stops in the `.marquee` mask. |
| **Hover zoom** | `group-hover:scale-105` on the `<img>`. |

## Gotchas

- **Always duplicate the list and use per-image margin, not flex `gap`** — otherwise the loop stutters at the seam. This is the #1 thing to get right.
- Both rows must be inside the same `.marquee-stage` for the unified hover-pause.
- Mixed image aspect ratios are fine and look editorial; a fixed height + `w-auto` handles it.
- Don't put more than ~8–10 images per row, or the loop gets very long and the file heavy.
