/**
 * Real del Mar — first-load preloader.
 * ------------------------------------
 * Shows a splash (logo + progress bar) while every image and video on the
 * page is fetched, then fades the splash out to reveal a fully-loaded site.
 *
 * Robustness: each asset resolves on load OR error OR a per-asset timeout,
 * and a hard cap guarantees the splash always clears. The scroll lock is
 * released on finish, on window load, and by a safety timer in the <head>.
 */
function runPreloader() {
    const el = document.getElementById('preloader');
    if (!el) {
        document.documentElement.classList.remove('is-loading');
        return;
    }

    // Dev escape hatch: ?nopreload skips the splash (headless screenshots, quick checks).
    if (new URLSearchParams(location.search).has('nopreload')) {
        el.remove();
        document.documentElement.classList.remove('is-loading');
        return;
    }

    const bar = document.getElementById('preloader-bar');
    const pctEl = document.getElementById('preloader-pct');

    const MIN_VISIBLE = 700;   // keep the splash for at least this long (ms)
    const HARD_CAP = 12000;    // never block longer than this (ms)
    const VIDEO_CAP = 8000;    // don't wait forever on a single video (ms)
    const startedAt = performance.now();

    // ---- Collect unique assets from the DOM ----
    const images = new Set();
    document.querySelectorAll('img[src]').forEach((i) => i.src && images.add(i.src));
    document.querySelectorAll('video[poster]').forEach((v) => v.poster && images.add(v.poster));

    const videos = new Set();
    document.querySelectorAll('video source[src]').forEach((s) => s.src && videos.add(s.src));

    const total = Math.max(1, images.size + videos.size);
    let done = 0;
    let finished = false;

    const bump = () => {
        done += 1;
        const pct = Math.min(100, Math.round((done / total) * 100));
        if (bar) bar.style.width = pct + '%';
        if (pctEl) pctEl.textContent = pct + '%';
        if (done >= total) finish();
    };

    // ---- Preload images (forces fetch even for lazy ones; shares cache) ----
    images.forEach((src) => {
        const img = new Image();
        img.onload = bump;
        img.onerror = bump;
        img.src = src;
        if (img.complete) bump.call(null); // already cached
    });

    // ---- Preload videos — resolve on first frame, error, or timeout ----
    videos.forEach((src) => {
        const v = document.createElement('video');
        v.muted = true;
        v.preload = 'auto';
        let settled = false;
        const ok = () => {
            if (settled) return;
            settled = true;
            bump();
        };
        v.addEventListener('loadeddata', ok, { once: true });
        v.addEventListener('canplaythrough', ok, { once: true });
        v.addEventListener('error', ok, { once: true });
        setTimeout(ok, VIDEO_CAP);
        v.src = src;
    });

    // ---- Reveal the site ----
    function finish() {
        if (finished) return;
        finished = true;
        if (bar) bar.style.width = '100%';
        if (pctEl) pctEl.textContent = '100%';

        const elapsed = performance.now() - startedAt;
        const hold = Math.max(0, MIN_VISIBLE - elapsed) + 250;

        setTimeout(() => {
            document.documentElement.classList.remove('is-loading');
            el.classList.add('is-done');
            el.addEventListener('transitionend', () => el.remove(), { once: true });
            setTimeout(() => el.remove(), 900); // backstop if transitionend misses
        }, hold);
    }

    setTimeout(finish, HARD_CAP);
    window.addEventListener('load', () => setTimeout(finish, 400));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runPreloader);
} else {
    runPreloader();
}
