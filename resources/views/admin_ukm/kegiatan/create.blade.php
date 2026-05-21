@extends('layouts.admin')

@section('title', 'Tambah Kegiatan Baru')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-3 text-sm text-gray-500 mb-4">
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="hover:text-indigo-600">Kegiatan</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Tambah Baru</span>
    </div>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Form Tambah Kegiatan</h1>
    <p class="text-sm text-gray-500 mt-1">Lengkapi informasi di bawah ini untuk merencanakan kegiatan baru UKM.</p>
</div>

<form action="{{ route('admin-ukm.kegiatan.store') }}" method="POST">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Informasi Dasar -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informasi Dasar</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" required value="{{ old('nama_kegiatan') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('nama_kegiatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" placeholder="Contoh: Seminar, Pelatihan, Lomba..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Waktu & Tempat -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Waktu & Tempat</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" required value="{{ old('tanggal') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu (Jam)</label>
                    <input type="time" name="waktu" value="{{ old('waktu') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lokasi Kegiatan</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Tempat pelaksanaan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
            </div>
        </div>

        <!-- Anggaran & Peserta -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Anggaran & Target Peserta</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rencana Anggaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="anggaran" required min="0" value="{{ old('anggaran', 0) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Jumlah Peserta <span class="text-red-500">*</span></label>
                    <input type="number" name="target_peserta" required min="0" value="{{ old('target_peserta', 0) }}" placeholder="Isi 0 jika tidak dibatasi" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
            </div>
        </div>

        <!-- Penanggung Jawab -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Penanggung Jawab (PIC)</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama PIC</label>
                    <input type="text" name="pic_nama" value="{{ old('pic_nama') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kontak PIC (No. HP/WA)</label>
                    <input type="text" name="pic_kontak" value="{{ old('pic_kontak') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="px-6 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            Batal
        </a>
        <button type="submit" class="px-6 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            Simpan Kegiatan
        </button>
    </div>
</form>
@endsection