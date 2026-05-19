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

    <main class="flex-grow pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center py-12 lg:py-20">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Temukan dan Kembangkan <br> <span class="text-blue-600">Bakatmu Disini</span>
                </h1>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-10">
                    Portal resmi pendaftaran dan informasi Unit Kegiatan Mahasiswa (UKM). Bergabunglah dengan ratusan mahasiswa lainnya dalam kegiatan yang membangun.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                    <a href="#daftar-ukm" class="px-8 py-3.5 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                        Eksplorasi UKM
                    </a>
                    
                    @auth
                        @if(Auth::user()->role === 'super_admin')
                            <a href="{{ route('superadmin.dashboard') }}" class="px-8 py-3.5 bg-purple-600 text-white font-bold rounded-xl hover:bg-purple-700 transition-colors shadow-lg shadow-purple-200 flex items-center justify-center">Lanjut ke Pusat Komando &rarr;</a>
                        @elseif(Auth::user()->role === 'admin_ukm')
                            <a href="{{ route('admin-ukm.dashboard') }}" class="px-8 py-3.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center justify-center">Lanjut ke Dashboard &rarr;</a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="px-8 py-3.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center justify-center">Masuk ke Portal Member &rarr;</a>
                        @endif
                    @else
                        <a href="{{ route('pengajuan.create') }}" class="px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 flex items-center justify-center">
                            <i class="fa-solid fa-rocket mr-2"></i> Ajukan Pendirian UKM Baru
                        </a>
                    @endauth
                </div>
            </div>

            <div id="daftar-ukm" class="mb-8 scroll-mt-32">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Daftar UKM Terdaftar</h2>
                
                @if($ukms->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($ukms as $ukm)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
                            <div class="p-6 flex-grow">
                                <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center overflow-hidden mb-4">
                                    @if($ukm->logo)
                                        <img src="{{ asset('storage/'.$ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-users text-2xl text-gray-400"></i>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $ukm->nama_ukm }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-3 mb-4">{{ $ukm->deskripsi }}</p>

                                @if($ukm->foto_kegiatan)
                                    <div class="w-full h-32 rounded-lg overflow-hidden bg-gray-100 mt-4 border border-gray-200">
                                        <img src="{{ asset('storage/' . $ukm->foto_kegiatan) }}" alt="Foto Kegiatan {{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-full h-32 rounded-lg overflow-hidden bg-gray-50 mt-4 border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-image mb-2 text-2xl"></i>
                                        <span class="text-xs">Belum ada foto</span>
                                    </div>
                                @endif
                            </div>
                            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t border-gray-50 mt-auto">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider"><i class="fa-solid fa-user-group mr-1"></i> {{ $ukm->users_count }} Anggota</span>
                                <a href="{{ route('register', ['ukm' => $ukm->id]) }}" class="text-blue-600 text-sm font-semibold hover:text-blue-800">Gabung UKM &rarr;</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-2xl border border-gray-100 border-dashed">
                        <i class="fa-solid fa-box-open text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada UKM yang didaftarkan oleh pihak kampus.</p>
                    </div>
                @endif
            </div>

        </div>
    </main>

    <footer class="bg-slate-900 text-slate-400 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} Portal Mahasiswa. By Sananta Hak Cipta Dilindungi.</p>
             <p class="mt-2">Dibangun dengan Laravel & Tailwind CSS.</p>
        </div>
    </footer>

</body>
</html>