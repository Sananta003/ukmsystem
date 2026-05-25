@php
if (request()->has('restore') && request('restore') == '1') {
    $bakPath = resource_path('views/welcome.blade.php.bak');
    $viewPath = resource_path('views/welcome.blade.php');
    if (file_exists($bakPath)) {
        copy($bakPath, $viewPath);
        try {
            \Illuminate\Support\Facades\Artisan::call('view:clear');
        } catch(\Exception $e) {}
        header("Location: " . url('/'));
        exit;
    }
}
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kejutan Spesial! 💖</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@700;900&family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --color1: #ff758c;
            --color2: #ff7eb3;
            --color3: #ffb199;
            --color4: #f06292;
        }

        body {
            margin: 0;
            padding: 40px 0;
            min-height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, var(--color1), var(--color2), var(--color3), var(--color4));
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            perspective: 1000px; /* Enable 3D space */
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism Card with 3D Depth */
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-top: 2px solid rgba(255, 255, 255, 0.8);
            border-left: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 40px;
            padding: 50px 30px;
            max-width: 90%;
            width: 750px;
            text-align: center;
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.15),
                inset 0 0 30px rgba(255, 255, 255, 0.3);
            transform-style: preserve-3d;
            transition: transform 0.1s ease-out;
            z-index: 10;
            position: relative;
        }

        /* Glow Effect Behind Card */
        .glass-card::before {
            content: '';
            position: absolute;
            top: -20px; left: -20px; right: -20px; bottom: -20px;
            background: radial-gradient(circle, rgba(255,255,255,0.5) 0%, transparent 70%);
            border-radius: 50px;
            z-index: -1;
            filter: blur(25px);
            animation: pulse-glow 3s infinite alternate;
        }

        @keyframes pulse-glow {
            0% { transform: scale(0.95); opacity: 0.5; }
            100% { transform: scale(1.05); opacity: 0.8; }
        }

        /* Typography */
        .title-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 3.5rem;
            line-height: 1.1;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 
                0 4px 15px rgba(255, 20, 147, 0.5),
                3px 3px 0px rgba(255, 105, 180, 0.8),
                -1px -1px 0px rgba(255, 255, 255, 0.6);
            transform: translateZ(60px); /* 3D Pop */
        }

        .name-text {
            font-family: 'Great Vibes', cursive;
            font-size: 5.5rem;
            color: #ff007f;
            line-height: 1;
            margin: 15px 0;
            text-shadow: 
                0 0 20px rgba(255, 255, 255, 0.9),
                0 0 40px rgba(255, 20, 147, 0.7),
                0 5px 10px rgba(0,0,0,0.15);
            transform: translateZ(90px);
            animation: floating-name 3s ease-in-out infinite;
        }

        @keyframes floating-name {
            0%, 100% { transform: translateZ(90px) translateY(0px) rotate(-2deg); }
            50% { transform: translateZ(90px) translateY(-15px) rotate(2deg); }
        }

        .subtitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            color: #fff;
            margin-top: 25px;
            text-shadow: 0 2px 8px rgba(233, 30, 99, 0.6);
            transform: translateZ(50px);
            background: linear-gradient(135deg, rgba(255,255,255,0.4), rgba(255,255,255,0.1));
            padding: 12px 40px;
            border-radius: 50px;
            display: inline-block;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        /* Detailed 3D Cake SVG */
        .cake-wrapper {
            margin-top: 40px;
            transform: translateZ(80px);
            filter: drop-shadow(0 20px 30px rgba(233, 30, 99, 0.4));
            animation: bounce-cake 4s infinite cubic-bezier(0.28, 0.84, 0.42, 1);
        }

        @keyframes bounce-cake {
            0%, 100% { transform: translateZ(80px) scale(1); }
            50% { transform: translateZ(80px) scale(1.08); }
        }

        /* Sparkles/Stars */
        .sparkle {
            position: absolute;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 12px #fff, 0 0 20px #ffb6c1, 0 0 40px #ff69b4;
            animation: twinkle var(--duration) linear infinite;
        }

        @keyframes twinkle {
            0% { transform: scale(0) rotate(0deg); opacity: 0; }
            50% { transform: scale(1) rotate(180deg); opacity: 1; }
            100% { transform: scale(0) rotate(360deg); opacity: 0; }
        }

        /* Photorealistic Balloons */
        .balloon {
            position: absolute;
            bottom: -20vh;
            width: 80px;
            height: 100px;
            border-radius: 50% 50% 50% 50% / 40% 40% 60% 60%;
            z-index: 5;
            animation: fly-up linear forwards;
            box-shadow: inset -15px -15px 25px rgba(0,0,0,0.15),
                        inset 15px 15px 25px rgba(255,255,255,0.7),
                        0 15px 25px rgba(233, 30, 99, 0.3);
        }

        .balloon::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 14px solid;
            border-bottom-color: inherit;
        }

        .balloon::before {
            content: '';
            position: absolute;
            bottom: -70px;
            left: 50%;
            width: 2px;
            height: 70px;
            background: linear-gradient(to bottom, rgba(255,255,255,0.9), transparent);
            transform: translateX(-50%);
        }

        .balloon-highlight {
            position: absolute;
            top: 15px;
            left: 18px;
            width: 18px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            transform: rotate(-35deg);
            filter: blur(3px);
        }

        @keyframes fly-up {
            0% { transform: translateY(0) rotate(0deg) scale(0.8); opacity: 0; }
            5% { opacity: 1; }
            50% { transform: translateY(-60vh) rotate(12deg) scale(1); }
            100% { transform: translateY(-130vh) rotate(-12deg) scale(1.1); opacity: 0; }
        }

        /* Floating Hearts */
        .floating-heart {
            position: absolute;
            font-size: 2.5rem;
            color: rgba(255, 255, 255, 0.9);
            animation: float-heart linear forwards;
            filter: drop-shadow(0 0 15px rgba(255, 20, 147, 0.6));
            z-index: 1;
            pointer-events: none;
        }

        @keyframes float-heart {
            0% { transform: translateY(100vh) scale(0.5) rotate(-20deg); opacity: 0; }
            20% { opacity: 1; }
            100% { transform: translateY(-20vh) scale(1.8) rotate(20deg); opacity: 0; }
        }

        /* Button Restore */
        .restore-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.7);
            padding: 14px 30px;
            border-radius: 40px;
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            cursor: pointer;
            z-index: 100;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(255, 20, 147, 0.4);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .restore-btn:hover {
            background: #fff;
            color: #ff007f;
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 20px 45px rgba(255, 20, 147, 0.6);
            border-color: #fff;
        }

        @media (max-width: 768px) {
            .title-text { font-size: 2.2rem; }
            .name-text { font-size: 4rem; }
            .subtitle { font-size: 1.3rem; padding: 10px 25px; }
            .glass-card { padding: 40px 20px; border-radius: 35px; }
            .cake-wrapper svg { width: 220px; height: 220px; }
            .restore-btn { bottom: 20px; right: 20px; padding: 10px 20px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>

    <!-- Sparkles Background -->
    <div id="sparkles-container"></div>

    <div class="glass-card" id="card">
        <h1 class="title-text">
            Selamat Ulang Tahun<br>ke-18
        </h1>
        <div class="name-text">
            Sukmaratih Nirmalasari! 💖
        </div>
        
        <div class="subtitle">
            Istriku cintakuuuu!!!!
        </div>

        <div class="cake-wrapper">
            <svg viewBox="0 0 300 250" width="280" height="280" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <!-- Cake Gradients -->
                    <linearGradient id="plate" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#fff0f5"/>
                        <stop offset="100%" stop-color="#f8bbd0"/>
                    </linearGradient>
                    <linearGradient id="tier1" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#ff80ab"/>
                        <stop offset="100%" stop-color="#c51162"/>
                    </linearGradient>
                    <linearGradient id="tier2" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#ffb4a2"/>
                        <stop offset="100%" stop-color="#ff4081"/>
                    </linearGradient>
                    <linearGradient id="tier3" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#ffcdb2"/>
                        <stop offset="100%" stop-color="#ff79b0"/>
                    </linearGradient>
                    <linearGradient id="drip" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#ffffff"/>
                        <stop offset="100%" stop-color="#ffe4e1"/>
                    </linearGradient>
                    <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                        <feGaussianBlur stdDeviation="6" result="blur" />
                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                    </filter>
                </defs>

                <!-- Shadows -->
                <ellipse cx="150" cy="225" rx="120" ry="25" fill="rgba(0,0,0,0.2)" filter="url(#glow)"/>

                <!-- Plate -->
                <ellipse cx="150" cy="215" rx="130" ry="25" fill="url(#plate)" stroke="#f48fb1" stroke-width="4"/>
                <ellipse cx="150" cy="210" rx="115" ry="20" fill="#fff"/>
                
                <!-- Bottom Tier -->
                <path d="M50 200 C 50 225, 250 225, 250 200 L 250 140 C 250 165, 50 165, 50 140 Z" fill="url(#tier1)"/>
                <ellipse cx="150" cy="140" rx="100" ry="25" fill="#ff4081"/>
                
                <!-- Middle Tier -->
                <path d="M75 140 C 75 160, 225 160, 225 140 L 225 90 C 225 110, 75 110, 75 90 Z" fill="url(#tier2)"/>
                <ellipse cx="150" cy="90" rx="75" ry="20" fill="#ff80ab"/>
                
                <!-- Top Tier -->
                <path d="M95 90 C 95 105, 205 105, 205 90 L 205 50 C 205 65, 95 65, 95 50 Z" fill="url(#tier3)"/>
                <ellipse cx="150" cy="50" rx="55" ry="15" fill="#ffb4a2"/>
                
                <!-- Frosting drips (Bottom) -->
                <path d="M50 140 Q 65 170 80 140 Q 100 180 120 140 Q 150 170 180 140 Q 200 180 220 140 Q 235 160 250 140" fill="url(#drip)"/>
                
                <!-- Frosting drips (Middle) -->
                <path d="M75 90 Q 90 120 105 90 Q 125 115 150 90 Q 175 120 195 90 Q 210 110 225 90" fill="url(#drip)"/>
                
                <!-- Frosting drips (Top) -->
                <path d="M95 50 Q 110 75 125 50 Q 150 80 175 50 Q 190 70 205 50" fill="url(#drip)"/>
                
                <!-- Decorations (Sprinkles) -->
                <rect x="130" y="60" width="6" height="15" fill="#00e676" rx="3" transform="rotate(45 130 60)"/>
                <rect x="160" y="55" width="6" height="15" fill="#29b6f6" rx="3" transform="rotate(-30 160 55)"/>
                <rect x="110" y="105" width="6" height="15" fill="#ffea00" rx="3" transform="rotate(15 110 105)"/>
                <rect x="180" y="110" width="6" height="15" fill="#00e5ff" rx="3" transform="rotate(-45 180 110)"/>
                <rect x="90" y="155" width="6" height="15" fill="#fff" rx="3" transform="rotate(60 90 155)"/>
                <rect x="200" y="160" width="6" height="15" fill="#ffee58" rx="3" transform="rotate(-20 200 160)"/>
                <rect x="140" y="170" width="6" height="15" fill="#69f0ae" rx="3" transform="rotate(80 140 170)"/>

                <!-- Candles Number 1 -->
                <g filter="url(#glow)">
                    <rect x="120" y="5" width="12" height="45" fill="url(#drip)" rx="4"/>
                    <line x1="120" y1="15" x2="132" y2="25" stroke="#f06292" stroke-width="4"/>
                    <line x1="120" y1="30" x2="132" y2="40" stroke="#f06292" stroke-width="4"/>
                    <!-- Flame 1 -->
                    <path class="flame" d="M126 -15 Q 133 0 126 5 Q 119 0 126 -15" />
                    <path class="flame-inner" d="M126 -8 Q 129 2 126 5 Q 123 2 126 -8" />
                </g>

                <!-- Candles Number 8 -->
                <g filter="url(#glow)">
                    <rect x="165" y="5" width="12" height="45" fill="url(#drip)" rx="4"/>
                    <circle cx="171" cy="15" r="9" fill="none" stroke="url(#drip)" stroke-width="5"/>
                    <circle cx="171" cy="33" r="11" fill="none" stroke="url(#drip)" stroke-width="5"/>
                    <!-- Flame 8 -->
                    <path class="flame" d="M171 -15 Q 178 0 171 5 Q 164 0 171 -15" />
                    <path class="flame-inner" d="M171 -8 Q 174 2 171 5 Q 168 2 171 -8" />
                </g>
            </svg>
        </div>
    </div>

    <a href="?restore=1" class="restore-btn" onclick="return confirm('Kembali ke halaman SIM-UKM yang asli?')">
        <i class="fa-solid fa-rotate-left"></i> Selesai Kejutan
    </a>

    <script>
        // 1. Confetti Explosion on Load
        var duration = 12 * 1000;
        var animationEnd = Date.now() + duration;
        var defaults = { startVelocity: 35, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        var interval = setInterval(function() {
            var timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            var particleCount = 50 * (timeLeft / duration);
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
        }, 250);

        // 2. 3D Tilt Effect on Mouse Move
        const card = document.getElementById('card');
        document.addEventListener('mousemove', (e) => {
            let xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            let yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            card.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });

        // Snap back on mouse leave
        document.addEventListener('mouseleave', () => {
            card.style.transform = `rotateY(0deg) rotateX(0deg)`;
        });

        // 3. Photorealistic Anti-Gravity Balloons
        function createBalloon() {
            const balloon = document.createElement('div');
            balloon.classList.add('balloon');
            
            const highlight = document.createElement('div');
            highlight.classList.add('balloon-highlight');
            balloon.appendChild(highlight);
            
            const left = Math.random() * 100;
            const duration = Math.random() * 7 + 8; // 8 to 15 seconds
            const delay = Math.random() * 2;
            
            const colors = ['#ff007f', '#ff1493', '#ff69b4', '#ffb6c1', '#ffffff', '#e91e63', '#d50000'];
            const color = colors[Math.floor(Math.random() * colors.length)];
            
            balloon.style.left = `${left}vw`;
            balloon.style.animationDuration = `${duration}s`;
            balloon.style.animationDelay = `${delay}s`;
            balloon.style.background = `radial-gradient(circle at 35% 35%, #fff 10%, ${color} 50%, #880e4f 100%)`;
            balloon.style.borderBottomColor = color;
            
            document.body.appendChild(balloon);
            
            setTimeout(() => { balloon.remove(); }, (duration + delay) * 1000);
        }

        setInterval(createBalloon, 400);
        for(let i=0; i<30; i++) { setTimeout(createBalloon, Math.random() * 2000); }

        // 4. Sparkles Background Generator
        const sparklesContainer = document.getElementById('sparkles-container');
        for(let i=0; i<60; i++) {
            let sparkle = document.createElement('div');
            sparkle.classList.add('sparkle');
            sparkle.style.width = Math.random() * 5 + 1 + 'px';
            sparkle.style.height = sparkle.style.width;
            sparkle.style.left = Math.random() * 100 + 'vw';
            sparkle.style.top = Math.random() * 100 + 'vh';
            sparkle.style.setProperty('--duration', Math.random() * 4 + 2 + 's');
            sparklesContainer.appendChild(sparkle);
        }

        // 5. Floating Hearts
        function createHeart() {
            const heart = document.createElement('div');
            heart.classList.add('floating-heart');
            heart.innerHTML = ['💖', '💕', '💗', '💘', '💞', '😍'][Math.floor(Math.random() * 6)];
            heart.style.left = Math.random() * 100 + 'vw';
            heart.style.animationDuration = Math.random() * 6 + 6 + 's';
            document.body.appendChild(heart);
            setTimeout(() => heart.remove(), 12000);
        }
        setInterval(createHeart, 600);

    </script>
</body>
</html>