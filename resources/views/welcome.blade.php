<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal UKM Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; } 
    </style>
    <script>
        // FOUC prevention for dark mode
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        tailwind.config = { darkMode: 'class' };
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-900 flex flex-col min-h-screen transition-colors duration-500" x-data="{ mobileMenuOpen: false, darkMode: document.documentElement.classList.contains('dark') }" x-init="$watch('darkMode', val => { if(val){ document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">

    <div class="bg-blue-600 text-white text-xs sm:text-sm py-2 px-4 text-center fixed w-full z-[60] font-medium tracking-wide shadow-sm">
        <i class="fa-solid fa-bullhorn mr-2"></i> Pusat Informasi dan Pendaftaran Unit Kegiatan Mahasiswa (UKM) Resmi Kampus
    </div>

    <nav class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-gray-100 dark:border-slate-800 fixed w-full z-50 top-8 sm:top-9 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logopnc.png') }}" alt="Logo Kampus" class="h-10 w-auto object-contain">
                    <div class="hidden sm:flex flex-col border-l-2 border-gray-100 dark:border-slate-700 pl-3">
                        <span class="font-bold text-lg text-slate-800 dark:text-slate-100 leading-none">Portal SIM-UKM</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Wadah Pengembangan Minat & Bakat</span>
                    </div>
                </a>

                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition-all shadow-inner">
                        <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                    </button>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center">
                        @auth
                            @if(Auth::user()->role === 'super_admin')
                                <a href="{{ route('superadmin.dashboard') }}" class="text-gray-600 dark:text-slate-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium mr-4 transition">Pusat Komando</a>
                            @elseif(Auth::user()->role === 'admin_ukm')
                                <a href="{{ route('admin-ukm.dashboard') }}" class="text-gray-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium mr-4 transition">Dashboard Admin</a>
                            @else
                                <a href="{{ route('member.dashboard') }}" class="text-gray-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium mr-4 transition">Portal Member</a>
                            @endif
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/50 transition">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium mr-6 transition">Login</a>
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">Daftar Anggota</a>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none">
                        <i class="fa-solid text-2xl" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-transition.opacity style="display: none;" class="md:hidden bg-white dark:bg-slate-900 border-b border-gray-100 dark:border-slate-800 shadow-lg absolute w-full left-0 top-full">
            <div class="px-4 pt-4 pb-6 space-y-4">
                @auth
                    @if(Auth::user()->role === 'super_admin')
                        <a href="{{ route('superadmin.dashboard') }}" class="block text-gray-800 dark:text-slate-200 hover:text-purple-600 font-medium text-lg">Pusat Komando</a>
                    @elseif(Auth::user()->role === 'admin_ukm')
                        <a href="{{ route('admin-ukm.dashboard') }}" class="block text-gray-800 dark:text-slate-200 hover:text-blue-600 font-medium text-lg">Dashboard Admin</a>
                    @else
                        <a href="{{ route('member.dashboard') }}" class="block text-gray-800 dark:text-slate-200 hover:text-blue-600 font-medium text-lg">Portal Member</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="block w-full">
                        @csrf
                        <button type="submit" class="w-full text-left bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg text-base font-medium hover:bg-red-100 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-center text-gray-800 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-800 px-4 py-3 rounded-lg font-medium border border-gray-200 dark:border-slate-700">Login</a>
                    <a href="{{ route('register') }}" class="block text-center bg-blue-600 text-white px-4 py-3 rounded-lg font-medium shadow-sm">Daftar Anggota</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow flex items-center justify-center pt-24 pb-12 min-h-[85vh] relative overflow-hidden">
        
        <!-- Background Ornaments (Glassmorphism & Gradients) -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-[20%] right-[10%] w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 4s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center">
            
            <div class="py-12 lg:py-20 animate-[fade-in-up_1s_ease-out]">
                <!-- Huge Gradient Text -->
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold tracking-tight mb-6">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 drop-shadow-sm">
                        Eksplorasi Bakatmu
                    </span>
                    <br>
                    <span class="text-slate-900 dark:text-white mt-2 block transition-colors">Bersama SIM-UKM</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto mb-14 font-light leading-relaxed transition-colors">
                    Portal resmi dan terpadu untuk pendaftaran serta informasi seluruh Unit Kegiatan Mahasiswa (UKM). Kembangkan potensimu, temukan relasi baru, dan jadilah bagian dari perubahan.
                </p>

                <!-- Interactive Pill/Card Buttons -->
                <div class="flex flex-col md:flex-row justify-center items-stretch gap-6 mt-8">
                    
                    <!-- Eksplorasi UKM -->
                    <a href="{{ route('ukm.explore') }}" class="group relative px-6 py-5 bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-gray-100 dark:border-slate-700 rounded-2xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 w-full md:w-auto flex flex-col items-center justify-center">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <div class="relative flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                            <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                                <i class="fa-solid fa-compass text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-slate-800 dark:text-slate-100 font-bold text-lg leading-tight transition-colors">Eksplorasi UKM</span>
                                <span class="block text-blue-600 dark:text-blue-400 text-xs font-semibold mt-1 bg-blue-50 dark:bg-blue-900/50 px-2 py-0.5 rounded-md inline-block">{{ $total_ukm }} UKM Aktif</span>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Daftar UKM Baru -->
                    <a href="{{ route('pengajuan.create') }}" class="group relative px-6 py-5 bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-gray-100 dark:border-slate-700 rounded-2xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 w-full md:w-auto flex flex-col items-center justify-center">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <div class="relative flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                            <div class="w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                                <i class="fa-solid fa-rocket text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-slate-800 dark:text-slate-100 font-bold text-lg leading-tight transition-colors">Inisiasi UKM</span>
                                <span class="block text-slate-500 dark:text-slate-400 text-xs mt-1 transition-colors">Daftarkan UKM Baru</span>
                            </div>
                        </div>
                    </a>

                    <!-- Saran UKM -->
                    <a href="#" class="group relative px-6 py-5 bg-white/70 dark:bg-slate-800/70 backdrop-blur-md border border-gray-100 dark:border-slate-700 rounded-2xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 w-full md:w-auto flex flex-col items-center justify-center">
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <div class="relative flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                                <i class="fa-regular fa-comment-dots text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-slate-800 dark:text-slate-100 font-bold text-lg leading-tight transition-colors">Beri Masukan</span>
                                <span class="block text-slate-500 dark:text-slate-400 text-xs mt-1 transition-colors">Saran untuk Portal</span>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </main>

    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <footer class="bg-slate-900 text-slate-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} Portal Mahasiswa. By Sananta Hak Cipta Dilindungi.</p>
             <p class="mt-2">Dibangun dengan Laravel & Tailwind CSS.</p>
        </div>
    </footer>

</body>
</html>