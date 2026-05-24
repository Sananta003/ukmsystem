<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Anggota')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-50 via-purple-50 to-blue-100 flex flex-col min-h-screen selection:bg-purple-200 selection:text-purple-900 relative overflow-x-hidden">

    <!-- Global Background Blobs -->
    <div class="fixed top-[-10%] left-[-10%] w-[500px] h-[500px] bg-purple-300 rounded-full mix-blend-multiply filter blur-[100px] opacity-30 -z-10 animate-pulse"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-blue-300 rounded-full mix-blend-multiply filter blur-[120px] opacity-30 -z-10 animate-pulse" style="animation-delay: 3s;"></div>

    @php
        $userUkm = Auth::user()->ukm_id ? \App\Models\Ukm::find(Auth::user()->ukm_id) : null;
    @endphp

    <header class="bg-white/70 backdrop-blur-xl border-b border-white/60 sticky top-0 z-50 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-8">
                    
                    @php
                        $dashboardRoute = in_array(Auth::user()->role, ['super_admin']) ? route('superadmin.dashboard') : (in_array(Auth::user()->role, ['bem', 'bpm']) ? route('birokrasi.dashboard') : (Auth::user()->role === 'admin_ukm' ? route('admin-ukm.dashboard') : (is_null(Auth::user()->ukm_id) ? route('inisiator.dashboard') : route('member.dashboard'))));
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="flex items-center gap-3 group">
                        @if($userUkm && $userUkm->logo)
                            <div class="w-9 h-9 rounded-xl overflow-hidden border-2 border-white shadow-md group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <img src="{{ asset('storage/' . $userUkm->logo) }}" alt="{{ $userUkm->nama_ukm }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md shadow-indigo-500/30 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <i class="fa-solid fa-graduation-cap text-white text-sm"></i>
                            </div>
                        @endif
                        <h1 class="font-extrabold text-lg bg-clip-text text-transparent bg-gradient-to-r from-blue-700 to-violet-700 tracking-wide">
                            {{ $userUkm ? $userUkm->nama_ukm : (in_array(Auth::user()->role, ['bem', 'bpm']) ? strtoupper(Auth::user()->role) : 'Inisiator UKM') }}
                        </h1>
                    </a>
                    
                    <nav class="hidden md:flex space-x-2">
                        <a href="{{ $dashboardRoute }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('*.dashboard') ? 'bg-gradient-to-r from-blue-600 to-violet-600 text-white shadow-lg shadow-blue-500/30 hover:-translate-y-0.5' : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50/80 hover:-translate-y-0.5' }}">Beranda</a>
                        
                        @if(Auth::user()->role === 'admin_ukm')
                            <a href="{{ route('admin-ukm.anggota.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin-ukm.anggota.*') ? 'bg-gradient-to-r from-blue-600 to-violet-600 text-white shadow-lg shadow-blue-500/30 hover:-translate-y-0.5' : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50/80 hover:-translate-y-0.5' }}">Anggota</a>
                            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin-ukm.kegiatan.*') ? 'bg-gradient-to-r from-blue-600 to-violet-600 text-white shadow-lg shadow-blue-500/30 hover:-translate-y-0.5' : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50/80 hover:-translate-y-0.5' }}">Kegiatan</a>
                            <a href="{{ route('admin-ukm.keuangan.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('admin-ukm.keuangan.*') ? 'bg-gradient-to-r from-blue-600 to-violet-600 text-white shadow-lg shadow-blue-500/30 hover:-translate-y-0.5' : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50/80 hover:-translate-y-0.5' }}">Keuangan</a>
                        @elseif(!in_array(Auth::user()->role, ['bem', 'bpm']) && !is_null(Auth::user()->ukm_id))
                            <a href="{{ route('member.kegiatan') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('member.kegiatan') ? 'bg-gradient-to-r from-blue-600 to-violet-600 text-white shadow-lg shadow-blue-500/30 hover:-translate-y-0.5' : 'text-gray-600 hover:text-blue-700 hover:bg-blue-50/80 hover:-translate-y-0.5' }}">Agenda Kegiatan</a>
                        @endif
                    </nav>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs font-medium text-violet-600">{{ Auth::user()->role === 'admin_ukm' ? 'Admin UKM' : (Auth::user()->role === 'member' ? (is_null(Auth::user()->ukm_id) ? 'Inisiator' : 'Anggota') : strtoupper(Auth::user()->role)) }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-xl flex items-center justify-center bg-white border border-red-100 text-red-500 hover:bg-red-500 hover:text-white hover:border-red-500 hover:shadow-lg hover:shadow-red-500/30 hover:-translate-y-1 transition-all duration-300" title="Keluar">
                            <i class="fa-solid fa-power-off"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 50)">
        
        <!-- Animated Wrapper -->
        <div :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" class="transition-all duration-700 ease-out">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="relative flex items-center justify-between p-4 mb-6 text-sm text-emerald-800 border border-emerald-200/60 rounded-2xl bg-white/80 backdrop-blur-md shadow-lg shadow-emerald-900/5" role="alert">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="relative flex items-center justify-between p-4 mb-6 text-sm text-rose-800 border border-rose-200/60 rounded-2xl bg-white/80 backdrop-blur-md shadow-lg shadow-rose-900/5" role="alert">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-exclamation"></i>
                        </div>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-white/50 backdrop-blur-md border-t border-white/60 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 text-center text-sm text-slate-500 font-medium">
            &copy; {{ date('Y') }} Sistem Manajemen UKM. Didesain dengan <i class="fa-solid fa-heart text-rose-500 mx-1 animate-pulse"></i>
        </div>
    </footer>

</body>
</html>