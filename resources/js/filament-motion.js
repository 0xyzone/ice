import * as THREE from 'three';
import gsap from 'gsap';

const activeCleanups = [];

function registerCleanup(fn) {
    activeCleanups.push(fn);
}

function runCleanups() {
    while (activeCleanups.length) {
        const fn = activeCleanups.pop();
        try {
            fn();
        } catch (e) {
            // Ignore cleanup errors on detached nodes
        }
    }
}

function initAmbientWebGL() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    if (document.getElementById('icf-ambient-webgl')) {
        return;
    }

    let renderer;
    try {
        renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true, powerPreference: 'low-power' });
    } catch (e) {
        return;
    }

    const canvas = renderer.domElement;
    canvas.id = 'icf-ambient-webgl';
    canvas.style.cssText = 'position:fixed;inset:0;width:100vw;height:100vh;pointer-events:none;z-index:0;opacity:0.55;';
    document.body.prepend(canvas);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 100);
    camera.position.z = 16;

    const particleCount = window.innerWidth < 768 ? 48 : 95;
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);
    const palette = [
        new THREE.Color(0xf97316),
        new THREE.Color(0xfbbf24),
        new THREE.Color(0x38bdf8),
    ];

    for (let i = 0; i < particleCount; i++) {
        positions[i * 3] = (Math.random() - 0.5) * 34;
        positions[i * 3 + 1] = (Math.random() - 0.5) * 22;
        positions[i * 3 + 2] = (Math.random() - 0.5) * 14;
        const c = palette[i % palette.length];
        colors[i * 3] = c.r;
        colors[i * 3 + 1] = c.g;
        colors[i * 3 + 2] = c.b;
    }

    const particleGeom = new THREE.BufferGeometry();
    particleGeom.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particleGeom.setAttribute('color', new THREE.BufferAttribute(colors, 3));

    const particleMat = new THREE.PointsMaterial({
        size: 0.14,
        vertexColors: true,
        transparent: true,
        opacity: 0.72,
    });
    const points = new THREE.Points(particleGeom, particleMat);
    scene.add(points);

    const wireGroup = new THREE.Group();
    const icoA = new THREE.Mesh(
        new THREE.IcosahedronGeometry(2.6, 0),
        new THREE.MeshBasicMaterial({ color: 0xf97316, wireframe: true, transparent: true, opacity: 0.14 })
    );
    icoA.position.set(-8.5, 4.2, -4);
    wireGroup.add(icoA);

    const icoB = new THREE.Mesh(
        new THREE.OctahedronGeometry(2.1, 0),
        new THREE.MeshBasicMaterial({ color: 0x38bdf8, wireframe: true, transparent: true, opacity: 0.12 })
    );
    icoB.position.set(9.2, -3.8, -5);
    wireGroup.add(icoB);
    scene.add(wireGroup);

    const pointer = { x: 0, y: 0 };
    const onPointerMove = (e) => {
        pointer.x = (e.clientX / window.innerWidth - 0.5) * 2;
        pointer.y = (e.clientY / window.innerHeight - 0.5) * 2;
    };
    window.addEventListener('pointermove', onPointerMove, { passive: true });

    const onResize = () => {
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.75));
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    };
    onResize();
    window.addEventListener('resize', onResize, { passive: true });

    const timer = new THREE.Timer();
    timer.connect(document);

    renderer.setAnimationLoop(() => {
        if (document.hidden) {
            return;
        }
        timer.update();
        const delta = Math.min(timer.getDelta(), 0.05);

        points.rotation.y += delta * 0.025;
        points.rotation.x += delta * 0.012;
        icoA.rotation.x += delta * 0.14;
        icoA.rotation.y += delta * 0.18;
        icoB.rotation.y -= delta * 0.16;
        icoB.rotation.z += delta * 0.11;

        camera.position.x += (pointer.x * 0.9 - camera.position.x) * 0.04;
        camera.position.y += (-pointer.y * 0.6 - camera.position.y) * 0.04;
        camera.lookAt(0, 0, 0);

        renderer.render(scene, camera);
    });
}

