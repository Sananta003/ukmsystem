@extends('layouts.member')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    @if(Auth::user()->ukm_id && $ukm)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -mr-20 -mt-20"></div>

            <div class="relative flex flex-col md:flex-row items-center md:items-start gap-6">
                <div class="w-24 h-24 rounded-2xl bg-white border-2 border-gray-100 flex items-center justify-center overflow-hidden shadow-sm flex-shrink-0">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/'.$ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-users text-4xl text-gray-300"></i>
                    @endif
                </div>

                <div class="text-center md:text-left">
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Member Aktif</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Dashboard {{ $ukm->nama_ukm }}</h1>
                    <p class="text-gray-600 leading-relaxed max-w-2xl">{{ $ukm->deskripsi }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-1 md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Selamat datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-gray-600 mb-4">Ini adalah ruang khusus untuk anggota {{ $ukm->nama_ukm }}. Anda bisa memantau kegiatan terbaru dan pengumuman dari pengurus di sini.</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-md p-6 text-white text-center flex flex-col justify-center h-full">
                <i class="fa-solid fa-calendar-check text-4xl mb-4 opacity-80"></i>
                <h3 class="text-lg font-bold mb-2">Jadwal Terdekat</h3>
                @if($kegiatanTerdekat)
                    <p class="text-white font-bold text-lg mb-1">{{ $kegiatanTerdekat->nama }}</p>
                    <p class="text-blue-100 text-sm mb-3">
                        <i class="fa-solid fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($kegiatanTerdekat->tanggal)->format('d M Y') }}
                        @if($kegiatanTerdekat->lokasi) <br><i class="fa-solid fa-location-dot mt-2 mr-1"></i> {{ $kegiatanTerdekat->lokasi }} @endif
                    </p>
                    <a href="{{ route('member.kegiatan') }}" class="inline-block px-4 py-2 bg-white text-blue-700 font-bold text-sm rounded-lg hover:bg-blue-50 transition-colors">Lihat Semua</a>
                @else
                    <p class="text-blue-100 text-sm">Belum ada kegiatan yang dijadwalkan dalam waktu dekat.</p>
                @endif
            </div>
        </div>

    @endif

</div>
@endsection