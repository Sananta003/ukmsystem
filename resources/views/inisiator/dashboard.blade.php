@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    @if($pengajuan && in_array($pengajuan->status, ['pending_bem', 'revisi_bem', 'pending_bpm', 'revisi_bpm', 'pending_superadmin']))
        <div class="bg-amber-50 border border-amber-200 rounded-3xl p-10 text-center max-w-3xl mx-auto mt-10 shadow-sm relative overflow-hidden">
            <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            
            @if(in_array($pengajuan->status, ['revisi_bem', 'revisi_bpm']))
                <h2 class="text-2xl font-bold text-red-600 mb-3">Status: Perlu Revisi</h2>
                <p class="text-gray-600 mb-6 text-lg">Proposal pengajuan UKM <b>{{ $pengajuan->nama_ukm }}</b> Anda dikembalikan untuk direvisi. Silakan periksa catatan dari pihak birokrasi dan perbaiki proposal Anda.</p>
                <a href="{{ route('inisiator.pengajuan.edit', $pengajuan->id) }}" class="inline-flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-amber-200 mb-4">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit & Kirim Ulang Proposal
                </a>
            @else
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Status: Sedang Direview</h2>
                <p class="text-gray-600 mb-4 text-lg">Proposal pengajuan UKM <b>{{ $pengajuan->nama_ukm }}</b> Anda sedang dalam tahap peninjauan oleh pihak Kampus (BEM/BPM/Super Admin).</p>
            @endif

            @if($pengajuan->revisis->count() > 0)
                <div class="bg-white rounded-xl p-6 text-left border border-gray-200 mt-6 max-h-64 overflow-y-auto">
                    <h3 class="font-bold text-gray-800 mb-4"><i class="fa-solid fa-comments text-amber-500 mr-2"></i>Riwayat Catatan Peninjauan</h3>
                    <div class="space-y-4">
                        @foreach($pengajuan->revisis as $revisi)
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-sm text-gray-800">{{ $revisi->user->name }} <span class="text-xs text-gray-500 font-normal">({{ strtoupper($revisi->user->role) }})</span></span>
                                    <span class="text-xs text-gray-400">{{ $revisi->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 text-sm mb-2 whitespace-pre-wrap">{{ $revisi->komentar }}</p>
                                @if($revisi->file_revisi)
                                    <a href="{{ asset('storage/'.$revisi->file_revisi) }}" target="_blank" class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800">
                                        <i class="fa-solid fa-paperclip mr-1"></i> Download File Lampiran
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="bg-indigo-50 border border-indigo-200 rounded-3xl p-10 text-center max-w-3xl mx-auto mt-10 shadow-sm relative overflow-hidden">
            <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Langkah Selanjutnya: Ajukan Proposal</h2>
            <p class="text-gray-600 mb-8 text-lg">Anda terdaftar sebagai calon Inisiator UKM. Lengkapi formulir pengajuan Visi, Misi, dan Logo UKM baru Anda agar dapat ditinjau oleh pihak Kampus.</p>
            
            <a href="{{ route('inisiator.pengajuan.create') }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-indigo-200 hover:-translate-y-0.5">
                Mulai Isi Formulir Pengajuan <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    @endif

</div>
@endsection