function initHeroCrestCanvases() {
    const containers = document.querySelectorAll('.icf-3d-crest-canvas');
    containers.forEach((container) => {
        if (container.dataset.threeMounted === '1') {
            return;
        }
        container.dataset.threeMounted = '1';

        let renderer;
        try {
            renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        } catch (e) {
            return;
        }

        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(42, 1, 0.1, 50);
        camera.position.set(0, 0.3, 5.4);

        const ambient = new THREE.AmbientLight(0xffffff, 0.75);
        scene.add(ambient);

        const keyLight = new THREE.DirectionalLight(0xffedd5, 2.2);
        keyLight.position.set(3, 4, 5);
        scene.add(keyLight);

        const rimLight = new THREE.PointLight(0xf97316, 4.5, 14);
        rimLight.position.set(-2.5, -1.5, 3);
        scene.add(rimLight);

        const crestGroup = new THREE.Group();

        const core = new THREE.Mesh(
            new THREE.IcosahedronGeometry(1.12, 0),
            new THREE.MeshStandardMaterial({
                color: 0xf97316,
                metalness: 0.65,
                roughness: 0.22,
                emissive: 0x7c2d12,
                emissiveIntensity: 0.45,
            })
        );
        crestGroup.add(core);

        const shell = new THREE.Mesh(
            new THREE.IcosahedronGeometry(1.42, 0),
            new THREE.MeshBasicMaterial({
                color: 0xfbbf24,
                wireframe: true,
                transparent: true,
                opacity: 0.45,
            })
        );
        crestGroup.add(shell);

        const ringA = new THREE.Mesh(
            new THREE.TorusGeometry(1.85, 0.032, 12, 64),
            new THREE.MeshStandardMaterial({ color: 0xfbbf24, metalness: 0.8, roughness: 0.2 })
        );
        ringA.rotation.x = Math.PI / 3;
        crestGroup.add(ringA);

        const ringB = new THREE.Mesh(
            new THREE.TorusGeometry(2.08, 0.025, 12, 64),
            new THREE.MeshStandardMaterial({ color: 0x38bdf8, metalness: 0.7, roughness: 0.25 })
        );
        ringB.rotation.y = Math.PI / 4;
        crestGroup.add(ringB);

        scene.add(crestGroup);
        container.innerHTML = '';
        container.appendChild(renderer.domElement);

        const resize = () => {
            const w = Math.max(container.clientWidth, 120);
            const h = Math.max(container.clientHeight, 120);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
            renderer.setSize(w, h, false);
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
        };
        resize();

        const ro = typeof ResizeObserver !== 'undefined' ? new ResizeObserver(resize) : null;
        if (ro) {
            ro.observe(container);
        }

        const targetTilt = { x: 0, y: 0 };
        const onMove = (e) => {
            const rect = container.getBoundingClientRect();
            targetTilt.y = ((e.clientX - rect.left) / rect.width - 0.5) * 0.9;
            targetTilt.x = ((e.clientY - rect.top) / rect.height - 0.5) * 0.7;
        };
        const onLeave = () => {
            targetTilt.x = 0;
            targetTilt.y = 0;
        };
        container.addEventListener('pointermove', onMove, { passive: true });
        container.addEventListener('pointerleave', onLeave, { passive: true });

        const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const timer = new THREE.Timer();
        timer.connect(document);

        renderer.setAnimationLoop(() => {
            if (document.hidden) {
                return;
            }
            timer.update();
            const dt = Math.min(timer.getDelta(), 0.05);

            if (!reduced) {
                core.rotation.y += dt * 0.65;
                core.rotation.x += dt * 0.28;
                shell.rotation.y -= dt * 0.35;
                ringA.rotation.z += dt * 0.55;
                ringB.rotation.x -= dt * 0.42;
            }

            crestGroup.rotation.x += (targetTilt.x - crestGroup.rotation.x) * 0.08;
            crestGroup.rotation.y += (targetTilt.y - crestGroup.rotation.y) * 0.08;

            renderer.render(scene, camera);
        });

        registerCleanup(() => {
            renderer.setAnimationLoop(null);
            renderer.dispose();
            if (ro) {
                ro.disconnect();
            }
            container.removeEventListener('pointermove', onMove);
            container.removeEventListener('pointerleave', onLeave);
        });
    });
}

