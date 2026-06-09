@extends('layouts.app')
@section('title', 'Cek Proposal UKM')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin-ukm.proposal.index') }}" class="text-sm font-bold text-gray-500 hover:text-indigo-600 mb-2 inline-flex items-center transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">Proposal & Approval</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pengajuan dan persetujuan proposal kegiatan</p>
        </div>
    </div>

    <!-- Kotak Info Proposal -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-800">{{ $kegiatan->nama_kegiatan }}</h2>
            <p class="text-sm text-gray-500 mt-1">ID Proposal: #{{ str_pad($kegiatan->id, 3, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="shrink-0">
            @php
                $statusColor = 'bg-gray-50 text-gray-600 border-gray-200';
                $statusIcon = 'fa-circle-question';
                $statusText = 'Belum Ada';
                
                if($proposal) {
                    $statusText = $proposal->status_akhir;
                    if($proposal->status_akhir == 'Disetujui') {
                        $statusColor = 'bg-green-50 text-green-700 border-green-200';
                        $statusIcon = 'fa-check';
                    } elseif($proposal->status_akhir == 'Ditolak') {
                        $statusColor = 'bg-red-50 text-red-700 border-red-200';
                        $statusIcon = 'fa-xmark';
                    } elseif($proposal->status_akhir == 'Revisi') {
                        $statusColor = 'bg-amber-50 text-amber-700 border-amber-200';
                        $statusIcon = 'fa-pen';
                    } else {
                        $statusColor = 'bg-blue-50 text-blue-700 border-blue-200';
                        $statusIcon = 'fa-spinner fa-spin-pulse';
                    }
                }
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border {{ $statusColor }}">
                <i class="fa-solid {{ $statusIcon }} mr-2"></i> {{ $statusText }}
            </span>
        </div>
    </div>

    @if(!$proposal || $proposal->status_akhir == 'Revisi' || $proposal->status_akhir == 'Ditolak')
    <!-- Area Upload Proposal -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center">
            <i class="fa-regular fa-file-pdf text-indigo-500 mr-2"></i> {{ !$proposal ? 'Upload Proposal' : 'Upload Ulang / Revisi Proposal' }}
        </h3>
        
        <form action="{{ route('admin-ukm.proposal.upload', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:bg-gray-50 transition-colors relative group">
                <input type="file" name="file_proposal" id="file_proposal" accept=".pdf,.doc,.docx" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('fileName').textContent = this.files[0].name;">
                <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:text-indigo-500 group-hover:bg-indigo-50 transition-colors">
                    <i class="fa-solid fa-arrow-up-from-bracket text-xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-700 mb-1">Drop file di sini atau <span class="text-indigo-600">browse</span></p>
                <p class="text-xs text-gray-400">PDF, DOC, atau DOCX. Maksimal 10MB</p>
                <p id="fileName" class="text-sm text-indigo-600 font-bold mt-3"></p>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-md transition-colors text-sm">
                    Upload & Ajukan Proposal
                </button>
            </div>
        </form>
    </div>
    @else
    <!-- Tampilkan File Proposal -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">Dokumen Proposal</h3>
                <p class="text-xs text-gray-500">Diajukan pada {{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y H:i') }}</p>
            </div>
        </div>
        <a href="{{ asset('storage/'.$proposal->file_proposal) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition-colors">
            Lihat File
        </a>
    </div>
    @endif

    <!-- Riwayat Persetujuan -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h3 class="text-base font-bold text-gray-800 mb-6 flex items-center">
            <i class="fa-solid fa-timeline text-indigo-500 mr-2"></i> Timeline Approval
        </h3>
        
        <div class="space-y-6">
            @if(count($approvals) == 0)
                <p class="text-gray-500 text-sm text-center py-4">Belum ada riwayat persetujuan. Silakan upload proposal terlebih dahulu.</p>
            @else
                @foreach($approvals as $index => $approval)
                <div class="flex gap-4 relative">
                    <!-- Garis vertikal -->
                    @if(!$loop->last)
                        <div class="absolute top-8 left-4 bottom-[-24px] w-0.5 bg-gray-200"></div>
                    @endif
                    
                    <!-- Icon Status -->
                    <div class="relative z-10 shrink-0">
                        @if($approval->status == 'Disetujui')
                            <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center shadow-sm shadow-green-500/30">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                        @elseif($approval->status == 'Ditolak')
                            <div class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center shadow-sm shadow-red-500/30">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </div>
                        @elseif($approval->status == 'Revisi')
                            <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center shadow-sm shadow-amber-500/30">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </div>
                        @else
                            <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center border-2 border-white">
                                <i class="fa-regular fa-clock text-xs"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Konten -->
                    <div class="flex-1 pb-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-bold text-gray-800 text-sm">
                                    {{ strtoupper(str_replace('_', ' ', $approval->role_approval)) }}
                                    @if($approval->user)
                                        <span class="text-gray-500 font-normal">({{ $approval->user->name }})</span>
                                    @endif
                                </h4>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $approval->updated_at != $approval->created_at ? \Carbon\Carbon::parse($approval->updated_at)->format('d M Y, H:i') : 'Menunggu respons' }}
                                </p>
                            </div>
                            <span class="text-xs font-bold px-2 py-1 rounded 
                                {{ $approval->status == 'Disetujui' ? 'bg-green-100 text-green-700' : 
                                  ($approval->status == 'Ditolak' ? 'bg-red-100 text-red-700' : 
                                  ($approval->status == 'Revisi' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600')) }}">
                                {{ $approval->status }}
                            </span>
                        </div>
                        @if($approval->catatan)
                            <div class="mt-2 bg-gray-50 border border-gray-100 rounded-lg p-3 text-sm text-gray-600">
                                <span class="font-bold text-gray-700">Catatan:</span> {{ $approval->catatan }}
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Aksi Persetujuan (Hanya muncul jika user ini berhak approve dan statusnya Menunggu) -->
    @if($proposal && $proposal->status_akhir != 'Disetujui')
        @php
            $myApproval = \App\Models\ProposalApproval::where('proposal_id', $proposal->id)
                ->where('role_approval', Auth::user()->role)
                ->where('status', 'Menunggu')
                ->first();
        @endphp

        @if($myApproval)
        <div class="bg-indigo-50 rounded-2xl border border-indigo-100 p-6 mb-6">
            <h3 class="text-base font-bold text-indigo-900 mb-2">Tindakan Persetujuan</h3>
            <p class="text-sm text-indigo-700 mb-4">Berikan persetujuan atau catatan revisi untuk proposal ini.</p>
            
            <form action="{{ route('admin-ukm.proposal.approve', $proposal->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold text-indigo-900 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="2" class="w-full border-indigo-200 rounded-xl p-3 focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Tulis catatan revisi atau alasan penolakan di sini..."></textarea>
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" name="status" value="Ditolak" class="bg-white hover:bg-red-50 text-red-600 border border-red-200 px-5 py-2.5 rounded-xl text-sm font-bold transition-colors" onclick="return confirm('Tolak proposal ini?');">
                        Tolak Proposal
                    </button>
                    <button type="submit" name="status" value="Revisi" class="bg-white hover:bg-amber-50 text-amber-600 border border-amber-200 px-5 py-2.5 rounded-xl text-sm font-bold transition-colors">
                        Minta Revisi
                    </button>
                    <button type="submit" name="status" value="Disetujui" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-indigo-600/20 transition-colors" onclick="return confirm('Setujui proposal ini?');">
                        Setujui Proposal
                    </button>
                </div>
            </form>
        </div>
        @endif
    @endif

    <!-- Informasi Pendukung -->
    <div class="bg-blue-50/50 rounded-2xl border border-blue-100 p-5 flex items-start gap-3">
        <i class="fa-solid fa-circle-info text-blue-500 mt-0.5"></i>
        <p class="text-xs text-blue-800 leading-relaxed">
            Proposal akan melalui tahapan verifikasi berjenjang. Anda akan mendapatkan notifikasi apabila terdapat catatan perbaikan dari pihak Kampus atau BEM. Pastikan isi proposal sudah lengkap dan benar.
        </p>
    </div>
</div>
@endsection
