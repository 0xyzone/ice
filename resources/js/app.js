// Smooth, Subtle & Elegant Cursor Follower and Trail
document.addEventListener('DOMContentLoaded', () => {
    if (!window.matchMedia('(pointer: fine)').matches) return;

    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.id = 'pro-cursor-trail-canvas';
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100vw';
    canvas.style.height = '100vh';
    canvas.style.pointerEvents = 'none';
    canvas.style.zIndex = '9999';
    document.body.appendChild(canvas);

    let dpr = window.devicePixelRatio || 1;
    let width = canvas.width = window.innerWidth * dpr;
    let height = canvas.height = window.innerHeight * dpr;

    function onResize() {
        dpr = window.devicePixelRatio || 1;
        width = canvas.width = window.innerWidth * dpr;
        height = canvas.height = window.innerHeight * dpr;
    }
    window.addEventListener('resize', onResize);

    const mouse = { x: -1000, y: -1000, lastX: -1000, lastY: -1000, speed: 0 };
    const follower = { x: -1000, y: -1000, radius: 5, targetRadius: 5 };

    const trail = [];
    const maxTrailLength = 18;

    const particles = [];
    const maxParticles = 40;

    // Subtle, calming fire palette: warm blaze, ember, amber, and golden spark
    const palette = ['#f97316', '#fb923c', '#ea580c', '#f59e0b', '#fed7aa'];

    let isHoveringInteractive = false;

    window.addEventListener('mousemove', (e) => {
        const targetX = e.clientX * dpr;
        const targetY = e.clientY * dpr;

        const dx = targetX - (mouse.lastX === -1000 ? targetX : mouse.lastX);
        const dy = targetY - (mouse.lastY === -1000 ? targetY : mouse.lastY);
        mouse.speed = Math.sqrt(dx * dx + dy * dy);

        mouse.lastX = mouse.x;
        mouse.lastY = mouse.y;
        mouse.x = targetX;
        mouse.y = targetY;

        if (follower.x === -1000) {
            follower.x = mouse.x;
            follower.y = mouse.y;
        }

        trail.push({
            x: mouse.x,
            y: mouse.y,
            life: 1.0,
            width: Math.min(8, Math.max(2.5, mouse.speed * 0.1)) * dpr,
            color: palette[Math.floor(Math.random() * palette.length)]
        });

        // Gentle micro-particles on brisk movement
        if (mouse.speed > 12 * dpr && particles.length < maxParticles) {
            const angle = Math.random() * Math.PI * 2;
            const speed = (Math.random() * 1.5 + 0.3) * dpr;
            particles.push({
                x: mouse.x,
                y: mouse.y,
                vx: Math.cos(angle) * speed,
                vy: Math.sin(angle) * speed - 0.2 * dpr,
                radius: (Math.random() * 1.6 + 0.8) * dpr,
                color: palette[Math.floor(Math.random() * palette.length)],
                life: 1.0,
                decay: 0.04
            });
        }
    }, { passive: true });

    // Subtle micro-burst on click
    window.addEventListener('click', (e) => {
        const clickX = e.clientX * dpr;
        const clickY = e.clientY * dpr;
        const burstCount = 8;

        for (let i = 0; i < burstCount; i++) {
            const angle = (Math.PI * 2 / burstCount) * i;
            const force = (Math.random() * 2.5 + 1) * dpr;
            particles.push({
                x: clickX,
                y: clickY,
                vx: Math.cos(angle) * force,
                vy: Math.sin(angle) * force,
                radius: (Math.random() * 1.8 + 1) * dpr,
                color: Math.random() > 0.4 ? '#f97316' : '#fb923c',
                life: 1.0,
                decay: 0.035
            });
        }
    }, { passive: true });

    document.addEventListener('mouseover', (e) => {
        const target = e.target;
        if (target.closest('a, button, input, [role="button"], .pro-card, .glass-card')) {
            isHoveringInteractive = true;
            follower.targetRadius = 12 * dpr;
        }
    });

    document.addEventListener('mouseout', (e) => {
        const target = e.target;
        if (target.closest('a, button, input, [role="button"], .pro-card, .glass-card')) {
            isHoveringInteractive = false;
            follower.targetRadius = 5 * dpr;
        }
    });

    function render() {
        ctx.clearRect(0, 0, width, height);

        // Smooth subtle follower halo
        if (mouse.x !== -1000) {
            follower.x += (mouse.x - follower.x) * 0.35;
            follower.y += (mouse.y - follower.y) * 0.35;
            follower.radius += (follower.targetRadius - follower.radius) * 0.2;

            ctx.save();
            ctx.beginPath();
            ctx.arc(follower.x, follower.y, follower.radius, 0, Math.PI * 2);
            ctx.fillStyle = isHoveringInteractive ? 'rgba(251, 146, 60, 0.22)' : 'rgba(249, 115, 22, 0.18)';
            ctx.shadowColor = isHoveringInteractive ? '#fb923c' : '#f97316';
            ctx.shadowBlur = 8 * dpr;
            ctx.fill();

            ctx.beginPath();
            ctx.arc(follower.x, follower.y, 1.8 * dpr, 0, Math.PI * 2);
            ctx.fillStyle = '#ffffff';
            ctx.fill();
            ctx.restore();
        }

        // Smooth Bézier trail
        if (trail.length > 2) {
            ctx.save();
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';

            for (let i = 0; i < trail.length - 1; i++) {
                const p1 = trail[i];
                const p2 = trail[i + 1];
                const progress = i / trail.length;
                const alpha = progress * 0.45 * p1.life;

                if (alpha <= 0.01) continue;

                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);

                const midX = (p1.x + p2.x) / 2;
                const midY = (p1.y + p2.y) / 2;
                ctx.quadraticCurveTo(p1.x, p1.y, midX, midY);

                ctx.strokeStyle = p1.color;
                ctx.lineWidth = p1.width * progress;
                ctx.globalAlpha = alpha;
                ctx.shadowColor = p1.color;
                ctx.shadowBlur = 4 * dpr * progress;
                ctx.stroke();
            }
            ctx.restore();
        }

        for (let i = trail.length - 1; i >= 0; i--) {
            trail[i].life -= 0.065;
            if (trail[i].life <= 0) {
                trail.splice(i, 1);
            }
        }
        while (trail.length > maxTrailLength) {
            trail.shift();
        }

        // Drifting particles
        ctx.save();
        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];
            p.x += p.vx;
            p.y += p.vy;
            p.vy += 0.02 * dpr;
            p.vx *= 0.98;
            p.life -= p.decay;

            if (p.life <= 0) {
                particles.splice(i, 1);
                continue;
            }

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius * p.life, 0, Math.PI * 2);
            ctx.fillStyle = p.color;
            ctx.globalAlpha = p.life * 0.6;
            ctx.fill();
        }
        ctx.restore();

        requestAnimationFrame(render);
    }

    render();
});