function initGsapMotion() {
    const mm = gsap.matchMedia();

    mm.add('(prefers-reduced-motion: no-preference)', () => {
        const widgets = document.querySelectorAll('.fi-wi-widget');
        if (widgets.length) {
            gsap.fromTo(
                widgets,
                { y: 18, autoAlpha: 0 },
                {
                    y: 0,
                    autoAlpha: 1,
                    duration: 0.48,
                    stagger: 0.065,
                    ease: 'power3.out',
                    clearProps: 'transform,opacity,visibility',
                }
            );
        }

        const cards = document.querySelectorAll('.fi-ta-content-grid > .fi-ta-record');
        if (cards.length) {
            gsap.fromTo(
                cards,
                { y: 14, scale: 0.985, autoAlpha: 0 },
                {
                    y: 0,
                    scale: 1,
                    autoAlpha: 1,
                    duration: 0.4,
                    stagger: 0.045,
                    ease: 'power2.out',
                    clearProps: 'transform,opacity,visibility',
                }
            );
        }

        // Animated numeric stat counters
        document.querySelectorAll('.fi-wi-stats-overview-stat-value').forEach((el) => {
            if (el.dataset.counted === '1') {
                return;
            }
            const raw = (el.textContent || '').trim();
            const match = raw.match(/^([\d,]+(?:\.\d+)?)(%?)$/);
            if (!match) {
                return;
            }
            const target = parseFloat(match[1].replace(/,/g, ''));
            if (Number.isNaN(target) || target === 0) {
                return;
            }
            el.dataset.counted = '1';
            const decimals = match[1].includes('.') ? match[1].split('.')[1].length : 0;
            const suffix = match[2] || '';
            const state = { val: 0 };

            gsap.to(state, {
                val: target,
                duration: 0.8,
                ease: 'power2.out',
                onUpdate: () => {
                    el.textContent =
                        state.val.toLocaleString(undefined, {
                            minimumFractionDigits: decimals,
                            maximumFractionDigits: decimals,
                        }) + suffix;
                },
            });
        });

        // Subtle 3D hover tilt on fine-pointer devices
        if (window.matchMedia('(pointer: fine)').matches) {
            document.querySelectorAll('.fi-wi-stats-overview-stat, .icf-3d-tilt').forEach((card) => {
                if (card.dataset.tiltBound === '1') {
                    return;
                }
                card.dataset.tiltBound = '1';

                const onMove = (e) => {
                    const rect = card.getBoundingClientRect();
                    const nx = (e.clientX - rect.left) / rect.width - 0.5;
                    const ny = (e.clientY - rect.top) / rect.height - 0.5;
                    gsap.to(card, {
                        rotationY: nx * 6,
                        rotationX: -ny * 6,
                        transformPerspective: 900,
                        duration: 0.25,
                        ease: 'power2.out',
                    });
                };

                const onLeave = () => {
                    gsap.to(card, {
                        rotationY: 0,
                        rotationX: 0,
                        duration: 0.4,
                        ease: 'power3.out',
                    });
                };

                card.addEventListener('pointermove', onMove, { passive: true });
                card.addEventListener('pointerleave', onLeave, { passive: true });
            });
        }
    });

    registerCleanup(() => mm.revert());
}

function measureInNav(nav, el) {
    const navRect = nav.getBoundingClientRect();
    const elRect = el.getBoundingClientRect();

    return {
        x: elRect.left - navRect.left + nav.scrollLeft,
        y: elRect.top - navRect.top + nav.scrollTop,
        width: elRect.width,
        height: elRect.height,
    };
}

