@extends('layouts.admin_ukm')
@section('title', 'Detail Kegiatan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-8">
    <div class="mb-4">
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar Kegiatan
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-start mb-4">
            <h1 class="text-2xl font-bold text-gray-900">{{ $kegiatan->nama ?? 'Workshop UI/UX Design' }}</h1>
            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Direncanakan</span>
        </div>
        <p class="text-gray-600 text-sm leading-relaxed">
            {{ $kegiatan->deskripsi ?? 'Workshop intensif tentang prinsip-prinsip UI/UX Design yang akan membahas dari dasar hingga teknik advanced. Peserta akan belajar cara membuat wireframe, prototype, dan design system yang baik.' }}
        </p>
    </div>

    <!-- Tanggal & Waktu -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fa-regular fa-calendar"></i>
            </div>
            <h2 class="font-bold text-gray-800">Tanggal & Waktu</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Tanggal Mulai</p>
                <p class="font-semibold text-gray-800">20 Feb 2026</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-1">Tanggal Selesai</p>
                <p class="font-semibold text-gray-800">28 Feb 2026</p>
            </div>
        </div>
        <div class="text-sm text-gray-600 flex items-center">
            <i class="fa-regular fa-clock mr-2 text-gray-400"></i> 13:00 - 16:00 WIB
        </div>
    </div>

    <!-- Progress Anggaran -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 rounded bg-green-50 text-green-600 flex items-center justify-center">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <h2 class="font-bold text-gray-800">Progress Anggaran</h2>
        </div>
        
        <div class="flex justify-between items-end mb-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Anggaran</p>
                <p class="text-lg font-bold text-gray-900">Rp 5.000.000</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 mb-1">Realisasi</p>
                <p class="text-lg font-bold text-green-600">Rp 3.200.000</p>
            </div>
        </div>

        <div class="mb-2">
            <div class="flex justify-between text-xs mb-1">
                <span class="text-gray-500 font-medium">Progress Penggunaan</span>
                <span class="font-bold text-gray-700">64%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: 64%"></div>
            </div>
        </div>
        <p class="text-xs text-gray-400">Sisa anggaran: Rp 1.800.000</p>
    </div>

    <!-- Peserta -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-end mb-4">
            <div>
                <p class="text-xs text-gray-500 mb-1">Terdaftar</p>
                <p class="text-lg font-bold text-gray-900">45 orang</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 mb-1">Kapasitas Maksimal</p>
                <p class="text-lg font-bold text-gray-900">60 orang</p>
            </div>
        </div>

        <div class="mb-2">
            <div class="flex justify-between text-xs mb-1">
                <span class="text-gray-500 font-medium">Tingkat Pendaftaran</span>
                <span class="font-bold text-gray-700">75%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
            </div>
        </div>
        <p class="text-xs text-gray-400">Kuota tersisa: 15 orang</p>
    </div>

    <!-- Dokumen -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-8 rounded bg-orange-50 text-orange-600 flex items-center justify-center">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <h2 class="font-bold text-gray-800">Dokumen</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Proposal Kegiatan</p>
                <button type="button" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:border-blue-400 transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-arrow-up-from-bracket mr-2"></i> Upload Proposal
                </button>
                <p class="text-[11px] text-gray-400 mt-2 text-center">PDF, DOC, atau DOCX. Maksimal 5MB.</p>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Laporan Kegiatan</p>
                <button type="button" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:border-blue-400 transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-arrow-up-from-bracket mr-2"></i> Upload Laporan
                </button>
                <p class="text-[11px] text-gray-400 mt-2 text-center">PDF, DOC, atau DOCX. Maksimal 5MB.</p>
            </div>
        </div>
    </div>
</div>
@endsection
