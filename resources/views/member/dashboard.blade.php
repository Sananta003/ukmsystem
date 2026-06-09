@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    
    @if(Auth::user()->ukm_id && $ukm)
        <!-- Welcome Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <x-badge role="member" icon="fa-star">Member Aktif</x-badge>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-3">
                    Halo, {{ Auth::user()->name }}! 👋
                </h1>
                <p class="text-gray-500 dark:text-slate-400 mt-1 text-lg">
                    Selamat datang di ruang kreatif anggota <strong class="text-sky-600 dark:text-sky-400">{{ $ukm->nama_ukm }}</strong>.
                </p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('member.kegiatan') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-lg transition-colors shadow-sm text-sm">
                    <i class="fa-solid fa-calendar-days"></i> Lihat Agenda
                </a>
                <a href="{{ route('member.pengumuman') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition-colors shadow-sm text-sm">
                    <i class="fa-solid fa-bullhorn text-sky-500"></i> Pengumuman
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- UKM Info Card -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 p-6 flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-24 h-24 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden flex-shrink-0 bg-gray-50 flex items-center justify-center">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/'.$ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-users text-3xl text-gray-400"></i>
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $ukm->nama_ukm }}</h2>
                    <p class="text-gray-600 dark:text-slate-400 leading-relaxed text-sm">
                        {{ $ukm->deskripsi }}
                    </p>
                </div>
            </div>
            
            <!-- Jadwal Terdekat Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 p-6 flex flex-col h-full">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-sky-50 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 flex items-center justify-center">
                        <i class="fa-regular fa-calendar-check text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Jadwal Terdekat</h3>
                </div>
                
                <div class="flex-1 flex flex-col justify-center">
                    @if($kegiatanTerdekat)
                        <div class="bg-gray-50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-lg p-4 mb-4">
                            <h4 class="font-bold text-gray-900 dark:text-white text-base mb-2">{{ $kegiatanTerdekat->nama_kegiatan }}</h4>
                            <div class="space-y-1.5">
                                <p class="text-sm text-gray-500 dark:text-slate-400 flex items-center gap-2">
                                    <i class="fa-regular fa-clock w-4"></i> {{ \Carbon\Carbon::parse($kegiatanTerdekat->tanggal)->format('d M Y') }}
                                </p>
                                @if($kegiatanTerdekat->lokasi) 
                                <p class="text-sm text-gray-500 dark:text-slate-400 flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot w-4"></i> {{ $kegiatanTerdekat->lokasi }}
                                </p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <i class="fa-regular fa-calendar-xmark text-4xl text-gray-300 dark:text-slate-600 mb-3"></i>
                            <p class="text-sm text-gray-500 dark:text-slate-400">Belum ada agenda terdekat.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    @endif

</div>
@endsection
