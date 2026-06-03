@extends('layouts.member')

@section('content')
<div class="max-w-6xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
    
    @if(Auth::user()->ukm_id && $ukm)
        <!-- Header Card (Glassmorphism) -->
        <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl shadow-lg border border-white/60 dark:border-slate-700/80 p-8 sm:p-10 mb-8 relative overflow-hidden group transition-all duration-300 hover:-translate-y-1 hover:brightness-110">
            <!-- Decorative Glow -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-gradient-to-br from-sky-400 to-amber-400 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[80px] opacity-40 -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-700"></div>

            <div class="relative flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- UKM Logo -->
                <div class="w-28 h-28 rounded-[2rem] bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-white/60 dark:border-slate-700 flex items-center justify-center overflow-hidden shadow-lg flex-shrink-0 group-hover:scale-105 group-hover:rotate-3 transition-all duration-500">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/'.$ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-users text-5xl text-sky-400 bg-clip-text text-transparent bg-gradient-to-br from-sky-500 to-amber-500"></i>
                    @endif
                </div>

                <div class="text-center md:text-left flex-1">
                    <span class="bg-gradient-to-r from-blue-400 to-sky-300 dark:from-blue-600 dark:to-sky-500 text-white border border-white/60 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-3 inline-block shadow-lg transition-all duration-300 hover:-translate-y-1 hover:brightness-110">
                        <i class="fa-solid fa-star text-amber-500 mr-1"></i> Member Aktif
                    </span>
                    <h1 class="text-4xl sm:text-5xl font-black mb-3 text-blue-500 drop-shadow-sm">
                        Dashboard {{ $ukm->nama_ukm }}
                    </h1>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed max-w-3xl text-lg font-medium">{{ $ukm->deskripsi }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Welcome Area -->
            <div class="lg:col-span-2 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl shadow-lg border border-white/60 dark:border-slate-700/80 p-8 transition-all duration-300 hover:-translate-y-1 hover:brightness-110 relative overflow-hidden">
                <!-- Subtle background accent -->
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-amber-300 dark:bg-amber-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[60px] opacity-20"></div>
                
                <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 mb-4 relative z-10 flex items-center gap-3">
                    Halo, <span class="text-blue-500">{{ Auth::user()->name }}</span>! <span class="animate-bounce inline-block origin-bottom">👋</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-300 text-lg mb-8 relative z-10 leading-relaxed">
                    Ini adalah ruang kreatif khusus untuk anggota <strong class="text-blue-500">{{ $ukm->nama_ukm }}</strong>. Jelajahi kegiatan mendatang dan terus asah potensi Anda bersama kami.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10">
                    <a href="{{ route('member.kegiatan') }}" class="group bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-white/60 dark:border-slate-600 rounded-2xl p-5 flex items-center gap-4 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:brightness-110">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-400 to-sky-300 text-white flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300 shadow-md">
                            <i class="fa-solid fa-calendar-days text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-sky-700 dark:group-hover:text-sky-400 transition-colors">Lihat Agenda</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Jadwal kegiatan UKM</p>
                        </div>
                    </a>
                    
                    <!-- Link Pengumuman -->
                    <a href="{{ route('member.pengumuman') }}" class="group bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-white/60 dark:border-slate-600 rounded-2xl p-5 flex items-center gap-4 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:brightness-110">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-400 to-sky-300 text-white flex items-center justify-center group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300 shadow-md">
                            <i class="fa-solid fa-bullhorn text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-amber-700 dark:group-hover:text-amber-400 transition-colors">Pengumuman</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Info terbaru dari pengurus</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Jadwal Terdekat -->
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl shadow-lg border border-white/60 dark:border-slate-700/80 p-8 text-slate-800 dark:text-slate-100 flex flex-col justify-center h-full relative overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:brightness-110">

                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-sky-50 dark:bg-slate-800 rounded-2xl border border-blue-100 dark:border-slate-600 flex items-center justify-center mb-6 shadow-inner">
                        <i class="fa-regular fa-calendar-check text-4xl text-blue-500"></i>
                    </div>
                    
                    <h3 class="text-xl font-extrabold mb-3 tracking-wide">Jadwal Terdekat</h3>
                    
                    @if($kegiatanTerdekat)
                        <div class="bg-blue-50 dark:bg-slate-800 rounded-2xl p-5 w-full border border-blue-100 dark:border-slate-700 mb-6">
                            <p class="font-bold text-lg mb-2 leading-tight text-blue-600 dark:text-blue-400">{{ $kegiatanTerdekat->nama_kegiatan }}</p>
                            <div class="flex flex-col gap-2 text-slate-600 dark:text-slate-400 text-sm font-medium">
                                <span class="flex items-center justify-center gap-2"><i class="fa-regular fa-clock opacity-70"></i> {{ \Carbon\Carbon::parse($kegiatanTerdekat->tanggal)->format('d M Y') }}</span>
                                @if($kegiatanTerdekat->lokasi) 
                                    <span class="flex items-center justify-center gap-2"><i class="fa-solid fa-location-dot opacity-70"></i> {{ $kegiatanTerdekat->lokasi }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('member.kegiatan') }}" class="w-full py-3.5 bg-gradient-to-r from-blue-500 to-sky-400 text-white font-extrabold text-sm rounded-xl hover:shadow-lg transition-all duration-300 hover:brightness-110">
                            Lihat Semua Agenda
                        </a>
                    @else
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 w-full border border-slate-100 dark:border-slate-700">
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium text-center">Wah, sedang tidak ada agenda dalam waktu dekat. Mari buat inovasi baru!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    @endif

</div>
@endsection