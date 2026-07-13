/**
 * Real del Mar — scroll-triggered reveal animations.
 *
 * Adds `is-revealed` to any `.reveal` or `.reveal-group` element once it
 * crosses the bottom 12% of the viewport. CSS handles the transitions
 * (see app.css). `.reveal-group` staggers its direct children.
 */

function setupReveal() {
    const targets = document.querySelectorAll('.reveal, .reveal-group');

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        targets.forEach((el) => el.classList.add('is-revealed'));
        return;
    }

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-revealed');
                io.unobserve(entry.target);
            });
        },
        { rootMargin: '0px 0px -12% 0px', threshold: 0.01 },
    );

    targets.forEach((el) => io.observe(el));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupReveal);
} else {
    setupReveal();
}
