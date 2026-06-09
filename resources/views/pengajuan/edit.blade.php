@extends('layouts.member')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Revisi Proposal UKM</h1>
        <p class="text-gray-500 mt-2">Perbaiki proposal pengajuan UKM Anda berdasarkan catatan revisi berikut.</p>
    </div>

    @if($pengajuan->revisis->count() > 0)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8 shadow-sm">
        <h3 class="text-amber-800 font-bold mb-4 flex items-center"><i class="fa-solid fa-list-check mr-2"></i> Riwayat Catatan Revisi</h3>
        <div class="space-y-4">
            @foreach($pengajuan->revisis as $revisi)
            <div class="bg-white rounded-lg p-4 border border-amber-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-bold text-gray-800">{{ $revisi->user->name }} <span class="text-xs uppercase bg-gray-100 text-gray-600 px-2 py-0.5 rounded ml-2">{{ $revisi->user->role }}</span></span>
                    <span class="text-xs text-gray-500">{{ $revisi->created_at->format('d M Y, H:i') }}</span>
                </div>
                <p class="text-gray-700 text-sm whitespace-pre-wrap">{{ $revisi->komentar }}</p>
                @if($revisi->file_revisi)
                    <a href="{{ asset('storage/'.$revisi->file_revisi) }}" target="_blank" class="mt-3 inline-flex items-center text-xs font-medium text-amber-700 hover:text-amber-900 bg-amber-100 px-3 py-1.5 rounded-md transition-colors">
                        <i class="fa-solid fa-paperclip mr-2"></i> Lihat File Lampiran
                    </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('inisiator.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Nama UKM <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ukm" value="{{ old('nama_ukm', $pengajuan->nama_ukm) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition-shadow" placeholder="Contoh: UKM Robotika Kampus">
                @error('nama_ukm') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Logo UKM (Opsional, akan ditimpa jika diisi)</label>
                <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg">
                @error('logo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Visi, Misi & Latar Belakang <span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-500 mb-2">Jelaskan secara detail tujuan pendirian UKM ini dan mengapa UKM ini penting.</p>
                <textarea name="deskripsi" rows="8" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none transition-shadow" placeholder="Tuliskan latar belakang...">{{ old('deskripsi', $pengajuan->latar_belakang) }}</textarea>
                @error('deskripsi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Upload Proposal Revisi (PDF, Max 5MB)</label>
                <p class="text-xs text-gray-500 mb-2">Kosongkan jika tidak ada perubahan pada file proposal.</p>
                <input type="file" name="file_proposal" accept="application/pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-gray-200 rounded-lg">
                @if($pengajuan->file_proposal)
                    <p class="text-xs text-gray-600 mt-2">Proposal saat ini: <a href="{{ asset('storage/'.$pengajuan->file_proposal) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">Lihat Proposal</a></p>
                @endif
                @error('file_proposal') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-4">
                <a href="{{ route('inisiator.dashboard') }}" class="px-6 py-3 text-gray-600 hover:bg-gray-50 font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-bold shadow-lg shadow-indigo-200 transition-colors flex items-center">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Ulang Revisi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
