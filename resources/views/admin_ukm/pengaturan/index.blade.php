@extends('layouts.admin_ukm')
@section('title', 'Pengaturan UKM')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 transition-colors">
    <div class="mb-8 border-b border-gray-100 dark:border-slate-700 pb-6 transition-colors">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Pengaturan Profil UKM</h2>
        <p class="text-gray-500 dark:text-slate-400 mt-1 transition-colors">Kelola informasi publik, logo, dan deskripsi organisasi Anda agar terlihat menarik.</p>
    </div>

    <form action="{{ route('admin-ukm.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-8">
            <!-- Section: Logo UKM -->
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/3">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">Logo Utama</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 transition-colors">Logo ini akan ditampilkan di halaman pendaftaran, dashboard anggota, dan eksplorasi UKM.</p>
                </div>
                <div class="w-full md:w-2/3 flex items-center gap-6">
                    <div class="w-28 h-28 rounded-2xl border-2 border-dashed border-gray-300 dark:border-slate-600 flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-slate-900/50 shrink-0 transition-colors relative group">
                        @if($ukm->logo)
                            <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="w-full h-full object-cover group-hover:opacity-75 transition-opacity" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($ukm->nama_ukm) }}&background=random';">
                        @else
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 dark:text-slate-600"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block mb-2">
                            <span class="sr-only">Pilih Logo UKM</span>
                            <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/40 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/60 transition-colors cursor-pointer">
                        </label>
                        <p class="text-xs text-gray-400 dark:text-slate-500 transition-colors">Format: JPG, PNG. Maksimal 2MB. Disarankan ukuran kotak (1:1).</p>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-slate-700 transition-colors">

            <!-- Section: Informasi Dasar -->
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/3">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">Informasi Dasar</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 transition-colors">Informasi ini akan muncul sebagai identitas utama organisasi.</p>
                </div>
                <div class="w-full md:w-2/3 space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2 transition-colors">Nama UKM <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_ukm" value="{{ $ukm->nama_ukm }}" required class="w-full rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-slate-600 dark:text-white transition-colors">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2 transition-colors">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="4" class="w-full rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-slate-600 dark:text-white transition-colors">{{ $ukm->deskripsi }}</textarea>
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-2 transition-colors">Jelaskan visi, misi, atau gambaran singkat kegiatan UKM Anda kepada calon anggota.</p>
                    </div>
                </div>
            </div>

            <hr class="border-gray-100 dark:border-slate-700 transition-colors">

            <!-- Section: Banner Utama -->
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/3">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">Banner / Foto Kegiatan</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1 transition-colors">Gambar lebar yang akan menjadi daya tarik utama pada halaman profil UKM.</p>
                </div>
                <div class="w-full md:w-2/3">
                    @if(isset($ukm->foto_kegiatan) && $ukm->foto_kegiatan)
                        <div class="w-full h-48 md:h-56 rounded-2xl overflow-hidden border-2 border-gray-200 dark:border-slate-600 mb-4 bg-gray-50 dark:bg-slate-900/50 transition-colors">
                            <img src="{{ asset('storage/' . $ukm->foto_kegiatan) }}" alt="Foto Kegiatan" class="w-full h-full object-cover" onerror="this.style.display='none';">
                        </div>
                    @endif
                    
                    <label class="block mb-2">
                        <span class="sr-only">Pilih Banner UKM</span>
                        <input type="file" name="foto_kegiatan" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/40 dark:file:text-blue-400 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/60 transition-colors cursor-pointer">
                    </label>
                    <p class="text-xs text-gray-400 dark:text-slate-500 transition-colors">Format: JPG, PNG. Maksimal 2MB. Disarankan rasio melebar (landscape 16:9).</p>
                </div>
            </div>
        </div>

        <div class="mt-10 flex justify-end pt-6 border-t border-gray-100 dark:border-slate-700 transition-colors">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection