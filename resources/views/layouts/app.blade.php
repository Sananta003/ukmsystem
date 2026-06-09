<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal UKM')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
<body class="bg-gray-50 text-gray-900 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
    
    @php
        $role = Auth::user()->role;
        $ukm = Auth::user()->ukm_id ? \App\Models\Ukm::find(Auth::user()->ukm_id) : null;
        
        $activeClass = 'bg-gray-100 text-gray-900 font-semibold';
        $inactiveClass = 'text-gray-600 hover:bg-gray-50 hover:text-gray-900';
    @endphp

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-gray-900/50 z-40 md:hidden" style="display: none;"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed md:relative z-50 w-64 bg-white border-r border-gray-200 flex flex-col h-full shrink-0 transition-transform duration-200 ease-in-out">
        <div class="flex items-center gap-3 p-6 border-b border-gray-200 h-16 shrink-0">
            @if($ukm && $ukm->logo)
                <div class="w-7 h-7 rounded border border-gray-200 overflow-hidden flex items-center justify-center bg-gray-50">
                    <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-7 h-7 bg-gray-100 border border-gray-200 rounded flex items-center justify-center text-gray-500">
                    <i class="fa-solid fa-layer-group text-xs"></i>
                </div>
            @endif
            <div>
                <h1 class="font-semibold text-sm text-gray-900">{{ $ukm ? $ukm->nama_ukm : 'Portal UKM' }}</h1>
            </div>
        </div>

        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
            @if($role === 'super_admin')
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('superadmin.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-border-all w-4 text-center"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            @elseif(in_array($role, ['bpm', 'bem']))
                <a href="{{ route('birokrasi.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('birokrasi.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-border-all w-4 text-center"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
            @elseif($role === 'admin_ukm')
                <a href="{{ route('admin-ukm.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin-ukm.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-border-all w-4 text-center"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
                <a href="{{ route('admin-ukm.kegiatan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin-ukm.kegiatan.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-calendar w-4 text-center"></i>
                    <span class="text-sm">Kegiatan</span>
                </a>
                <a href="{{ route('admin-ukm.keuangan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin-ukm.keuangan.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-wallet w-4 text-center"></i>
                    <span class="text-sm">Keuangan</span>
                </a>
                <a href="{{ route('admin-ukm.anggota.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin-ukm.anggota.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-users w-4 text-center"></i>
                    <span class="text-sm">Anggota</span>
                </a>
                <div x-data="{ open: {{ request()->routeIs('admin-ukm.laporan.*') || request()->routeIs('admin-ukm.proposal.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin-ukm.laporan.*') || request()->routeIs('admin-ukm.proposal.*') ? $activeClass : $inactiveClass }}">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-alt w-4 text-center"></i>
                            <span class="text-sm">Laporan</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" style="display: none;" class="pl-10 pr-3 pt-1 pb-1 space-y-1">
                        <a href="{{ route('admin-ukm.laporan.index') }}" class="block px-3 py-1.5 rounded-md text-sm transition-colors {{ request()->routeIs('admin-ukm.laporan.index') ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Keuangan</a>
                        <a href="{{ route('admin-ukm.proposal.index') }}" class="block px-3 py-1.5 rounded-md text-sm transition-colors {{ request()->routeIs('admin-ukm.proposal.*') ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Cek Proposal</a>
                    </div>
                </div>
                <a href="{{ route('admin-ukm.pengaturan.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin-ukm.pengaturan.*') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-gear w-4 text-center"></i>
                    <span class="text-sm">Pengaturan</span>
                </a>
            @else
                <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('member.dashboard') || request()->routeIs('inisiator.dashboard') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-house w-4 text-center"></i>
                    <span class="text-sm">Beranda</span>
                </a>
                <a href="{{ route('member.kegiatan') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('member.kegiatan') ? $activeClass : $inactiveClass }}">
                    <i class="fa-regular fa-calendar w-4 text-center"></i>
                    <span class="text-sm">Agenda Kegiatan</span>
                </a>
                <a href="{{ route('member.pengumuman') }}" class="flex items-center gap-3 px-3 py-2 rounded-md transition-colors {{ request()->routeIs('member.pengumuman') ? $activeClass : $inactiveClass }}">
                    <i class="fa-solid fa-bullhorn w-4 text-center"></i>
                    <span class="text-sm">Pengumuman</span>
                </a>
            @endif
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        <div class="p-4 border-t border-gray-200">
            <button onclick="document.getElementById('logout-form').submit();" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors border border-transparent hover:border-gray-200">
                <i class="fa-solid fa-right-from-bracket"></i> Sign out
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden w-full relative bg-gray-50">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-8 shrink-0">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-900 focus:outline-none">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h2 class="font-medium text-gray-900 hidden sm:block text-sm">
                    @yield('title', 'Dashboard')
                </h2>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-gray-900 leading-tight">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-[11px] text-gray-500 uppercase tracking-wider mt-0.5">{{ str_replace('_', ' ', $role) }}</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs font-semibold shadow-sm">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-8">
            <div class="max-w-7xl mx-auto">
                @if (session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="flex items-center justify-between p-4 mb-6 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fa-solid fa-check text-green-600 mr-3"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition class="flex items-center justify-between p-4 mb-6 text-sm text-gray-700 bg-white border border-red-200 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <i class="fa-solid fa-triangle-exclamation text-red-600 mr-3"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

</body>   
</html>
