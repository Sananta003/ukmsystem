<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pusat Komando Kampus')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-primary': '#1e293b',   // Ganti dengan Hex Warna Utama Figma Anda
                        'brand-secondary': '#8b5cf6', // Ganti dengan Hex Warna Sekunder Figma Anda
                        'brand-accent': '#3b82f6'     // Ganti dengan Hex Warna Aksen Figma Anda
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">
    <aside class="w-64 bg-brand-primary text-white flex flex-col h-full shrink-0 transition-all duration-300">
        <div class="flex items-center gap-3 p-6 border-b border-white/10">
            <div class="w-8 h-8 bg-brand-secondary rounded flex items-center justify-center shadow-lg shadow-brand-secondary/30">
                <i class="fa-solid fa-building-columns text-white text-sm"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm tracking-wide">Pusat Kampus</h1>
                <p class="text-[10px] text-slate-400">Super Admin Panel</p>
            </div>
        </div>

        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors bg-brand-secondary text-white shadow-sm hover:shadow-md">
                <i class="fa-solid fa-sitemap w-5"></i>
                <span class="text-sm font-medium">Manajemen UKM</span>
            </a>
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        <div class="p-4 m-4 bg-white/5 rounded-xl cursor-pointer hover:bg-red-500/20 hover:text-red-400 transition-colors border border-white/5" onclick="document.getElementById('logout-form').submit();">
            <div class="flex items-center gap-3 text-red-400">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="text-sm font-medium">Keluar Aplikasi</span>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shrink-0">
            <h2 class="font-bold text-gray-800">Administrator Kampus</h2>
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-600">{{ Auth::user()->name ?? 'Admin' }}</span>
                <div class="w-9 h-9 rounded-full bg-brand-secondary/10 text-brand-secondary flex items-center justify-center font-bold">SA</div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="relative flex items-center justify-between p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-check mr-2"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700 ml-4">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="relative flex items-center justify-between p-4 mb-6 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700 ml-4">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>   
</html>