<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pusat Komando Kampus')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // FOUC prevention for dark mode
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'brand-primary': '#1e293b',
                        'brand-secondary': '#8b5cf6',
                        'brand-accent': '#3b82f6'
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
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 flex h-screen overflow-hidden transition-colors duration-300" x-data="{ sidebarOpen: false, darkMode: document.documentElement.classList.contains('dark') }" x-init="$watch('darkMode', val => { if(val){ document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">
    
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black/60 z-40 md:hidden backdrop-blur-sm" style="display: none;"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" class="fixed md:relative z-50 w-64 bg-brand-primary dark:bg-slate-950 text-white flex flex-col h-full shrink-0 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-3 p-6 border-b border-white/10">
            <div class="w-10 h-10 bg-gradient-to-r from-violet-700 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-violet-600/40">
                <img src="{{ asset('images/logopnc.png') }}" alt="Logo PNC" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="font-bold text-sm tracking-wide">Pusat Kampus</h1>
                <p class="text-[10px] text-slate-400">Super Admin Panel</p>
            </div>
        </div>

        <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
            <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all {{ request()->routeIs('superadmin.dashboard') ? 'bg-gradient-to-r from-violet-700 to-indigo-600 text-white shadow-md shadow-violet-600/40' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
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

    <main class="flex-1 flex flex-col h-full overflow-hidden w-full relative">
        <header class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border-b border-gray-200 dark:border-slate-700 h-16 flex items-center justify-between px-4 sm:px-8 shrink-0 transition-colors duration-300">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="md:hidden text-gray-500 hover:text-brand-accent dark:text-slate-400 dark:hover:text-blue-400 focus:outline-none transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="font-bold text-gray-800 dark:text-slate-200 hidden sm:block">Administrator Kampus</h2>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-6">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="w-10 h-10 rounded-full flex items-center justify-center bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-violet-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <div class="flex items-center gap-3 pl-3 sm:pl-6 border-l border-gray-200 dark:border-slate-700">
                    <span class="text-xs font-bold text-violet-700 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/30 px-2 py-0.5 rounded">SA</span>
                    <span class="text-sm font-medium text-gray-600 dark:text-slate-300 hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
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