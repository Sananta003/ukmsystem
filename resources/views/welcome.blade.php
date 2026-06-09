<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal SIM-UKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; } 
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen text-slate-900" x-data="{ mobileMenuOpen: false }">

    <!-- Top Alert Bar -->
    <div class="bg-slate-900 text-white text-xs sm:text-sm py-2 px-4 text-center font-medium tracking-wide relative z-50">
        Pusat Informasi dan Pendaftaran Unit Kegiatan Mahasiswa (UKM) Resmi Kampus
    </div>

    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo & Brand -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logopnc.png') }}" alt="Logo Kampus" class="h-9 w-auto object-contain transition-transform group-hover:opacity-90">
                    <div class="hidden sm:flex flex-col border-l border-gray-300 pl-3">
                        <span class="font-bold text-lg leading-none tracking-tight text-slate-900">Portal SIM-UKM</span>
                        <span class="text-xs text-slate-500 mt-1 font-medium">Wadah Pengembangan Minat & Bakat</span>
                    </div>
                </a>

                <div class="flex items-center gap-6">
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center gap-6">
                        @auth
                            @if(Auth::user()->role === 'super_admin')
                                <a href="{{ route('superadmin.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Pusat Komando</a>
                            @elseif(Auth::user()->role === 'admin_ukm')
                                <a href="{{ route('admin-ukm.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Dashboard Admin</a>
                            @else
                                <a href="{{ route('member.dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Portal Member</a>
                            @endif
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 transition-colors">Sign Out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Sign In</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-slate-900 hover:bg-slate-800 shadow-sm transition-colors">
                                Daftar Anggota
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-500 hover:text-slate-900 focus:outline-none p-1">
                        <i class="fa-solid text-xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-transition.opacity style="display: none;" class="md:hidden bg-white border-b border-gray-200 absolute w-full left-0 top-full shadow-lg z-50">
            <div class="px-4 pt-4 pb-6 space-y-3">
                @auth
                    @if(Auth::user()->role === 'super_admin')
                        <a href="{{ route('superadmin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-gray-50">Pusat Komando</a>
                    @elseif(Auth::user()->role === 'admin_ukm')
                        <a href="{{ route('admin-ukm.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-gray-50">Dashboard Admin</a>
                    @else
                        <a href="{{ route('member.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-gray-50">Portal Member</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="block w-full">
                        @csrf
                        <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Sign Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-900 hover:bg-gray-50">Sign In</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 mt-2 border border-transparent text-base font-medium rounded-md text-white bg-slate-900 hover:bg-slate-800">Daftar Anggota</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center pt-24 pb-20 relative overflow-hidden">
        
        <!-- Subtle Background Pattern (Dot Grid) -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-[0.03]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center">
            
            <div class="py-12 lg:py-16 animate-[fade-in-up_1s_ease-out]">
                <!-- Clean Enterprise Typography -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 leading-[1.1]">
                    Eksplorasi Bakatmu <br class="hidden sm:block">
                    <span class="text-blue-600">Bersama SIM-UKM</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-500 max-w-3xl mx-auto mb-16 font-normal leading-relaxed">
                    Portal resmi dan terpadu untuk pendaftaran serta informasi seluruh Unit Kegiatan Mahasiswa (UKM). Kembangkan potensimu, temukan relasi baru, dan jadilah bagian dari inovasi kampus.
                </p>

                <!-- Enterprise Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto text-left">
                    
                    <!-- Eksplorasi UKM -->
                    <a href="{{ route('ukm.explore') }}" class="group block bg-white border border-slate-200 rounded-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50 hover:border-slate-300">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-compass text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg mb-1 group-hover:text-blue-600 transition-colors">Eksplorasi UKM</h3>
                                <p class="text-sm text-slate-500 leading-snug mb-3">Temukan UKM yang sesuai dengan minat dan bakatmu.</p>
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-semibold text-slate-700 bg-slate-100 rounded">
                                    {{ $total_ukm }} UKM Aktif
                                </span>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Daftar UKM Baru -->
                    <a href="{{ route('pengajuan.create') }}" class="group block bg-white border border-slate-200 rounded-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50 hover:border-slate-300">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-rocket text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg mb-1 group-hover:text-slate-700 transition-colors">Inisiasi UKM</h3>
                                <p class="text-sm text-slate-500 leading-snug">Ajukan proposal pembentukan UKM baru di kampus.</p>
                            </div>
                        </div>
                    </a>

                    <!-- Saran UKM -->
                    <a href="{{ route('masukan.create') }}" class="group block bg-white border border-slate-200 rounded-xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50 hover:border-slate-300">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                                <i class="fa-regular fa-comment-dots text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg mb-1 group-hover:text-slate-700 transition-colors">Beri Masukan</h3>
                                <p class="text-sm text-slate-500 leading-snug">Kirimkan saran atau kritik untuk pengembangan layanan.</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </main>

    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>

    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} SIM-UKM. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>