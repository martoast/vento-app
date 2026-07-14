# New Landing Page — Process Playbook

How to spin up a **new real-estate landing page** from this template family, end to end:
clone → rebrand → QA → deploy → repo + CI. This is the *process* doc; the *structure*
doc (section order, layout archetypes, spacing constants) is
[landing-page-structure.md](landing-page-structure.md) — read both before starting.

Proven on: **Riviera Residencial** (original) → **Costa Real** (2026-07-12, ~1 session)
→ **Vento** (2026-07-13, ~1 session).

## The family

One page = one Laravel Blade + Tailwind v4 + Alpine.js app = one GitHub repo = one
Netlify site (team **Fullstack Bolt**, slug `ricardo-ochoa-tovar`). Push to `main`
auto-deploys via GitHub Actions in ~1.5 min.

| Project | Path | Repo | Netlify site | Skin |
|---|---|---|---|---|
| Riviera Residencial | `~/Documents/ricardo/riviera-residencial/app` | `martoast/riviera-residencial-app` | rivieraresidencial | ocean/gold/sand (RDM) |
| Costa Real | `~/Documents/ricardo/costa-real/app` | `martoast/costa-real-app` | costa-real-rdm | ocean/gold/sand (RDM) |
| Vento | `~/Documents/ricardo/vento/app` | `martoast/vento-app` | vento-tijuana | olive/wood/sand (own brand) |

## Step 0 — Inputs from the client (checklist)

Collect before starting; anything missing becomes a **TODO comment in code + an entry
in `tasks/todo.md`**. Never invent facts, prices, drive times, or contact data.

- [ ] Image/render folder (usually `~/Downloads/boltmedia_<project>/`), hero image marked
- [ ] Content doc (txt/pdf). **Use it for facts and copy only** — if it references some
      other site's structure, ignore that; the Riviera blueprint is the structure
- [ ] Contact: phone, WhatsApp, email, Instagram (Vento launched with Instagram only —
      call/WA buttons stay disabled behind a `$waNumber = null` config until numbers arrive)
- [ ] Logo files (all launches so far used a **text wordmark** in `partials/logo.blade.php`
      until real assets arrive)
- [ ] Prices (else show "Consultar"), Aviso de Privacidad doc, Meta Pixel / GTM ID
- [ ] Who commercializes/develops it (brands for the respaldo section + schema.org)

## Step 1 — Clone the template

Clone from the **newest sibling** (it carries the latest fixes: `?nopreload` preloader
escape, responsive nav, CI workflow). Riviera is the canonical structure reference.

```bash
mkdir -p ~/Documents/<owner>/<project>
rsync -a --exclude .git --exclude node_modules --exclude dist \
      --exclude .netlify --exclude vendor \
      ~/Documents/ricardo/vento/app/ ~/Documents/<owner>/<project>/app/
cd ~/Documents/<owner>/<project>/app
composer install && npm install
cp .env .env.bak && php artisan key:generate --force && rm .env.bak
```

Then look at every source image before assigning it (make a labeled contact sheet):

```bash
magick montage -label '%f' thumbs/*.jpg -tile 3x -geometry 380x+8+8 sheet.jpg
```

## Step 2 — Retheme (only if the brand differs)

Costa Real kept the Real del Mar skin (same master development). Vento got its own.
The class *vocabulary* is shared — you swap the token values and, if the semantic
names would lie, rename the family with a global replace:

1. Edit the `@theme` block in `resources/css/app.css` — one scale for backgrounds
   (`sand-*`), one dark family for bands/footer, one warm accent for CTAs/eyebrows,
   `ink`/`ink-soft` for text. Keep Baskerville (`.display`) + Titling Gothic.
2. If renaming families (Vento did `ocean-* → olive-*`, `gold-* → wood-*`):
   replace across `resources/views/**/*.blade.php` AND fix `var(--color-…)`
   references in `app.css` (html overscroll bg, `::selection`, plan/lot fills).
   Grep for leftovers until zero: `grep -rn 'ocean-\|gold-' resources/`
3. Update `<meta name="theme-color">` and `gracias.html` colors to the new dark tone.

## Step 3 — Images

Process into `public/images/` with descriptive kebab names (`<project>-<subject>.jpg`):

