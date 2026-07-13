import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import './preloader.js';
import './reveal.js';
import './ocean-bg.js';

Alpine.plugin(collapse);

/**
 * Global language store (ES / EN).
 * The active language is reflected as `data-lang` on <html>; CSS in app.css
 * shows the matching `.lang-es` / `.lang-en` spans. Persisted to localStorage.
 * An inline script in the <head> sets data-lang before paint to avoid a flash.
 */
document.addEventListener('alpine:init', () => {
    Alpine.store('lang', {
        current: document.documentElement.getAttribute('data-lang') || 'es',
        set(l) {
            this.current = l;
            document.documentElement.setAttribute('data-lang', l);
            try { localStorage.setItem('rdm_lang', l); } catch (e) {}
        },
        toggle() {
            this.set(this.current === 'es' ? 'en' : 'es');
        },
    });

    // Shared product selector (casas / depas) — links Residencias and Disponibilidad.
    Alpine.store('product', {
        tab: 'casas',
        set(t) { this.tab = t; },
    });
});

/**
 * Multi-step "Agendar visita" form.
 * Step 1: who you are (3 fields). Step 2: what interests you.
 * Template-only for now — submission just shows the success state.
 */
Alpine.data('visitForm', () => ({
    step: 1,
    sent: false,
    form: {
        nombre: '',
        email: '',
        telefono: '',
        interes: '',
        contacto: 'WhatsApp',
        mensaje: '',
    },
    get stepOneValid() {
        return (
            this.form.nombre.trim() !== '' &&
            /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(this.form.email) &&
            this.form.telefono.trim().length >= 7
        );
    },
    next() {
        if (this.stepOneValid) this.step = 2;
    },
    back() {
        this.step = 1;
    },
    submit() {
        // TODO: wire to backend (Mailgun / CRM) once sales contact is defined.
        this.sent = true;
    },
}));

/**
 * Slideshow gallery lightbox. Pass the image list: gallery([{src, t}, ...]).
 * show(index) opens at that image; next()/prev() cycle through all of them.
 */
Alpine.data('gallery', (imgs = []) => ({
    open: false,
    i: 0,
    imgs,
    show(idx) {
        this.i = idx;
        this.open = true;
    },
    next() {
        this.i = (this.i + 1) % this.imgs.length;
    },
    prev() {
        this.i = (this.i - 1 + this.imgs.length) % this.imgs.length;
    },
}));

/**
 * Count-up number. Animates from 0 to `target` (easeOutCubic) the first time
 * the element scrolls into view. Respects prefers-reduced-motion.
 * Usage: <span x-data="countUp(6.7)" x-text="display">6.7</span>
 */
Alpine.data('countUp', (target, decimals = 1, duration = 1500) => ({
    display: (0).toFixed(decimals),
    init() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.display = target.toFixed(decimals);
            return;
        }
        const obs = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    this.run();
                    obs.disconnect();
                }
            });
        }, { threshold: 0.5 });
        obs.observe(this.$el);
    },
    run() {
        const start = performance.now();
        const ease = (t) => 1 - Math.pow(1 - t, 3);
        const tick = (now) => {
            const p = Math.min(1, (now - start) / duration);
            this.display = (target * ease(p)).toFixed(decimals);
            if (p < 1) requestAnimationFrame(tick);
            else this.display = target.toFixed(decimals);
        };
        requestAnimationFrame(tick);
    },
}));

/**
 * Amenities slider + bento modal. Pass the amenity list:
 * amenities([{ t, sub, desc, tags, cover, gallery: [...] }, ...]).
 * Cards nudge the track; clicking one opens a bento gallery modal, and
 * clicking a bento tile opens a fullscreen image viewer with arrows.
 */
Alpine.data('amenities', (items = []) => ({
    items,
    open: false,
    active: null,
    viewer: false,
    vi: 0,
    show(idx) {
        this.active = this.items[idx];
        this.open = true;
        document.documentElement.classList.add('overflow-hidden');
    },
    close() {
        this.open = false;
        this.viewer = false;
        document.documentElement.classList.remove('overflow-hidden');
    },
    nudge(dir) {
        const t = this.$refs.track;
        const c = t.querySelector('[data-card]');
        const amt = c ? c.offsetWidth + 24 : 360;
        t.scrollBy({ left: dir * amt, behavior: 'smooth' });
    },
    // Bento tile span pattern (desktop 4-col): a big lead tile, then rhythm.
    span(i) {
        const p = i % 6;
        if (p === 0) return 'sm:col-span-2 sm:row-span-2';
        if (p === 3) return 'sm:col-span-2';
        return '';
    },
    lightbox(i) {
        this.vi = i;
        this.viewer = true;
    },
    viewNext() {
        const n = this.active?.gallery.length || 1;
        this.vi = (this.vi + 1) % n;
    },
    viewPrev() {
        const n = this.active?.gallery.length || 1;
        this.vi = (this.vi - 1 + n) % n;
    },
}));

window.Alpine = Alpine;
Alpine.start();
