<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal UKM Kampus')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        tailwind.config = { darkMode: 'class' };
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 flex h-screen overflow-hidden transition-colors duration-300" x-data="{ sidebarOpen: false, darkMode: document.documentElement.classList.contains('dark') }" x-init="$watch('darkMode', val => { if(val){ document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">
    
    @php
        $role = Auth::user()->role;
        $ukm = Auth::user()->ukm_id ? \App\Models\Ukm::find(Auth::user()->ukm_id) : null;
        
        $activeClass = 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400 font-semibold';
        switch ($role) {
            case 'super_admin': $activeClass = 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-white font-semibold'; break;
            case 'bpm': $activeClass = 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 font-semibold'; break;
            case 'bem': $activeClass = 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 font-semibold'; break;
            case 'admin_ukm': $activeClass = 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-semibold'; break;
            case 'member': case 'inisiator': $activeClass = 'bg-sky-50 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400 font-semibold'; break;
        }
        $inactiveClass = 'text-gray-500 hover:bg-gray-50 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-300 hover:text-gray-700';
    @endphp

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black/60 z-40 md:hidden backdrop-blur-sm" style="display: none;"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed md:relative z-50 w-64 bg-white dark:bg-slate-900 border-r border-gray-200/70 dark:border-slate-800 flex flex-col h-full shrink-0 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-3 p-6 border-b border-gray-200/70 dark:border-slate-800 h-16 shrink-0">
            @if($ukm && $ukm->logo)
                <div class="w-8 h-8 rounded overflow-hidden border border-gray-200 dark:border-slate-700">
                    <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-8 h-8 bg-gray-100 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded flex items-center justify-center text-gray-500 dark:text-slate-400">
                    <i class="fa-solid fa-layer-group text-sm"></i>
                </div>
            @endif
            <div>
                <h1 class="font-bold text-sm tracking-wide text-gray-800 dark:text-white">{{ $ukm ? $ukm->nama_ukm : 'Portal UKM' }}</h1>
            </div>
        </div>

        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
            @if($role === 'super_admin')
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('superadmin.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-border-all w-5"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            @elseif(in_array($role, ['bpm', 'bem']))
                <a href="{{ route('birokrasi.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('birokrasi.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-border-all w-5"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            @elseif($role === 'admin_ukm')
                <a href="{{ route('admin-ukm.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-border-all w-5"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
                <a href="{{ route('admin-ukm.kegiatan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.kegiatan.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-calendar-days w-5"></i>
                    <span class="text-sm">Kegiatan</span>
                </a>
                <a href="{{ route('admin-ukm.keuangan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.keuangan.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-money-bill-wave w-5"></i>
                    <span class="text-sm">Keuangan</span>
                </a>
                <a href="{{ route('admin-ukm.anggota.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.anggota.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-users w-5"></i>
                    <span class="text-sm">Anggota</span>
                </a>
                <div x-data="{ open: {{ request()->routeIs('admin-ukm.laporan.*') || request()->routeIs('admin-ukm.proposal.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.laporan.*') || request()->routeIs('admin-ukm.proposal.*') ? $activeClass : $inactiveClass }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-lines w-5"></i>
                            <span class="text-sm">Laporan</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" style="display: none;" class="pl-11 pr-3 pt-2 pb-1 space-y-1">
                        <a href="{{ route('admin-ukm.laporan.index') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin-ukm.laporan.index') ? $activeClass : $inactiveClass }}">Keuangan</a>
                        <a href="{{ route('admin-ukm.proposal.index') }}" class="block px-3 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('admin-ukm.proposal.*') ? $activeClass : $inactiveClass }}">Cek Proposal</a>
                    </div>
                </div>
                <a href="{{ route('admin-ukm.pengaturan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin-ukm.pengaturan.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-gear w-5"></i>
                    <span class="text-sm">Pengaturan</span>
                </a>
            @else
                <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('member.dashboard') || request()->routeIs('inisiator.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-house w-5"></i>
                    <span class="text-sm">Beranda</span>
                </a>
                <a href="{{ route('member.kegiatan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('member.kegiatan') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-calendar w-5"></i>
                    <span class="text-sm">Agenda Kegiatan</span>
                </a>
                <a href="{{ route('member.pengumuman') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('member.pengumuman') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-bullhorn w-5"></i>
                    <span class="text-sm">Pengumuman</span>
                </a>
            @endif
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        <div class="p-4 border-t border-gray-200/70 dark:border-slate-800">
            <button onclick="document.getElementById('logout-form').submit();" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 dark:text-slate-400 dark:hover:text-red-400 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-full overflow-hidden w-full relative bg-gray-50 dark:bg-slate-900">
        <header class="bg-white dark:bg-slate-900 border-b border-gray-200/70 dark:border-slate-800 h-16 flex items-center justify-between px-4 sm:px-8 shrink-0 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-white focus:outline-none transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="font-semibold text-gray-800 dark:text-slate-200 hidden sm:block">
                    @yield('title', 'Dashboard')
                </h2>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-6">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="w-9 h-9 rounded-md flex items-center justify-center text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-white bg-gray-50 hover:bg-gray-100 dark:bg-slate-800 dark:hover:bg-slate-700 transition-colors border border-gray-200 dark:border-slate-700 shadow-sm">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <div class="flex items-center gap-3 pl-3 sm:pl-6 border-l border-gray-200/70 dark:border-slate-800">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-800 dark:text-slate-200">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400 capitalize">{{ str_replace('_', ' ', $role) }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-md bg-gray-100 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center justify-center text-gray-600 dark:text-slate-300 font-bold uppercase shadow-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 sm:p-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="relative flex items-center justify-between p-4 mb-6 text-sm text-green-700 border border-green-200 rounded-lg bg-green-50 shadow-sm" role="alert">
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
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition.duration.500ms class="relative flex items-center justify-between p-4 mb-6 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50 shadow-sm" role="alert">
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