function initSidebarMotion() {
    const nav = document.querySelector('.fi-sidebar-nav');
    if (!nav) {
        return;
    }

    nav.classList.add('icf-has-sidebar-motion');

    let activePill = nav.querySelector('.icf-sidebar-active-pill');
    if (!activePill) {
        activePill = document.createElement('div');
        activePill.className = 'icf-sidebar-active-pill';
        nav.prepend(activePill);
    }

    let hoverPill = nav.querySelector('.icf-sidebar-hover-pill');
    if (!hoverPill) {
        hoverPill = document.createElement('div');
        hoverPill.className = 'icf-sidebar-hover-pill';
        nav.prepend(hoverPill);
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const activeBtn = nav.querySelector('.fi-sidebar-item.fi-active > .fi-sidebar-item-btn');

    const syncActivePill = (animate = true) => {
        if (!activeBtn || activeBtn.offsetParent === null) {
            activePill.style.opacity = '0';
            return;
        }

        const target = measureInNav(nav, activeBtn);
        activePill.style.opacity = '1';

        const prev = window.__icfSidebarActiveRect;
        window.__icfSidebarActiveRect = target;

        if (!animate || reducedMotion || !prev) {
            gsap.set(activePill, {
                x: target.x,
                y: target.y,
                width: target.width,
                height: target.height,
            });
            return;
        }

        gsap.fromTo(
            activePill,
            { x: prev.x, y: prev.y, width: prev.width, height: prev.height },
            {
                x: target.x,
                y: target.y,
                width: target.width,
                height: target.height,
                duration: 0.36,
                ease: 'power3.out',
                overwrite: 'auto',
            }
        );
    };

    syncActivePill(true);

    if (nav.dataset.sidebarMotionBound !== '1') {
        nav.dataset.sidebarMotionBound = '1';

        let hoveredBtn = null;

        const onPointerMove = (e) => {
            if (reducedMotion) {
                return;
            }
            const btn = e.target.closest('.fi-sidebar-item-btn');
            if (!btn || !nav.contains(btn)) {
                return;
            }

            const btnRect = btn.getBoundingClientRect();
            const relX = e.clientX - btnRect.left;
            const relY = e.clientY - btnRect.top;
            hoverPill.style.setProperty('--mx', `${relX}px`);
            hoverPill.style.setProperty('--my', `${relY}px`);

            if (hoveredBtn !== btn) {
                hoveredBtn = btn;
                const pos = measureInNav(nav, btn);
                gsap.to(hoverPill, {
                    x: pos.x,
                    y: pos.y,
                    width: pos.width,
                    height: pos.height,
                    opacity: 1,
                    duration: 0.24,
                    ease: 'power2.out',
                    overwrite: 'auto',
                });
            }
        };

        const onPointerLeave = () => {
            hoveredBtn = null;
            gsap.to(hoverPill, {
                opacity: 0,
                duration: 0.2,
                ease: 'power2.out',
                overwrite: 'auto',
            });
        };

        const onClick = (e) => {
            const btn = e.target.closest('.fi-sidebar-item-btn');
            if (!btn || !nav.contains(btn) || reducedMotion) {
                return;
            }
            const pos = measureInNav(nav, btn);
            window.__icfSidebarActiveRect = pos;
            gsap.to(activePill, {
                x: pos.x,
                y: pos.y,
                width: pos.width,
                height: pos.height,
                opacity: 1,
                duration: 0.32,
                ease: 'power3.out',
                overwrite: 'auto',
            });
        };

        nav.addEventListener('pointermove', onPointerMove, { passive: true });
        nav.addEventListener('pointerleave', onPointerLeave, { passive: true });
        nav.addEventListener('click', onClick, { passive: true });

        const onResize = () => syncActivePill(false);
        window.addEventListener('resize', onResize, { passive: true });
        registerCleanup(() => {
            nav.removeEventListener('pointermove', onPointerMove);
            nav.removeEventListener('pointerleave', onPointerLeave);
            nav.removeEventListener('click', onClick);
            window.removeEventListener('resize', onResize);
            delete nav.dataset.sidebarMotionBound;
        });
    }
}

function bootMotion() {
    document.documentElement.classList.remove('icf-navigating');
    runCleanups();
    initAmbientWebGL();
    initHeroCrestCanvases();
    initSidebarMotion();
    initGsapMotion();
}

if (typeof navigator !== 'undefined' && 'serviceWorker' in navigator) {
    navigator.serviceWorker
        .getRegistrations()
        .then((registrations) => {
            registrations.forEach((registration) => registration.unregister());
        })
        .catch(() => {});
}

document.addEventListener('livewire:navigating', () => {
    document.documentElement.classList.add('icf-navigating');
    const nav = document.querySelector('.fi-sidebar-nav');
    const activeBtn = nav?.querySelector('.fi-sidebar-item.fi-active > .fi-sidebar-item-btn');
    if (nav && activeBtn && activeBtn.offsetParent !== null) {
        window.__icfSidebarActiveRect = measureInNav(nav, activeBtn);
    }
});

document.addEventListener('DOMContentLoaded', bootMotion);
document.addEventListener('livewire:navigated', () => setTimeout(bootMotion, 40));
