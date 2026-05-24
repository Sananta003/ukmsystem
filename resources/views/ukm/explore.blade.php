<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksplorasi UKM - Portal Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen relative overflow-x-hidden">

    <!-- Background Ornaments -->
    <div class="fixed top-[-20%] left-[-10%] w-[800px] h-[800px] bg-blue-300 rounded-full mix-blend-multiply filter blur-[120px] opacity-20 -z-10 animate-pulse"></div>
    <div class="fixed bottom-[-20%] right-[-10%] w-[800px] h-[800px] bg-purple-300 rounded-full mix-blend-multiply filter blur-[120px] opacity-20 -z-10 animate-pulse" style="animation-delay: 2s;"></div>

    <!-- Navbar Minimalis -->
    <nav class="bg-white/70 backdrop-blur-md border-b border-white/50 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <span class="font-bold text-slate-800">Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-12 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Eksplorasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">UKM Pilihanmu</span>
                </h1>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Temukan wadah terbaik untuk mengembangkan minat, bakat, dan relasi di kampus.
                </p>
            </div>

            @if($ukms->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($ukms as $ukm)
                    <!-- Card 3D Anti-Flat -->
                    <div class="group relative bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-300 overflow-hidden flex flex-col z-10">
                        
                        <!-- Gradient Overlay sangat pudar di atas -->
                        <div class="absolute inset-0 bg-gradient-to-b from-blue-50/50 to-transparent h-32 opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></div>
                        
                        <div class="p-8 flex-grow">
                            <!-- Header Card: Logo & Info Anggota -->
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-20 h-20 rounded-2xl bg-white border border-gray-100 shadow-md flex items-center justify-center overflow-hidden z-10 group-hover:scale-105 transition-transform duration-300">
                                    @if($ukm->logo)
                                        <img src="{{ asset('storage/'.$ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-users text-3xl text-blue-400"></i>
                                    @endif
                                </div>
                                <div class="bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-full flex items-center gap-2">
                                    <span class="relative flex h-2.5 w-2.5">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                                    </span>
                                    <span class="text-xs font-bold text-blue-700">{{ $ukm->users_count }} Anggota</span>
                                </div>
                            </div>
                            
                            <!-- Konten Card -->
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $ukm->nama_ukm }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-6">{{ $ukm->deskripsi }}</p>

                            <!-- Gambar Kegiatan Preview -->
                            @if($ukm->foto_kegiatan)
                                <div class="w-full h-36 rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-inner">
                                    <img src="{{ asset('storage/' . $ukm->foto_kegiatan) }}" alt="Foto Kegiatan" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                </div>
                            @else
                                <div class="w-full h-36 rounded-2xl overflow-hidden bg-slate-50 border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400">
                                    <i class="fa-regular fa-image mb-2 text-3xl opacity-50"></i>
                                    <span class="text-xs font-medium">Preview belum tersedia</span>
                                </div>
                            @endif
                        </div>

                        <!-- Footer Card: Tombol Gabung Glowing -->
                        <div class="p-6 pt-0 mt-auto">
                            <a href="{{ route('register', ['ukm_id' => $ukm->id]) }}" class="block w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all duration-300 relative overflow-hidden group/btn">
                                <span class="relative z-10 flex items-center justify-center gap-2">Gabung Sekarang <i class="fa-solid fa-arrow-right text-sm"></i></span>
                                <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover/btn:animate-[shimmer_1s_infinite]"></div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-2xl mx-auto">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada UKM</h3>
                    <p class="text-gray-500">Saat ini belum ada Unit Kegiatan Mahasiswa yang terdaftar dan aktif di sistem.</p>
                </div>
            @endif

        </div>
    </main>

    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>
</body>
</html>
