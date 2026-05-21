// Global Cyberpunk Mouse Trail Effect
document.addEventListener('DOMContentLoaded', () => {
    // Only enable mouse trail on desktop devices
    if (window.matchMedia('(pointer: fine)').matches) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.style.position = 'fixed';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100vw';
        canvas.style.height = '100vh';
        canvas.style.pointerEvents = 'none';
        canvas.style.zIndex = '9999';
        document.body.appendChild(canvas);

        let width = canvas.width = window.innerWidth;
        let height = canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        });

        const points = [];

        window.addEventListener('mousemove', (e) => {
            points.push({
                x: e.clientX,
                y: e.clientY,
                color: Math.random() > 0.5 ? '#ef4444' : '#f97316', // Theme red or orange
                life: 1.0 // Start with full life
            });
        });

        function animate() {
            ctx.clearRect(0, 0, width, height);

            // Decay the life of all points
            for (let i = 0; i < points.length; i++) {
                points[i].life -= 0.025; // Control fade out speed here
            }

            // Remove expired points from the beginning
            while (points.length > 0 && points[0].life <= 0) {
                points.shift();
            }

            if (points.length > 1) {
                for (let i = 0; i < points.length - 1; i++) {
                    const p1 = points[i];
                    const p2 = points[i + 1];

                    const ratio = i / points.length;
                    const opacity = ratio * 0.7 * p1.life;

                    if (opacity <= 0) continue;

                    ctx.beginPath();
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(p2.x, p2.y);

                    ctx.strokeStyle = p1.color;
                    ctx.globalAlpha = opacity;
                    ctx.lineWidth = ratio * 5 + 1.5;
                    ctx.lineCap = 'round';
                    ctx.lineJoin = 'round';

                    ctx.shadowBlur = ratio * 10;
                    ctx.shadowColor = p1.color;

                    ctx.stroke();
                }
            }

            ctx.globalAlpha = 1.0;
            ctx.shadowBlur = 0;

            requestAnimationFrame(animate);
        }

        animate();
    }
});
