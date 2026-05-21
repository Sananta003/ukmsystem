<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin UKM')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-primary': '#1e293b',   // Ganti dengan Hex Warna Utama Figma Anda
                        'brand-secondary': '#8b5cf6', // Ganti dengan Hex Warna Sekunder Figma Anda
                        'brand-accent': '#2563eb'     // Warna Aksen Biru (Default Admin UKM)
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
            @php $ukm = \App\Models\Ukm::find(Auth::user()->ukm_id); @endphp
            <div class="w-8 h-8 bg-brand-accent rounded flex items-center justify-center overflow-hidden shadow-lg shadow-brand-accent/30">
                @if($ukm && $ukm->logo)
                    <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="w-full h-full object-cover">
                @else
                    <i class="fa-solid fa-graduation-cap text-white text-sm"></i>
                @endif
            </div>
            <div>
                <h1 class="font-bold text-sm tracking-wide">UKM System</h1>
                <p class="text-[10px] text-slate-400">Pengurus Panel</p>
            </div>
        </div>

        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
            <a href="{{ route('admin-ukm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.dashboard') ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-border-all w-5"></i>
                <span class="text-sm font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.kegiatan.*') ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-calendar-days w-5"></i>
                <span class="text-sm font-medium">Kegiatan</span>
            </a>
            <a href="{{ route('admin-ukm.keuangan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.keuangan.*') ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-money-bill-wave w-5"></i>
                <span class="text-sm font-medium">Keuangan</span>
            </a>
            <a href="{{ route('admin-ukm.anggota.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.anggota.*') ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-users w-5"></i>
                <span class="text-sm font-medium">Anggota</span>
            </a>
            <div x-data="{ open: {{ request()->routeIs('admin-ukm.laporan.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.laporan.*') ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-file-lines w-5"></i>
                        <span class="text-sm font-medium">Laporan</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" style="display: none;" class="pl-11 pr-3 pt-2 pb-1 space-y-1">
                    <a href="{{ route('admin-ukm.laporan.index') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin-ukm.laporan.index') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        Keuangan
                    </a>
                    <a href="{{ route('admin-ukm.laporan.proposal') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin-ukm.laporan.proposal') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        Cek Proposal
                    </a>
                </div>
            </div>
            <a href="{{ route('admin-ukm.pengaturan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.pengaturan.*') ? 'bg-brand-accent text-white shadow-sm' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-gear w-5"></i>
                <span class="text-sm font-medium">Pengaturan</span>
            </a>
        </nav>

        <form id="logout-form-ukm" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
        <div class="p-4 m-4 bg-white/5 rounded-xl cursor-pointer hover:bg-red-500/20 hover:text-red-400 border border-white/5 transition-colors" onclick="document.getElementById('logout-form-ukm').submit();">
            <div class="flex items-center gap-3 text-red-400">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="text-sm font-medium">Keluar Aplikasi</span>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shrink-0">
            <div class="relative w-96">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" placeholder="Cari..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-brand-accent">
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-brand-accent/10 flex items-center justify-center text-brand-accent font-bold uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6">
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

    @stack('scripts')
</body>
</html>