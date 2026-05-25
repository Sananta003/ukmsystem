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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ffd1dc 0%, #ffb6c1 50%, #ff69b4 100%);
            min-height: 100vh;
            overflow: hidden; /* Sembunyikan scroll untuk balon */
            font-family: 'Quicksand', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .heart-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="%23ffffff20" d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"/></svg>');
            background-size: 60px 60px;
            z-index: 0;
            opacity: 0.6;
        }

        .content-container {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 30px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            border-radius: 40px;
            box-shadow: 0 15px 35px rgba(255, 20, 147, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.7);
            max-width: 90%;
            width: 650px;
            animation: float-container 6s ease-in-out infinite;
        }

        h1 {
            font-family: 'Dancing Script', cursive;
            color: #d81b60;
            text-shadow: 2px 2px 5px rgba(255, 255, 255, 0.9), 0 0 25px rgba(255, 105, 180, 0.8);
            animation: pulse-heart 2s infinite cubic-bezier(0.4, 0, 0.2, 1);
            line-height: 1.3;
        }

        .subtitle {
            color: #c2185b;
            font-weight: 700;
            font-size: 1.7rem;
            margin-top: 10px;
            text-shadow: 1px 1px 3px rgba(255,255,255,0.8);
            letter-spacing: 1px;
        }

        @keyframes float-container {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse-heart {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }

        /* Anti-Gravity Balloon Animation */
        .balloon {
            position: absolute;
            bottom: -150px;
            width: 45px;
            height: 55px;
            border-radius: 50% 50% 50% 50% / 40% 40% 60% 60%;
            z-index: 5;
            animation: fly-up linear forwards;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
        }
        
        .balloon::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 9px solid;
            border-bottom-color: inherit;
        }

        .balloon::before {
            content: '';
            position: absolute;
            bottom: -35px;
            left: 50%;
            width: 1px;
            height: 30px;
            background: rgba(255, 255, 255, 0.6);
            transform: translateX(-50%);
        }

        @keyframes fly-up {
            0% { transform: translateY(0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.95; }
            50% { transform: translateY(-55vh) rotate(8deg); }
            100% { transform: translateY(-120vh) rotate(-8deg); opacity: 0; }
        }

        /* Cake SVG Styles */
        .cake-container {
            margin: 20px auto 0;
            width: 220px;
            height: 220px;
            position: relative;
        }

        .flame {
            fill: #ff9800;
            animation: flicker 0.4s infinite alternate;
            transform-origin: bottom center;
        }
        
        .flame-inner {
            fill: #ffeb3b;
            animation: flicker 0.5s infinite alternate-reverse;
            transform-origin: bottom center;
        }

        @keyframes flicker {
            0% { transform: scale(1) skewX(2deg); opacity: 0.9; }
            20% { transform: scale(1.05) skewX(-2deg); opacity: 1; }
            40% { transform: scale(0.95) skewX(3deg); opacity: 0.8; }
            60% { transform: scale(1.1) skewX(-1deg); opacity: 1; }
            80% { transform: scale(0.9) skewX(1deg); opacity: 0.9; }
            100% { transform: scale(1.02) skewX(0deg); opacity: 1; }
        }

        /* Restore Button */
        .restore-btn {
            position: absolute;
            bottom: 25px;
            right: 25px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(8px);
            color: #ad1457;
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            z-index: 50;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .restore-btn:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: scale(1.05);
            color: #d81b60;
        }

    </style>
</head>
<body>
    <div class="heart-bg"></div>
    
    <div class="content-container">
        <h1 class="text-4xl md:text-5xl lg:text-6xl px-4 py-2">
            Selamat Ulang Tahun ke-18,<br>
            Sukmaratih Nirmalasari! 💖
        </h1>
        
        <p class="subtitle">
            Istriku cintakuuuu!!!!
        </p>

        <!-- Birthday Cake Animation -->
        <div class="cake-container">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Plate -->
                <ellipse cx="100" cy="180" rx="90" ry="15" fill="#f8bbd0" stroke="#f48fb1" stroke-width="2"/>
                <ellipse cx="100" cy="177" rx="80" ry="12" fill="#fff"/>
                
                <!-- Bottom Tier -->
                <path d="M40 170 C 40 185, 160 185, 160 170 L 160 120 C 160 135, 40 135, 40 120 Z" fill="#ff80ab"/>
                <ellipse cx="100" cy="120" rx="60" ry="15" fill="#ff4081"/>
                
                <!-- Middle Tier -->
                <path d="M55 120 C 55 130, 145 130, 145 120 L 145 80 C 145 90, 55 90, 55 80 Z" fill="#ffb4a2"/>
                <ellipse cx="100" cy="80" rx="45" ry="10" fill="#f08080"/>
                
                <!-- Top Tier -->
                <path d="M65 80 C 65 90, 135 90, 135 80 L 135 50 C 135 60, 65 60, 65 50 Z" fill="#ffcdb2"/>
                <ellipse cx="100" cy="50" rx="35" ry="8" fill="#ffb4a2"/>
                
                <!-- Frosting drips (Bottom) -->
                <path d="M40 120 Q 50 140 60 120 Q 70 145 80 120 Q 90 135 100 120 Q 110 145 120 120 Q 130 135 140 120 Q 150 145 160 120" fill="#ff4081"/>
                
                <!-- Frosting drips (Middle) -->
                <path d="M55 80 Q 65 100 75 80 Q 85 95 100 80 Q 115 100 125 80 Q 135 95 145 80" fill="#f08080"/>
                
                <!-- Frosting drips (Top) -->
                <path d="M65 50 Q 75 65 85 50 Q 100 70 115 50 Q 125 65 135 50" fill="#fff"/>
                
                <!-- Candles Number 1 -->
                <rect x="80" y="20" width="8" height="30" fill="#81d4fa" rx="2"/>
                <!-- Flame 1 -->
                <path class="flame" d="M84 5 Q 88 15 84 20 Q 80 15 84 5" />
                <path class="flame-inner" d="M84 10 Q 86 16 84 20 Q 82 16 84 10" />
                <!-- Stripes 1 -->
                <line x1="80" y1="25" x2="88" y2="30" stroke="#fff" stroke-width="2"/>
                <line x1="80" y1="35" x2="88" y2="40" stroke="#fff" stroke-width="2"/>
                <line x1="80" y1="45" x2="88" y2="50" stroke="#fff" stroke-width="2"/>
                
                <!-- Candles Number 8 -->
                <rect x="110" y="20" width="8" height="30" fill="#81d4fa" rx="2"/>
                <circle cx="114" cy="26" r="6" fill="none" stroke="#81d4fa" stroke-width="3"/>
                <circle cx="114" cy="38" r="7" fill="none" stroke="#81d4fa" stroke-width="3"/>
                <!-- Flame 8 -->
                <path class="flame" d="M114 5 Q 118 15 114 20 Q 110 15 114 5" />
                <path class="flame-inner" d="M114 10 Q 116 16 114 20 Q 112 16 114 10" />
            </svg>
        </div>
    </div>

    <!-- Restore original page trigger -->
    <a href="?restore=1" class="restore-btn" onclick="return confirm('Kembali ke halaman SIM-UKM yang asli?')">
        <i class="fa-solid fa-rotate-left mr-1"></i> Selesai Kejutan
    </a>

    <script>
        // Anti-Gravity Balloon Generation Script
        function createBalloon() {
            const balloon = document.createElement('div');
            balloon.classList.add('balloon');
            
            // Random properties
            const left = Math.random() * 100; // 0 to 100vw
            const duration = Math.random() * 6 + 6; // 6 to 12 seconds
            const delay = Math.random() * 2; // 0 to 2 seconds delay
            
            // Colors: mix of hot pinks, soft pinks, white, and a bit of gold
            const colors = [
                '#ff69b4', // HotPink
                '#ff1493', // DeepPink
                '#ffb6c1', // LightPink
                '#ffc0cb', // Pink
                '#ffffff', // White
                '#f48fb1', // PaleVioletRed-ish
                '#f8bbd0'  // Very soft pink
            ];
            const color = colors[Math.floor(Math.random() * colors.length)];
            
            // Apply styles
            balloon.style.left = `${left}vw`;
            balloon.style.animationDuration = `${duration}s`;
            balloon.style.animationDelay = `${delay}s`;
            balloon.style.background = `radial-gradient(circle at 30% 30%, #fff, ${color} 60%)`;
            balloon.style.borderBottomColor = color; // For the balloon tie
            
            // Add to body
            document.body.appendChild(balloon);
            
            // Remove after animation finishes
            setTimeout(() => {
                balloon.remove();
            }, (duration + delay) * 1000);
        }

        // Generate balloons periodically (about 3 balloons per second)
        setInterval(createBalloon, 300);
        
        // Initial burst of balloons at the bottom
        for(let i=0; i<30; i++) {
            setTimeout(createBalloon, Math.random() * 2000);
        }
    </script>
</body>
</html>