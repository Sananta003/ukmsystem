<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Anggota')</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    
                    <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3">
                        @if($userUkm && $userUkm->logo)
                            <img src="{{ asset('storage/' . $userUkm->logo) }}" alt="{{ $userUkm->nama_ukm }}" class="w-8 h-8 rounded-lg object-cover border border-gray-200">
                        @else
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-users text-white text-sm"></i>
                            </div>
                        @endif
                        <h1 class="font-bold text-lg text-slate-800 tracking-wide">
                            {{ $userUkm ? $userUkm->nama_ukm : 'Inisiator UKM' }}
                        </h1>
                    </a>
                    
                    <nav class="hidden md:flex space-x-4">
                        <a href="{{ route('member.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('member.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">Beranda</a>
                        <a href="{{ route('member.kegiatan') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('member.kegiatan') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">Agenda Kegiatan</a>
                    </nav>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Anggota</p>
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
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Sistem Manajemen UKM. By Sananta All rights reserved.
        </div>
    </footer>

</body>
</html>