@extends('layouts.admin_ukm')
@section('title', 'Tambah Kegiatan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Tambah Kegiatan Baru</h1>
            <p class="text-gray-500 mt-2">Jadwalkan agenda dan program kerja untuk UKM Anda.</p>
        </div>
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-sm font-semibold text-gray-500 hover:text-brand-accent transition-colors flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-500 text-sm p-4 rounded-lg mb-6 border border-red-100 shadow-sm flex items-start gap-3">
            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-green-50 rounded-full filter blur-3xl -mr-20 -mt-20"></div>
        <form action="{{ route('admin-ukm.kegiatan.store') }}" method="POST" class="p-8 relative">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-clipboard-list absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="nama" required class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-gray-50/50 hover:bg-white focus:bg-white" placeholder="Misal: Seminar Nasional Teknologi 2024">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fa-solid fa-calendar-day absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="date" name="tanggal" required class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-gray-50/50 hover:bg-white focus:bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <div class="relative">
                            <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="lokasi" class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-gray-50/50 hover:bg-white focus:bg-white" placeholder="Gedung Rektorat Lt. 3">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Anggaran (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">Rp</div>
                        <input type="number" name="anggaran" required min="0" value="0" class="w-full border border-gray-200 rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-gray-50/50 hover:bg-white focus:bg-white font-medium">
                    </div>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-4 border-t border-gray-50 pt-6">
                <a href="{{ route('admin-ukm.kegiatan.index') }}" class="px-6 py-3 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-bold transition-colors">Batal</a>
                <button type="submit" class="px-6 py-3 bg-brand-accent hover:bg-blue-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-brand-accent/30 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection