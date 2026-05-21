@extends('layouts.admin_ukm')
@section('title', 'Pengaturan UKM')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Pengaturan UKM</h2>
        <p class="text-sm text-gray-500">Perbarui profil dan informasi UKM Anda.</p>
    </div>



    <form action="{{ route('admin-ukm.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div class="flex items-center gap-6 mb-4">
                <div class="w-24 h-24 rounded-xl border border-gray-200 flex items-center justify-center overflow-hidden bg-gray-50 shrink-0">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/' . $ukm->logo) }}" alt="Logo" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-graduation-cap text-3xl text-gray-300"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo UKM</label>
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama UKM <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ukm" value="{{ $ukm->nama_ukm }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="5" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">{{ $ukm->deskripsi }}</textarea>
            </div>

            <div class="border-t border-gray-100 pt-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Kegiatan / Banner Utama</label>
                
                @if(isset($ukm->foto_kegiatan) && $ukm->foto_kegiatan)
                    <div class="w-full h-40 rounded-lg overflow-hidden border border-gray-200 mb-3 bg-gray-50">
                        <img src="{{ asset('storage/' . $ukm->foto_kegiatan) }}" alt="Foto Kegiatan" class="w-full h-full object-cover">
                    </div>
                @endif
                
                <input type="file" name="foto_kegiatan" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-400 mt-2">Format: JPG, PNG. Maksimal 2MB. Disarankan rasio melebar (landscape) agar pas di halaman depan.</p>
            </div>
            </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection