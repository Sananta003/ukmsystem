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
<body class="bg-gray-50 flex flex-col min-h-screen">

    @php
        $userUkm = Auth::user()->ukm_id ? \App\Models\Ukm::find(Auth::user()->ukm_id) : null;
    @endphp

    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-8">
                    
                    @php
                        $dashboardRoute = in_array(Auth::user()->role, ['super_admin']) ? route('superadmin.dashboard') : (in_array(Auth::user()->role, ['bem', 'bpm']) ? route('birokrasi.dashboard') : (Auth::user()->role === 'admin_ukm' ? route('admin-ukm.dashboard') : (is_null(Auth::user()->ukm_id) ? route('inisiator.dashboard') : route('member.dashboard'))));
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="flex items-center gap-3">
                        @if($userUkm && $userUkm->logo)
                            <img src="{{ asset('storage/' . $userUkm->logo) }}" alt="{{ $userUkm->nama_ukm }}" class="w-8 h-8 rounded-lg object-cover border border-gray-200">
                        @else
                            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-graduation-cap text-white text-sm"></i>
                            </div>
                        @endif
                        <h1 class="font-bold text-lg text-slate-800 tracking-wide">
                            {{ $userUkm ? $userUkm->nama_ukm : (in_array(Auth::user()->role, ['bem', 'bpm']) ? strtoupper(Auth::user()->role) : 'Inisiator UKM') }}
                        </h1>
                    </a>
                    
                    <nav class="hidden md:flex space-x-4">
                        <a href="{{ $dashboardRoute }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('*.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">Beranda</a>
                        
                        @if(Auth::user()->role === 'admin_ukm')
                            <a href="{{ route('admin-ukm.anggota.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin-ukm.anggota.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">Anggota</a>
                            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin-ukm.kegiatan.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">Kegiatan</a>
                            <a href="{{ route('admin-ukm.keuangan.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin-ukm.keuangan.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">Keuangan</a>
                        @elseif(!in_array(Auth::user()->role, ['bem', 'bpm']) && !is_null(Auth::user()->ukm_id))
                            <a href="{{ route('member.kegiatan') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('member.kegiatan') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">Agenda Kegiatan</a>
                        @endif
                    </nav>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->role === 'admin_ukm' ? 'Admin UKM' : (Auth::user()->role === 'member' ? (is_null(Auth::user()->ukm_id) ? 'Inisiator' : 'Anggota') : strtoupper(Auth::user()->role)) }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 w-9 h-9 rounded-full flex items-center justify-center transition-colors" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Sistem Manajemen UKM. By Sananta All rights reserved.
        </div>
    </footer>

</body>
</html>