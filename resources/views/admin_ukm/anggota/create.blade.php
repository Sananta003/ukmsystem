@extends('layouts.admin_ukm')
@section('title', 'Tambah Anggota Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-8">
    <div class="mb-4">
        <a href="{{ route('admin-ukm.anggota.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Manajemen Anggota
        </a>
    </div>

    <!-- Header Banner -->
    <div class="bg-blue-600 rounded-xl p-6 text-white relative overflow-hidden shadow-sm">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full mix-blend-overlay filter blur-xl -mr-10 -mt-10"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full mix-blend-overlay filter blur-xl -ml-10 -mb-10"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center text-xl backdrop-blur-sm border border-white/10">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Tambah Anggota Baru</h1>
                <p class="text-blue-100 text-sm mt-1">Lengkapi form di bawah untuk mendaftarkan anggota ke dalam UKM Anda</p>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-500 text-sm p-4 rounded-lg border border-red-100">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin-ukm.anggota.store') }}" method="POST">
            @csrf
            
            <div class="p-8 space-y-8">
                <!-- Section 1 -->
                <div>
                    <h3 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Informasi Dasar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-regular fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Hidayat" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-regular fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: ahmad@kampus.ac.id" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>
                            <p class="text-[11px] text-gray-400 mt-1">Email ini akan digunakan untuk login.</p>
                        </div>
                    </div>
                </div>

                <!-- Section 2 -->
                <div>
                    <h3 class="text-base font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100">Keamanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Sementara <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all bg-gray-50 focus:bg-white">
                            </div>
                            <p class="text-[11px] text-gray-400 mt-1">Anggota dapat menggantinya setelah berhasil login pertama kali.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex items-center justify-between">
                <button type="button" onclick="window.history.back()" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                    <i class="fa-solid fa-xmark mr-1"></i> Batal
                </button>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/30 flex items-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Anggota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection