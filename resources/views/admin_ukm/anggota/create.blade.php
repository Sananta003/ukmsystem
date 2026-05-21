@extends('layouts.admin_ukm')
@section('title', 'Tambah Anggota')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Daftarkan Anggota Baru</h1>
            <p class="text-gray-500 mt-2">Buat akun untuk anggota agar mereka bisa login ke sistem.</p>
        </div>
        <a href="{{ route('admin-ukm.anggota.index') }}" class="text-sm font-semibold text-gray-500 hover:text-brand-accent transition-colors flex items-center gap-2">
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
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-accent/5 rounded-full filter blur-3xl -mr-20 -mt-20"></div>
        <form action="{{ route('admin-ukm.anggota.store') }}" method="POST" class="p-8 relative">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-gray-50/50 hover:bg-white focus:bg-white" placeholder="Masukkan nama lengkap">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-gray-50/50 hover:bg-white focus:bg-white" placeholder="email@mahasiswa.com">
                    </div>
                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info text-blue-500"></i> Email ini akan digunakan anggota untuk login.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Sementara <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required minlength="6" class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-gray-50/50 hover:bg-white focus:bg-white" placeholder="••••••••">
                    </div>
                    <p class="text-xs text-gray-500 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info text-blue-500"></i> Minimal 6 karakter. Anggota dapat menggantinya nanti.</p>
                </div>
            </div>

            <div class="mt-10 flex justify-end gap-4 border-t border-gray-50 pt-6">
                <a href="{{ route('admin-ukm.anggota.index') }}" class="px-6 py-3 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-bold transition-colors">Batal</a>
                <button type="submit" class="px-6 py-3 bg-brand-accent hover:bg-blue-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-brand-accent/30 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Daftarkan Anggota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection