@extends('layouts.admin_ukm')
@section('title', 'Tambah Kegiatan Baru')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-gray-500 mb-2">
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="hover:text-indigo-600">Kegiatan</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">Tambah Baru</span>
    </div>
    <h1 class="text-3xl font-bold text-gray-800">Tambah Kegiatan Baru</h1>
</div>

<form action="{{ route('admin-ukm.kegiatan.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-circle-info text-indigo-500 mr-2"></i> Informasi Dasar</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Seminar">Seminar / Workshop</option>
                    <option value="Lomba">Lomba / Kompetisi</option>
                    <option value="Pelatihan">Pelatihan Rutin</option>
                    <option value="Sosial">Bakti Sosial</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Kegiatan</label>
                <textarea name="deskripsi" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-regular fa-calendar text-indigo-500 mr-2"></i> Waktu & Tempat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                <input type="time" name="waktu" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="lokasi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Cth: Aula Kampus" required>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-wallet text-indigo-500 mr-2"></i> Anggaran & Peserta</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Anggaran (Rp)</label>
                    <input type="number" name="anggaran" min="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Peserta (Orang)</label>
                    <input type="number" name="target_peserta" min="1" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i class="fa-solid fa-user-tie text-indigo-500 mr-2"></i> Penanggung Jawab (PIC)</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC</label>
                    <input type="text" name="pic_nama" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kontak PIC (WA/Telepon)</label>
                    <input type="text" name="pic_kontak" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-6">
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium transition-colors">Batal</a>
        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold shadow-sm transition-colors">Simpan Kegiatan</button>
    </div>
</form>
@endsection