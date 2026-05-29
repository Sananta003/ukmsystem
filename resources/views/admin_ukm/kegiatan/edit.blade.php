@extends('layouts.admin_ukm')
@section('title', 'Edit Kegiatan')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Edit Kegiatan</h2>
        <p class="text-sm text-gray-500">Perbarui informasi agenda UKM Anda.</p>
    </div>

    <form action="{{ route('admin-ukm.kegiatan.update', $kegiatan->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Program Kerja / Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ $kegiatan->nama_kegiatan }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
            
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ $kegiatan->tanggal }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option value="Direncanakan" {{ $kegiatan->status == 'Direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="Berjalan" {{ $kegiatan->status == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="Selesai" {{ $kegiatan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ $kegiatan->lokasi }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Anggaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="anggaran" value="{{ $kegiatan->anggaran }}" required min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="px-5 py-2.5 text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg font-medium transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection