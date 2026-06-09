@extends('layouts.app')
@section('title', 'Tambah Anggota Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Anggota Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi form di bawah untuk menambah anggota baru</p>
        
        <a href="{{ route('admin-ukm.anggota.index') }}" class="text-sm font-medium text-gray-600 hover:text-brand-accent transition-colors flex items-center gap-2 mt-4">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Anggota
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

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-8">
        <form action="{{ route('admin-ukm.anggota.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Foto Profil -->
            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 mb-3">Foto Profil</label>
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-gray-50 border border-gray-200 rounded-full flex items-center justify-center text-gray-400 overflow-hidden" id="preview-container">
                        <i class="fa-regular fa-user text-3xl" id="placeholder-icon"></i>
                        <img id="preview-image" class="w-full h-full object-cover hidden" alt="Preview Foto" />
                    </div>
                    <div>
                        <label class="cursor-pointer bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
                            <i class="fa-solid fa-upload"></i> Upload Foto
                            <input type="file" name="foto" id="foto" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewFile(this);">
                        </label>
                        <p class="text-xs text-gray-400 mt-2">PNG, JPG, atau JPEG. Maksimal 2MB.</p>
                    </div>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-white" placeholder="Masukkan nama lengkap">
            </div>
            
            <!-- NIM -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">NIM <span class="text-red-500">*</span></label>
                <input type="text" name="nim" value="{{ old('nim') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-white" placeholder="Masukkan NIM">
            </div>

            <!-- Fakultas & Prodi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Fakultas <span class="text-red-500">*</span></label>
                    <input type="text" name="fakultas" value="{{ old('fakultas') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-white" placeholder="Masukkan fakultas">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Program Studi <span class="text-red-500">*</span></label>
                    <input type="text" name="prodi" value="{{ old('prodi') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-white" placeholder="Masukkan program studi">
                </div>
            </div>

            <!-- Email & HP -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-white" placeholder="nama@email.com">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-white" placeholder="08xxxxxxxxxx">
                </div>
            </div>
            
            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent outline-none transition-all shadow-sm bg-white appearance-none">
                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                </select>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6">
                <a href="{{ route('admin-ukm.anggota.index') }}" class="px-6 py-2.5 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg text-sm font-bold transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-brand-accent hover:bg-blue-700 text-white rounded-lg text-sm font-bold transition-all shadow-md">
                    Tambah Anggota
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewFile(input) {
        var file = input.files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                document.getElementById("preview-image").src = reader.result;
                document.getElementById("preview-image").classList.remove("hidden");
                document.getElementById("placeholder-icon").classList.add("hidden");
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
