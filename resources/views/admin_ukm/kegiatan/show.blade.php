@extends('layouts.admin_ukm')
@section('title', 'Detail Kegiatan')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-gray-500 mb-2">
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="hover:text-indigo-600">Kegiatan</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Detail</span>
    </div>
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $kegiatan->nama_kegiatan }}</h1>
            <div class="flex gap-4 mt-2 text-sm text-gray-600">
                <span><i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</span>
                <span><i class="fa-regular fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($kegiatan->waktu)->format('H:i') }} WIB</span>
                <span><i class="fa-solid fa-location-dot mr-1"></i> {{ $kegiatan->lokasi }}</span>
            </div>
        </div>
        <span class="px-4 py-2 rounded-full text-sm font-bold shadow-sm 
            {{ $kegiatan->status == 'Direncanakan' ? 'bg-yellow-100 text-yellow-800' : 
              ($kegiatan->status == 'Berjalan' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
            {{ $kegiatan->status }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Progress Section -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Progress Pelaksanaan</h3>
            
            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-bold text-gray-700">Realisasi Anggaran</span>
                    <span class="text-sm text-gray-500">Rp {{ number_format($kegiatan->realisasi_anggaran, 0, ',', '.') }} / Rp {{ number_format($kegiatan->anggaran, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $persenAnggaran }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ number_format($persenAnggaran, 1) }}% Tercapai</p>
            </div>

            <div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-bold text-gray-700">Pendaftaran Peserta</span>
                    <span class="text-sm text-gray-500">{{ $kegiatan->jumlah_pendaftar }} / {{ $kegiatan->target_peserta }} Orang</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $persenPeserta }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ number_format($persenPeserta, 1) }}% Memenuhi Target</p>
            </div>
        </div>

        <!-- Dokumen Section -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Dokumen Kegiatan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center text-xl mb-3">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Proposal Kegiatan</h4>
                    <p class="text-xs text-gray-500 mb-3">Format .pdf maksimal 5MB</p>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm w-full">Upload Proposal</button>
                </div>
                
                <div class="border border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-center hover:bg-gray-50 transition">
                    <div class="w-12 h-12 bg-green-50 text-green-500 rounded-full flex items-center justify-center text-xl mb-3">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Laporan Kegiatan (LPJ)</h4>
                    <p class="text-xs text-gray-500 mb-3">Format .pdf maksimal 10MB</p>
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm w-full">Upload LPJ</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Approval -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Riwayat Persetujuan</h3>
        
        <ol class="relative border-l border-gray-200 ml-3">
            <li class="mb-6 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-indigo-100 rounded-full -left-3 ring-4 ring-white text-indigo-600">
                    <i class="fa-solid fa-check text-xs"></i>
                </span>
                <h3 class="font-bold text-gray-800">Draft Dibuat</h3>
                <time class="block mb-1 text-xs font-normal leading-none text-gray-400">Oleh {{ $kegiatan->pic_nama }}</time>
                <p class="text-xs text-gray-500 mt-1">Proposal kegiatan telah dibuat di sistem.</p>
            </li>
            <li class="mb-6 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -left-3 ring-4 ring-white text-gray-400">
                    <i class="fa-solid fa-hourglass-half text-xs"></i>
                </span>
                <h3 class="font-bold text-gray-500">Review BEM</h3>
                <time class="block mb-1 text-xs font-normal leading-none text-gray-400">Menunggu</time>
            </li>
            <li class="mb-6 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -left-3 ring-4 ring-white text-gray-400">
                    <i class="fa-solid fa-hourglass-half text-xs"></i>
                </span>
                <h3 class="font-bold text-gray-500">Review BPM</h3>
                <time class="block mb-1 text-xs font-normal leading-none text-gray-400">Menunggu</time>
            </li>
            <li class="ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -left-3 ring-4 ring-white text-gray-400">
                    <i class="fa-solid fa-hourglass-half text-xs"></i>
                </span>
                <h3 class="font-bold text-gray-500">Super Admin (Final)</h3>
                <time class="block mb-1 text-xs font-normal leading-none text-gray-400">Menunggu</time>
            </li>
        </ol>
    </div>
</div>
@endsection