```bash
magick "$SRC/render.jpg" -resize 2400x -quality 80 <project>-fachada.jpg   # exteriors
magick "$SRC/int.jpg"    -resize 2000x -quality 80 <project>-sala.jpg      # interiors
magick "$SRC/plan.jpg"   -resize 2200x -quality 85 <project>-plano-a01.jpg # floor plans (text!)
```

- **Hero**: desktop + mobile variants via `<picture>`. OG image = **the hero render**,
  1200×630 center crop (`-resize 1200x` or `-resize x630`, whichever fills, then
  `-gravity center -crop 1200x630+0+0 +repage`). WhatsApp caches previews ~1 day.
- **Detail crops** from big renders are legit amenity-card material (Vento's
  estacionamiento/acceso/portones cards are crops of the hero + facade renders).
- **Missing amenity photos**: generate with the `/gen-image` skill, prompt-matched to
  the render style ("photorealistic architectural render… beige plaster, matte black
  steel, warm dusk light, olive and sand palette, no text, no watermarks"), vertical
  composition for the 3:4 slider cards. Flag as AI-generated in `tasks/todo.md`.
- **Favicon**: crop the brand emblem out of a render if one exists (Vento's gold sun),
  else hand-draw a monogram SVG → `favicon.ico` 48px + `icon-512.png` + `apple-touch-icon.png` 180px.
- Delete every previous project's images from `public/images/` — then grep the rendered
  page for the old brand names to prove zero leftovers.

## Step 4 — Content mapping (the 14 slots)

Apply the blueprint **literally** — copy each archetype's layout, swap only content
(see landing-page-structure.md). Adaptations that worked:

| Blueprint slot | Costa Real (terrenos) | Vento (deptos) |
|---|---|---|
| casa-club immersive band | "Primera fase" lot-lines photo | Roof deck |
| modelos card grid | 1 centered product card | 3 tipología cards + plan lightbox |
| precios dark band | 6 financing stat cards | 2 unit cards, "Precio: Consultar" |
| zona slider | RDM amenities (reused) | Building amenities (crops + gen-image) |
| brokers boxed banner | respaldo (Grupo Frisa) | respaldo (logos strip) **and** brokers |

Mechanics:
- **The video section is mandatory** (slot 3, framed embed after proyecto). If the
  project has no video yet, embed the shared Real del Mar video
  (`youtube-nocookie.com/embed/2RTL8rdvZIY`) as a placeholder + TODO in tasks/todo.md.
  Headless-QA note: YouTube embeds show "Video no disponible" in headless Chrome —
  that's an artifact, verify in a real browser or trust the live siblings.
- Editable business data (tipologías, estados Disponible/Apartado/Vendido, specs,
  amenidades) lives in `@php` arrays at the top of each partial — never inline in markup.
- Floor plans open in the existing `gallery()` Alpine lightbox — wrap the section in
  `x-data="gallery(@js($planos))"`, buttons call `show(idx)`. Don't send a
  "Ver distribución" button to the form.
- Give every conversion CTA an id (`cta-nav`, `cta-enviar`, `cta-brokers`, `cta-mapa`,
  `plano-*`) so GTM can hook them later without markup changes.
- Bento galleries: tile spans must sum to a multiple of 4 per breakpoint
  (anchor 2×2 = 4, `col-span-2` = 2, single = 1). 8 tiles = 4+2+6×1 = 12 ✓.
- Form: keep Netlify Forms (`name="asesoria"`, honeypot, `action="/gracias.html"`,
  hidden `form-name` input). Consent checkbox if the brief requires it.
- Nav: 4 links max + CTA. Keep `whitespace-nowrap`, `gap-5 xl:gap-10`, and the
  responsive CTA label (`<span class="hidden xl:inline">Long</span><span class="xl:hidden">Contacto</span>`)
  — this is what survives 1024 *and* 1440 without collisions.

### Contrast rule (learned the hard way, twice)

Over **photos**, labels/eyebrows must be `text-sand-50` (white) **with a drop-shadow**
— the warm accent color (gold/wood-300) disappears into warm renders. The accent
color is only for eyebrows on **solid dark** backgrounds. If body copy sits over a
bright image area, add a side scrim (`bg-gradient-to-r from-<dark>-950/65 …`) in
addition to the bottom one. Verify with screenshots, don't assume.

## Step 5 — Layout, SEO, meta files

In `layouts/app.blade.php`:
- Title/description/keywords, OG + Twitter tags (og:image absolute via `$siteUrl`),
  schema.org JSON-LD (`ResidentialComplex` for land, `ApartmentComplex` for buildings —
  only include phone/email if real).
- navLinks array, footer (address, brands line, quick links, contact, legal leyenda),
  floating action buttons, and the **footer version stamp `· v1.0.0`** — bump it on
  every deploy; it's how you verify what's live.
- Remove/replace the previous client's Meta Pixel. Never ship someone else's pixel ID.

Also: `public/gracias.html` (rebrand mark + colors), `robots.txt` + `sitemap.xml`
(new domain), `build-static.sh` `SITE_URL` default, `.env`/`.env.example` `APP_NAME`,
rewrite `tasks/summary.md` + `tasks/todo.md`.

## Step 6 — QA with the gstack browse daemon

`?nopreload` skips the preloader splash (see `resources/js/preloader.js`).

```bash
php artisan serve --port=8124 &
B=~/.claude/skills/gstack/browse/dist/browse
$B viewport 1440x900 && $B goto 'http://127.0.0.1:8124/?nopreload'
$B console --errors && $B network            # must be clean
# per-section shots: scrollIntoView each id, screenshot --viewport, montage, LOOK at them
$B js "document.getElementById('tipologias').scrollIntoView({behavior:'instant'})"
$B screenshot --viewport /tmp/qa/d-tipologias.png
```

Minimum pass list:
- [ ] Every section, desktop 1440 **and** mobile 390 (sections without ids: reach via
      `nextElementSibling` / last `main > section` / `scrollHeight`)
- [ ] Nav at 1024 and 1440 (the two collision widths)
- [ ] Hamburger menu open, plan lightbox, amenity modal, slider arrows, gallery lightbox
- [ ] Zero console errors; broken-image count via
      `[...document.images].filter(i=>!i.complete||i.naturalWidth===0)` — one empty-src
      hit from the closed Alpine lightbox `<img>` is normal; lazy images below the fold
      report "broken" until scrolled near
- [ ] Overlay text contrast on every photo band (see contrast rule)

## Step 7 — Build + first deploy

```bash
./build-static.sh          # aborts if the homepage isn't HTTP 200 — NEVER bypass this
# output goes to ../dist; verifies "leftover host refs: 0" itself
netlify api createSite --data '{"account_slug":"ricardo-ochoa-tovar","body":{"name":"<site-name>"}}'
# if the name is ignored (random baklava name): netlify api updateSite --data '{"site_id":"…","body":{"name":"…"}}'
netlify link --id <site_id>
netlify deploy --prod --dir ../dist --message "Initial launch v1.0.0"
```

Verify: `/`, `/gracias.html`, `/images/og-<project>.jpg`, `/favicon.ico`, `/robots.txt`
all 200; version stamp present; then load the live URL in browse once.

## Step 8 — Repo + CI

The clone already contains `.github/workflows/deploy.yml` (PHP 8.4 + Node 22 →
`OUT=dist ./build-static.sh` → netlify-cli deploy).

```bash
git init -b main && git add -A && git commit -m "…"
gh repo create martoast/<project>-app --public --source . --push
gh secret set NETLIFY_AUTH_TOKEN --repo martoast/<project>-app --body "$TOKEN"
gh secret set NETLIFY_SITE_ID   --repo martoast/<project>-app --body "<site_id>"
# token: python3 -c "import json;d=json.load(open('$HOME/Library/Preferences/netlify/config.json'));print(d['users'][d['userId']]['auth']['token'])"
gh api -X PUT repos/martoast/<project>-app/collaborators/<user> -f permission=push
```

Permission notes (Claude Code): creating a **public** repo and writing **secrets**
both need Alex to explicitly approve, per repo, in the session — plan for that prompt.
Trade-off already accepted: write collaborators could read the Netlify token by
editing the workflow.

Then prove the pipeline: bump the footer stamp to v1.0.1, push, `gh run watch`,
`curl` the live site for the new stamp. **Done = the version you pushed is live.**

Gotchas: `gh repo create --push` on an old default branch pushes `master` — init with
`-b main`. A visibility flip can lock the repo for ~seconds (collaborator invite 403s
— retry). The first Actions run fails if it raced the secrets — expected.

## Step 9 — Close out

- Update Claude's memory (`~/.claude/projects/.../memory/`): new `<project>-project.md`
  + `MEMORY.md` index line — status, site id, repo, pending client data.
- Report to Alex: live URL, repo, CI proof (version stamp), and the explicit list of
  what's blocked on the client.
