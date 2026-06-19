<!DOCTYPE html>
<html class="dark" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>TECH-SPECTRUM | Ingeniería y Consultoría IT de Vanguardia</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@400;500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@100..900&family=Montserrat:wght@100..900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Tus estilos CSS personalizados aquí (blueprint-grid, sapphire-glow, etc.) */
        @font-face { font-family: 'Geist'; src: url('https://cdn.jsdelivr.net/npm/geist-font@1.1.0/fonts/geist-sans/Geist-Regular.woff2') format('woff2'); }
        body { background-color: #050A14; color: #dde3ed; font-family: 'Inter', sans-serif; overflow-x: hidden; }
       .blueprint-grid {
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px), 
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
}
        .sapphire-glow { box-shadow: 0 0 40px -10px rgba(15, 98, 254, 0.3); }
        .card-hover:hover { border-color: #b4c5ff; background-color: #121926; transform: translateY(-4px); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
    
    <script id="tailwind-config">
        /* Tu configuración de Tailwind (theme, colors, etc.) */
        tailwind.config = { darkMode: "class", theme: { /* ... toda tu configuración de tailwind ... */ } }
    </script>
</head>
<body class="bg-background text-on-background">
    <canvas id="grid-canvas" style="position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:0;"></canvas>

    <div style="position:relative;z-index:1;">
        <x-navbar />
        <main>{{ $slot }}</main>
        <x-footer />
    </div>

   <script>
(function() {
    const canvas = document.getElementById('grid-canvas');
    const ctx = canvas.getContext('2d');
    const CELL = 40;
    const RADIUS = 120;
    let mouse = { x: -999, y: -999 };
    let W, H;
    let time = 0;
    let pulses = [];
    let particles = [];

    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }

    function distortPoint(x, y) {
        const dx = x - mouse.x;
        const dy = y - mouse.y;
        const dist = Math.hypot(dx, dy);
        if (dist >= RADIUS || mouse.x < 0) return { x, y };
        const lens = 1 + 0.35 * Math.pow(1 - dist / RADIUS, 2);
        return { x: mouse.x + dx * lens, y: mouse.y + dy * lens };
    }

    // Pulso expansivo al hacer click
    function spawnPulse(x, y) {
        pulses.push({ x, y, r: 0, maxR: Math.max(W, H) * 0.7, alpha: 0.6, speed: 6 });
    }

    // Partícula en intersección
    function spawnParticle(x, y) {
        const angle = Math.random() * Math.PI * 2;
        const speed = 0.4 + Math.random() * 0.8;
        particles.push({
            x, y,
            vx: Math.cos(angle) * speed,
            vy: Math.sin(angle) * speed,
            life: 1,
            decay: 0.012 + Math.random() * 0.01,
            size: 1 + Math.random() * 1.5
        });
    }

    // Spawn aleatorio de partículas en intersecciones cercanas al mouse
    function maybeSpawnParticles() {
        if (mouse.x < 0) return;
        const cx = Math.round(mouse.x / CELL) * CELL;
        const cy = Math.round(mouse.y / CELL) * CELL;
        for (let dr = -2; dr <= 2; dr++) {
            for (let dc = -2; dc <= 2; dc++) {
                const ix = cx + dc * CELL;
                const iy = cy + dr * CELL;
                const dist = Math.hypot(mouse.x - ix, mouse.y - iy);
                if (dist < RADIUS && Math.random() < 0.015) {
                    spawnParticle(ix, iy);
                }
            }
        }
    }

    function drawGrid() {
        const cols = Math.ceil(W / CELL) + 2;
        const rows = Math.ceil(H / CELL) + 2;

        // Onda de barrido global (scan line)
        const scanY = (time * 0.4) % (H + 80) - 40;

        for (let c = 0; c <= cols; c++) {
            const x = c * CELL;
            for (let r = 0; r <= rows; r++) {
                const y = r * CELL;
                const dist = Math.hypot(mouse.x - x, mouse.y - y);

                // Alpha base + efecto cursor
                let alpha = dist < RADIUS
                    ? 0.03 + (1 - dist / RADIUS) * 0.35
                    : 0.03;

                // Scan line: onda horizontal que baja
                const scanDist = Math.abs(y - scanY);
                if (scanDist < 60) alpha += (1 - scanDist / 60) * 0.06;

                // Pulsos expansivos
                for (const p of pulses) {
                    const pd = Math.abs(Math.hypot(x - p.x, y - p.y) - p.r);
                    if (pd < 30) alpha += (1 - pd / 30) * p.alpha * 0.5;
                }

                // Color: azul cerca del cursor, blanco en el resto
                const t = dist < RADIUS ? (1 - dist / RADIUS) : 0;
                const r2 = Math.round(255 - t * (255 - 15));
                const g2 = Math.round(255 - t * (255 - 98));
                const b2 = 255;

                ctx.strokeStyle = `rgba(${r2},${g2},${b2},${alpha.toFixed(3)})`;
                ctx.lineWidth = dist < RADIUS ? 1 + (1 - dist / RADIUS) * 0.5 : 1;

                // Línea vertical
                const vs = distortPoint(x, y);
                const ve = distortPoint(x, y + CELL);
                ctx.beginPath();
                ctx.moveTo(vs.x, vs.y);
                ctx.lineTo(ve.x, ve.y);
                ctx.stroke();

                // Línea horizontal
                const hs = distortPoint(x, y);
                const he = distortPoint(x + CELL, y);
                ctx.beginPath();
                ctx.moveTo(hs.x, hs.y);
                ctx.lineTo(he.x, he.y);
                ctx.stroke();
            }
        }
    }

    function drawDots() {
        const cols = Math.ceil(W / CELL) + 2;
        const rows = Math.ceil(H / CELL) + 2;

        for (let c = 0; c <= cols; c++) {
            for (let r = 0; r <= rows; r++) {
                const x = c * CELL;
                const y = r * CELL;
                const dist = Math.hypot(mouse.x - x, mouse.y - y);
                if (dist > RADIUS * 1.2) continue;

                const t = 1 - dist / (RADIUS * 1.2);
                // Pulso de tamaño en los nodos
                const pulse = 0.5 + Math.sin(time * 0.05 + c * 0.5 + r * 0.5) * 0.5;
                const dotR = t * pulse * 2.5;
                if (dotR < 0.3) continue;

                const p = distortPoint(x, y);
                ctx.beginPath();
                ctx.arc(p.x, p.y, dotR, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(15,98,254,${(t * 0.8).toFixed(3)})`;
                ctx.fill();
            }
        }
    }

    function drawPulses() {
        for (let i = pulses.length - 1; i >= 0; i--) {
            const p = pulses[i];
            p.r += p.speed;
            p.alpha *= 0.97;
            if (p.r > p.maxR || p.alpha < 0.005) { pulses.splice(i, 1); continue; }

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.strokeStyle = `rgba(15,98,254,${p.alpha.toFixed(3)})`;
            ctx.lineWidth = 1.5;
            ctx.stroke();
        }
    }

    function drawParticles() {
        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];
            p.x  += p.vx;
            p.y  += p.vy;
            p.life -= p.decay;
            if (p.life <= 0) { particles.splice(i, 1); continue; }

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.size * p.life, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(15,98,254,${p.life.toFixed(3)})`;
            ctx.fill();
        }
    }

    function drawHalo() {
        if (mouse.x < 0) return;
        const grd = ctx.createRadialGradient(mouse.x, mouse.y, 0, mouse.x, mouse.y, RADIUS);
        grd.addColorStop(0,   'rgba(15,98,254,0.06)');
        grd.addColorStop(0.6, 'rgba(15,98,254,0.02)');
        grd.addColorStop(1,   'rgba(15,98,254,0)');
        ctx.fillStyle = grd;
        ctx.beginPath();
        ctx.arc(mouse.x, mouse.y, RADIUS, 0, Math.PI * 2);
        ctx.fill();
    }

    function loop() {
        ctx.clearRect(0, 0, W, H);
        time++;
        maybeSpawnParticles();
        drawGrid();
        drawDots();
        drawPulses();
        drawParticles();
        drawHalo();
        requestAnimationFrame(loop);
    }

    window.addEventListener('mousemove', e => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });

    window.addEventListener('click', e => {
        spawnPulse(e.clientX, e.clientY);
    });

    window.addEventListener('resize', resize);
    resize();
    loop();
})();
</script>
</body>
</html>