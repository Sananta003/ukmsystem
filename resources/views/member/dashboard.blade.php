@extends('layouts.member')

@section('content')
<div class="max-w-6xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
    
    @if(Auth::user()->ukm_id && $ukm)
        <!-- Header Card (Glassmorphism) -->
        <div class="bg-white/60 backdrop-blur-xl rounded-3xl shadow-xl shadow-indigo-900/5 border border-white/80 p-8 sm:p-10 mb-8 relative overflow-hidden group hover:shadow-2xl hover:shadow-indigo-900/10 transition-all duration-500 hover:-translate-y-1">
            <!-- Decorative Glow -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-gradient-to-br from-blue-400 to-purple-400 rounded-full mix-blend-multiply filter blur-[80px] opacity-40 -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-700"></div>

            <div class="relative flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- UKM Logo -->
                <div class="w-28 h-28 rounded-[2rem] bg-white/80 backdrop-blur-md border-2 border-white flex items-center justify-center overflow-hidden shadow-lg shadow-indigo-200 flex-shrink-0 group-hover:scale-105 group-hover:rotate-3 transition-all duration-500">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/'.$ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-users text-5xl text-blue-400 bg-clip-text text-transparent bg-gradient-to-br from-blue-500 to-purple-500"></i>
                    @endif
                </div>

                <div class="text-center md:text-left flex-1">
                    <span class="bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 border border-blue-200/60 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-3 inline-block shadow-sm">
                        <i class="fa-solid fa-star text-amber-500 mr-1"></i> Member Aktif
                    </span>
                    <h1 class="text-4xl sm:text-5xl font-black mb-3 bg-clip-text text-transparent bg-gradient-to-r from-blue-700 via-indigo-700 to-violet-700 drop-shadow-sm">
                        Dashboard {{ $ukm->nama_ukm }}
                    </h1>
                    <p class="text-slate-600 leading-relaxed max-w-3xl text-lg font-medium">{{ $ukm->deskripsi }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Welcome Area -->
            <div class="lg:col-span-2 bg-white/60 backdrop-blur-xl rounded-3xl shadow-xl shadow-indigo-900/5 border border-white/80 p-8 hover:shadow-2xl hover:shadow-indigo-900/10 transition-all duration-500 hover:-translate-y-1 relative overflow-hidden">
                <!-- Subtle background accent -->
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-300 rounded-full mix-blend-multiply filter blur-[60px] opacity-20"></div>
                
                <h2 class="text-2xl font-extrabold text-slate-800 mb-4 relative z-10 flex items-center gap-3">
                    Halo, <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-violet-600">{{ Auth::user()->name }}</span>! <span class="animate-bounce inline-block origin-bottom">👋</span>
                </h2>
                <p class="text-slate-600 text-lg mb-8 relative z-10 leading-relaxed">
                    Ini adalah ruang kreatif khusus untuk anggota <strong class="text-indigo-600">{{ $ukm->nama_ukm }}</strong>. Jelajahi kegiatan mendatang dan terus asah potensi Anda bersama kami.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10">
                    <a href="{{ route('member.kegiatan') }}" class="group bg-gradient-to-br from-white to-blue-50 border border-blue-100 rounded-2xl p-5 flex items-center gap-4 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                            <i class="fa-solid fa-calendar-days text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-blue-700 transition-colors">Lihat Agenda</h4>
                            <p class="text-xs text-slate-500 font-medium">Jadwal kegiatan UKM</p>
                        </div>
                    </a>
                    
                    <!-- Link Pengumuman -->
                    <a href="{{ route('member.pengumuman') }}" class="group bg-gradient-to-br from-white to-purple-50 border border-purple-100 rounded-2xl p-5 flex items-center gap-4 hover:shadow-lg hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300 shadow-inner">
                            <i class="fa-solid fa-bullhorn text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-purple-700 transition-colors">Pengumuman</h4>
                            <p class="text-xs text-slate-500 font-medium">Info terbaru dari pengurus</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Jadwal Terdekat (Gradient Card) -->
            <div class="bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700 rounded-3xl shadow-2xl shadow-indigo-600/30 p-8 text-white text-center flex flex-col justify-center h-full relative overflow-hidden group hover:-translate-y-2 transition-all duration-500 border border-white/20">
                <!-- Glossy overlay -->
                <div class="absolute inset-0 bg-gradient-to-b from-white/20 to-transparent opacity-50"></div>
                <div class="absolute top-0 right-0 w-40 h-40 bg-white rounded-full filter blur-[50px] opacity-10 group-hover:opacity-20 transition-opacity"></div>

                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500 shadow-inner">
                        <i class="fa-regular fa-calendar-check text-4xl text-white"></i>
                    </div>
                    
                    <h3 class="text-xl font-extrabold mb-3 tracking-wide">Jadwal Terdekat</h3>
                    
                    @if($kegiatanTerdekat)
                        <div class="bg-black/10 backdrop-blur-sm rounded-2xl p-5 w-full border border-white/10 shadow-inner mb-6">
                            <p class="text-white font-bold text-lg mb-2 leading-tight">{{ $kegiatanTerdekat->nama_kegiatan }}</p>
                            <div class="flex flex-col gap-2 text-indigo-100 text-sm font-medium">
                                <span class="flex items-center justify-center gap-2"><i class="fa-regular fa-clock opacity-70"></i> {{ \Carbon\Carbon::parse($kegiatanTerdekat->tanggal)->format('d M Y') }}</span>
                                @if($kegiatanTerdekat->lokasi) 
                                    <span class="flex items-center justify-center gap-2"><i class="fa-solid fa-location-dot opacity-70"></i> {{ $kegiatanTerdekat->lokasi }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('member.kegiatan') }}" class="w-full py-3.5 bg-white text-indigo-700 font-extrabold text-sm rounded-xl hover:bg-indigo-50 hover:shadow-lg hover:shadow-white/20 transition-all duration-300 hover:scale-[1.02]">
                            Lihat Semua Agenda
                        </a>
                    @else
                        <div class="bg-black/10 backdrop-blur-sm rounded-2xl p-6 w-full border border-white/10">
                            <p class="text-indigo-100 text-sm font-medium">Wah, sedang tidak ada agenda dalam waktu dekat. Mari buat inovasi baru!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    @endif

</div>
@endsection