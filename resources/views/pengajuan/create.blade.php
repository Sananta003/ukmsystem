@extends('layouts.member')

@section('content')
<div class="max-w-3xl mx-auto pt-24 pb-12 px-4 sm:px-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="mb-8 text-center border-b border-gray-100 pb-6">
            <h2 class="text-3xl font-extrabold text-slate-800">Proposal Pendirian UKM Baru</h2>
            <p class="text-slate-500 mt-2">Lengkapi formulir di bawah ini untuk mengajukan UKM ke pihak Kampus.</p>
        </div>

        <form action="{{ route('member.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 mb-6">
                <label class="block text-sm font-bold text-blue-900 mb-2">
                    <i class="fa-solid fa-key mr-2"></i>Kode Otorisasi Kampus <span class="text-red-500">*</span>
                </label>
                <input type="text" name="kode_kampus" required placeholder="Masukkan kode dari Super Admin..." class="w-full border border-blue-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none uppercase font-mono tracking-widest">
                <p class="text-xs text-blue-600 mt-2">Dapatkan kode ini dari Bagian Kemahasiswaan (Super Admin).</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama UKM yang Diajukan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ukm" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo / Maskot UKM</label>
                    <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi, Visi & Misi UKM <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="6" required placeholder="Jelaskan latar belakang pendirian, rencana kegiatan, dan daftar anggota awal UKM ini..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>

            <div class="pt-6 border-t border-gray-100">
                <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-lg transition-colors shadow-lg shadow-blue-200">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Proposal Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection