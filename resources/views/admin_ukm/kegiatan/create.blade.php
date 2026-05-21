@extends('layouts.admin_ukm')
@section('title', 'Tambah Kegiatan Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-8">
    <div class="mb-4">
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Manajemen Kegiatan
        </a>
    </div>

    <!-- Header Banner -->
    <div class="bg-blue-600 rounded-xl p-6 text-white relative overflow-hidden shadow-sm">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full mix-blend-overlay filter blur-xl -mr-10 -mt-10"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full mix-blend-overlay filter blur-xl -ml-10 -mb-10"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center text-xl backdrop-blur-sm border border-white/10">
                <i class="fa-regular fa-file-lines"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Tambah Kegiatan Baru</h1>
                <p class="text-blue-100 text-sm mt-1">Lengkapi form di bawah untuk menambahkan kegiatan</p>
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
        <form action="{{ route('admin-ukm.kegiatan.store') }}" method="POST">
            @csrf
            
            <div class="p-8 space-y-8">
                <!-- Informasi Dasar -->
                <div>
                    <h3 class="text-base font-bold text-gray-800 mb-4">Informasi Dasar</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kegiatan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-regular fa-file-lines absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Workshop UI/UX Design" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <input type="text" name="kategori" placeholder="Contoh: Pelatihan" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
                            <textarea name="deskripsi" rows="4" placeholder="Jelaskan secara detail tentang kegiatan ini, tujuan, dan manfaatnya..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white"></textarea>
                            <p class="text-[11px] text-gray-400 mt-1">0 karakter</p>
                        </div>
                    </div>
                </div>

                <!-- Waktu & Tempat -->
                <div>
                    <h3 class="text-base font-bold text-gray-800 mb-4">Waktu & Tempat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-regular fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="date" name="tanggal" required class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-regular fa-clock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="time" name="waktu" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <i class="fa-solid fa-location-dot absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="lokasi" required placeholder="Contoh: Aula Kampus" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                        </div>
                    </div>
                </div>

                <!-- Anggaran & Peserta -->
                <div>
                    <h3 class="text-base font-bold text-gray-800 mb-4">Anggaran & Peserta</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Anggaran (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium">$</span>
                                <input type="number" name="anggaran" required min="0" placeholder="5000000" class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target Peserta <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-user-group absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="number" name="target_peserta" placeholder="50" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Penanggung Jawab -->
                <div>
                    <h3 class="text-base font-bold text-gray-800 mb-4">Penanggung Jawab</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penanggung Jawab (PIC) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fa-regular fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="pic_name" placeholder="Contoh: Ahmad Hidayat" class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kontak PIC <span class="text-red-500">*</span></label>
                            <input type="text" name="pic_contact" placeholder="+62 812-3456-7890" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm bg-white">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Action -->
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex items-center gap-4">
                <button type="button" onclick="window.history.back()" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm flex items-center justify-center min-w-[120px]">
                    <i class="fa-solid fa-xmark mr-2"></i> Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/30 flex items-center justify-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection