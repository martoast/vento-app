/**
 * Real del Mar — WebGL Pacific Ocean Band
 * ----------------------------------------
 * Full-bleed fragment shader rendered on a Three.js plane, used as the
 * background of the dark "Ubicación / CTA" band.
 *
 *  - Base layer: layered simplex fBm noise read as slow ocean swell
 *    seen from above at dusk — deep Pacific blues with foam glints.
 *  - Mouse interaction: cursor acts as a low warm sun. The water
 *    brightens toward it like a sun path on the surface.
 *  - Performance: half-resolution render, IntersectionObserver pause,
 *    prefers-reduced-motion fallback (static CSS gradient remains).
 */

import * as THREE from 'three';

const VERTEX_SHADER = /* glsl */ `
    varying vec2 v_uv;
    void main() {
        v_uv = uv;
        gl_Position = vec4(position, 1.0);
    }
`;

const FRAGMENT_SHADER = /* glsl */ `
    precision highp float;

    uniform float u_time;
    uniform vec2  u_resolution;
    uniform vec2  u_mouse;            // smoothed, normalized 0..1
    uniform float u_mouse_intensity;  // 0..1, fades on idle

    varying vec2 v_uv;

    /* ----------  Ashima simplex noise (3D)  ----------
       Public-domain implementation by Ian McEwan & Stefan Gustavson. */
    vec3  mod289(vec3 x)  { return x - floor(x * (1.0 / 289.0)) * 289.0; }
    vec4  mod289(vec4 x)  { return x - floor(x * (1.0 / 289.0)) * 289.0; }
    vec4  permute(vec4 x) { return mod289(((x * 34.0) + 1.0) * x); }
    vec4  taylorInvSqrt(vec4 r) { return 1.79284291400159 - 0.85373472095314 * r; }

    float snoise(vec3 v) {
        const vec2  C = vec2(1.0 / 6.0, 1.0 / 3.0);
        const vec4  D = vec4(0.0, 0.5, 1.0, 2.0);

        vec3 i  = floor(v + dot(v, C.yyy));
        vec3 x0 = v - i + dot(i, C.xxx);

        vec3 g = step(x0.yzx, x0.xyz);
        vec3 l = 1.0 - g;
        vec3 i1 = min(g.xyz, l.zxy);
        vec3 i2 = max(g.xyz, l.zxy);

        vec3 x1 = x0 - i1 + C.xxx;
        vec3 x2 = x0 - i2 + C.yyy;
        vec3 x3 = x0 - D.yyy;

        i = mod289(i);
        vec4 p = permute(permute(permute(
                     i.z + vec4(0.0, i1.z, i2.z, 1.0))
                   + i.y + vec4(0.0, i1.y, i2.y, 1.0))
                   + i.x + vec4(0.0, i1.x, i2.x, 1.0));

        float n_ = 0.142857142857;
        vec3  ns = n_ * D.wyz - D.xzx;

        vec4 j = p - 49.0 * floor(p * ns.z * ns.z);

        vec4 x_ = floor(j * ns.z);
        vec4 y_ = floor(j - 7.0 * x_);

        vec4 x = x_ * ns.x + ns.yyyy;
        vec4 y = y_ * ns.x + ns.yyyy;
        vec4 h = 1.0 - abs(x) - abs(y);

        vec4 b0 = vec4(x.xy, y.xy);
        vec4 b1 = vec4(x.zw, y.zw);

        vec4 s0 = floor(b0) * 2.0 + 1.0;
        vec4 s1 = floor(b1) * 2.0 + 1.0;
        vec4 sh = -step(h, vec4(0.0));

        vec4 a0 = b0.xzyw + s0.xzyw * sh.xxyy;
        vec4 a1 = b1.xzyw + s1.xzyw * sh.zzww;

        vec3 p0 = vec3(a0.xy, h.x);
        vec3 p1 = vec3(a0.zw, h.y);
        vec3 p2 = vec3(a1.xy, h.z);
        vec3 p3 = vec3(a1.zw, h.w);

        vec4 norm = taylorInvSqrt(vec4(dot(p0, p0), dot(p1, p1),
                                       dot(p2, p2), dot(p3, p3)));
        p0 *= norm.x; p1 *= norm.y; p2 *= norm.z; p3 *= norm.w;

        vec4 m = max(0.6 - vec4(dot(x0, x0), dot(x1, x1),
                                dot(x2, x2), dot(x3, x3)), 0.0);
        m = m * m;
        return 42.0 * dot(m * m, vec4(dot(p0, x0), dot(p1, x1),
                                      dot(p2, x2), dot(p3, x3)));
    }

    /* Fractal Brownian Motion — layered swell. */
    float fbm(vec3 p) {
        float total = 0.0;
        float amp = 0.5;
        float freq = 1.0;
        for (int i = 0; i < 5; i++) {
            total += amp * snoise(p * freq);
            freq *= 2.0;
            amp  *= 0.5;
        }
        return total;
    }

    void main() {
        vec2 uv = v_uv;
        vec2 aspect = vec2(u_resolution.x / u_resolution.y, 1.0);

        vec2 p = (uv - 0.5) * aspect;
        vec2 m = (u_mouse - 0.5) * aspect;

        vec2 toMouse = m - p;
        float mouseDist = length(toMouse);

        /* Slow, wide swell + finer chop stretched horizontally so it
           reads as water, not smoke. */
        float t = u_time * 0.045;
        vec2 stretched = vec2(p.x * 0.9, p.y * 2.2);
        float swell = fbm(vec3(stretched * 1.1, t));
        float chop  = fbm(vec3(stretched * 3.4 + 7.3, t * 1.6));
        float n = swell * 0.7 + chop * 0.3;
        n = smoothstep(-0.7, 0.9, n);

        /* Sun path — warm light pooling toward the cursor. */
        float sun = u_mouse_intensity * exp(-mouseDist * 2.2) * 0.8;

        /* Palette: Pacific at dusk. */
        vec3 abyss = vec3(0.039, 0.102, 0.149);   // #0a1a26 ocean-950
        vec3 deep  = vec3(0.059, 0.145, 0.200);   // #0f2533 ocean-900
        vec3 swellBlue = vec3(0.200, 0.392, 0.490); // #33647d ocean-600
        vec3 foam  = vec3(0.851, 0.788, 0.698);   // sand foam glint
        vec3 sunGold = vec3(0.804, 0.510, 0.341); // terra sun path

        vec3 col = mix(abyss, deep, n);
        col = mix(col, swellBlue, pow(n, 2.0) * 0.55);

        /* Foam crests — only the highest swell peaks catch light. */
        float crest = smoothstep(0.78, 0.97, n);
        col = mix(col, foam, crest * 0.22);

        /* Warm sun pooling. */
        col = mix(col, sunGold, sun * (0.35 + n * 0.45));

        /* Vignette for headline contrast. */
        vec2 vig = uv - 0.5;
        float vignette = 1.0 - dot(vig, vig) * 0.8;
        col *= vignette;

        /* Hashed grain. */
        float grain = fract(sin(dot(uv * u_resolution, vec2(12.9898, 78.233))) * 43758.5453);
        col += (grain - 0.5) * 0.025;

        gl_FragColor = vec4(col, 1.0);
    }
`;

/**
 * Mount the ocean band on a host element. Returns a `destroy()` cleanup fn.
 */
export function mountOceanBg(hostEl) {
    if (!hostEl) return () => {};

    /* Respect reduced motion — the CSS gradient background stays. */
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return () => {};
    }

    const dpr = Math.min(window.devicePixelRatio || 1, 2);
    const scale = 0.6; // render at 60% then upscale — invisible on water

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({
            antialias: false,
            alpha: false,
            powerPreference: 'high-performance',
        });
    } catch (e) {
        // No WebGL context (old GPU, software rendering, power saver) —
        // leave the section's CSS gradient fallback in place.
        return () => {};
    }
    renderer.setPixelRatio(dpr * scale);
    renderer.setClearColor(0x0a1a26, 1);

    const canvas = renderer.domElement;
    canvas.style.position = 'absolute';
    canvas.style.inset = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.display = 'block';
    hostEl.appendChild(canvas);

    const scene = new THREE.Scene();
    const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

    const uniforms = {
        u_time:            { value: 0 },
        u_resolution:      { value: new THREE.Vector2(1, 1) },
        u_mouse:           { value: new THREE.Vector2(0.5, 0.35) },
        u_mouse_intensity: { value: 0 },
    };

    const material = new THREE.ShaderMaterial({
        vertexShader: VERTEX_SHADER,
        fragmentShader: FRAGMENT_SHADER,
        uniforms,
    });

    const plane = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), material);
    scene.add(plane);

    function resize() {
        const w = hostEl.clientWidth;
        const h = hostEl.clientHeight;
        renderer.setSize(w, h, false);
        uniforms.u_resolution.value.set(w, h);
    }
    resize();
    window.addEventListener('resize', resize, { passive: true });

    /* Pointer tracking (smoothed) */
    const targetMouse = new THREE.Vector2(0.5, 0.35);
    let targetIntensity = 0;

    function setMouseFromEvent(clientX, clientY) {
        const rect = hostEl.getBoundingClientRect();
        targetMouse.x = (clientX - rect.left) / rect.width;
        targetMouse.y = 1.0 - (clientY - rect.top) / rect.height;
        targetIntensity = 1.0;
    }

    function onPointerMove(e)  { setMouseFromEvent(e.clientX, e.clientY); }
    function onPointerLeave()  { targetIntensity = 0; }
    function onPointerEnter()  { targetIntensity = 1; }

    hostEl.addEventListener('pointermove', onPointerMove, { passive: true });
    hostEl.addEventListener('pointerenter', onPointerEnter, { passive: true });
    hostEl.addEventListener('pointerleave', onPointerLeave, { passive: true });

    /* Visibility pause */
    let visible = true;
    const io = new IntersectionObserver(
        (entries) => { visible = entries[0]?.isIntersecting ?? true; },
        { threshold: 0.01 },
    );
    io.observe(hostEl);

    /* Render loop */
    let raf = 0;
    let lastT = performance.now();

    function tick(now) {
        const dt = Math.min((now - lastT) / 1000, 0.05);
        lastT = now;

        uniforms.u_mouse.value.lerp(targetMouse, Math.min(dt * 5, 1));
        uniforms.u_mouse_intensity.value +=
            (targetIntensity - uniforms.u_mouse_intensity.value) * Math.min(dt * 3, 1);

        if (visible) {
            uniforms.u_time.value += dt;
            renderer.render(scene, camera);
        }
        raf = requestAnimationFrame(tick);
    }
    raf = requestAnimationFrame(tick);

    /* Fade the canvas in once the first frame is ready */
    canvas.style.opacity = '0';
    canvas.style.transition = 'opacity 800ms ease-out';
    requestAnimationFrame(() => {
        canvas.style.opacity = '1';
    });

    return function destroy() {
        cancelAnimationFrame(raf);
        io.disconnect();
        window.removeEventListener('resize', resize);
        hostEl.removeEventListener('pointermove', onPointerMove);
        hostEl.removeEventListener('pointerenter', onPointerEnter);
        hostEl.removeEventListener('pointerleave', onPointerLeave);
        plane.geometry.dispose();
        material.dispose();
        renderer.dispose();
        if (canvas.parentNode === hostEl) hostEl.removeChild(canvas);
    };
}

/* Auto-mount: any element with [data-ocean-bg]. */
if (typeof document !== 'undefined') {
    const boot = () => {
        document.querySelectorAll('[data-ocean-bg]').forEach((el) => {
            // A failed mount must never break the rest of the bundle —
            // boot() can run synchronously during module evaluation.
            try {
                mountOceanBg(el);
            } catch (e) {
                /* CSS gradient fallback stays */
            }
        });
    };
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
}
