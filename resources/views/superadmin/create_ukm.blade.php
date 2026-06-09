
@extends('layouts.app')
@section('title', 'Daftarkan UKM Baru')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="bg-purple-600 p-8 text-white">
        <h2 class="text-2xl font-bold">Daftarkan UKM Baru</h2>
        <p class="text-purple-100 mt-1">Sistem akan otomatis membuat wadah database dan akun ketua untuk UKM ini.</p>
    </div>

    <form action="{{ route('superadmin.ukm.store') }}" method="POST" class="p-8">
        @csrf
        <div class="grid grid-cols-2 gap-10">
            <div class="space-y-5">
                <h3 class="font-bold text-lg text-gray-800 border-b pb-2"><i class="fa-solid fa-building text-purple-600 mr-2"></i> 1. Profil Organisasi</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Resmi UKM <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ukm" required placeholder="Cth: UKM Pecinta Alam" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Visi / Deskripsi Singkat <span class="text-red-500">*</span></label>
                    <textarea name="deskripsi" required rows="4" placeholder="Cth: Wadah mahasiswa untuk kegiatan alam bebas..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 outline-none"></textarea>
                </div>
            </div>

            <div class="space-y-5">
                <h3 class="font-bold text-lg text-gray-800 border-b pb-2"><i class="fa-solid fa-user-tie text-purple-600 mr-2"></i> 2. Akun Admin/Ketua</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Ketua <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ketua" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Resmi (Untuk Login) <span class="text-red-500">*</span></label>
                    <input type="email" name="email_ketua" required placeholder="Cth: mapala@kampus.com" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Sistem <span class="text-red-500">*</span></label>
                    <input type="password" name="password_ketua" required minlength="6" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-purple-500 outline-none">
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="px-6 py-3 text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg font-bold transition-colors">Batal</a>
            <button type="submit" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold transition-colors shadow-lg shadow-purple-200">Generate UKM & Akun</button>
        </div>
    </form>
</div>
@endsection
