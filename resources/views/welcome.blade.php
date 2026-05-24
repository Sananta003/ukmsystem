<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal UKM Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; } 
    </style>
</head>
<body class="bg-slate-50 flex flex-col min-h-screen">

    <div class="bg-blue-600 text-white text-xs sm:text-sm py-2 px-4 text-center fixed w-full z-[60] font-medium tracking-wide shadow-sm">
        <i class="fa-solid fa-bullhorn mr-2"></i> Pusat Informasi dan Pendaftaran Unit Kegiatan Mahasiswa (UKM) Resmi Kampus
    </div>

    <nav class="bg-white border-b border-gray-100 fixed w-full z-50 top-8 sm:top-9">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logopnc.png') }}" alt="Logo Kampus" class="h-10 w-auto object-contain">
                    <div class="hidden sm:flex flex-col border-l-2 border-gray-100 pl-3">
                        <span class="font-bold text-lg text-slate-800 leading-none">Portal SIM-UKM</span>
                        <span class="text-xs text-slate-500 mt-1 font-medium">Wadah Pengembangan Minat & Bakat</span>
                    </div>
                </a>

                <div>
                    @auth
                        @if(Auth::user()->role === 'super_admin')
                            <a href="{{ route('superadmin.dashboard') }}" class="text-gray-600 hover:text-purple-600 font-medium mr-4">Pusat Komando</a>
                        @elseif(Auth::user()->role === 'admin_ukm')
                            <a href="{{ route('admin-ukm.dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium mr-4">Dashboard Admin</a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium mr-4">Portal Member</a>
                        @endif
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium mr-6 transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">Daftar Anggota</a>
                    @endauth
                </div>
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
                    <span class="text-slate-900 mt-2 block">Bersama SIM-UKM</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 max-w-3xl mx-auto mb-14 font-light leading-relaxed">
                    Portal resmi dan terpadu untuk pendaftaran serta informasi seluruh Unit Kegiatan Mahasiswa (UKM). Kembangkan potensimu, temukan relasi baru, dan jadilah bagian dari perubahan.
                </p>

                <!-- Interactive Pill/Card Buttons -->
                <div class="flex flex-col sm:flex-row justify-center items-center gap-6 mt-8">
                    
                    <!-- Eksplorasi UKM -->
                    <a href="{{ route('ukm.explore') }}" class="group relative px-8 py-4 bg-white/70 backdrop-blur-md border border-gray-100 rounded-2xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 w-full sm:w-auto flex flex-col items-center justify-center">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <div class="relative flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-compass text-lg"></i>
                            </div>
                            <div class="text-left">
                                <span class="block text-slate-800 font-bold text-lg leading-tight">Eksplorasi UKM</span>
                                <span class="block text-blue-600 text-xs font-semibold mt-1 bg-blue-50 px-2 py-0.5 rounded-md inline-block">{{ $total_ukm }} UKM Aktif</span>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Daftar UKM Baru -->
                    <a href="{{ route('pengajuan.create') }}" class="group relative px-8 py-4 bg-white/70 backdrop-blur-md border border-gray-100 rounded-2xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 w-full sm:w-auto flex flex-col items-center justify-center">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <div class="relative flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-rocket text-lg"></i>
                            </div>
                            <div class="text-left">
                                <span class="block text-slate-800 font-bold text-lg leading-tight">Inisiasi UKM</span>
                                <span class="block text-slate-500 text-xs mt-1">Daftarkan UKM Baru</span>
                            </div>
                        </div>
                    </a>

                    <!-- Saran UKM -->
                    <a href="#" class="group relative px-8 py-4 bg-white/70 backdrop-blur-md border border-gray-100 rounded-2xl shadow-xl hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 w-full sm:w-auto flex flex-col items-center justify-center">
                        <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-300"></div>
                        <div class="relative flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-regular fa-comment-dots text-lg"></i>
                            </div>
                            <div class="text-left">
                                <span class="block text-slate-800 font-bold text-lg leading-tight">Beri Masukan</span>
                                <span class="block text-slate-500 text-xs mt-1">Saran untuk Portal</span>
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