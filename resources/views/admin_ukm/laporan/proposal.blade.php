@extends('layouts.admin_ukm')
@section('title', 'Cek Proposal Kegiatan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-8">
    
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h1 class="text-2xl font-bold text-gray-900">Proposal & Approval</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola pengajuan dan persetujuan proposal kegiatan</p>
    </div>

    <!-- Header Box -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
        <div>
            <h2 class="text-lg font-bold text-gray-900">Workshop UI/UX Design</h2>
            <p class="text-xs text-gray-500 mt-1">ID Proposal: #2026-001</p>
        </div>
        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Diajukan</span>
    </div>

    <!-- Upload Proposal Box -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fa-regular fa-file-lines text-blue-600"></i>
            <h3 class="font-bold text-gray-800 text-sm">Upload Proposal</h3>
        </div>
        
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:bg-gray-50 hover:border-blue-400 transition-colors cursor-pointer group">
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-50">
                <i class="fa-solid fa-arrow-up-from-bracket text-gray-400 group-hover:text-blue-500"></i>
            </div>
            <p class="text-sm font-medium text-gray-700">Drop file di sini atau <span class="text-blue-600">browse</span></p>
            <p class="text-[11px] text-gray-400 mt-1">PDF, DOC, atau DOCX. Maksimal 10MB.</p>
        </div>
    </div>

    <!-- Aksi Persetujuan Box -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 text-sm mb-2">Aksi Persetujuan</h3>
        <p class="text-xs text-gray-500 mb-4">Tinjau proposal dengan seksama sebelum memberikan persetujuan atau penolakan.</p>
        
        <div class="grid grid-cols-2 gap-4">
            <button type="button" class="py-3 px-4 border border-red-200 text-red-500 rounded-lg hover:bg-red-50 transition-colors font-medium text-sm flex items-center justify-center">
                <i class="fa-solid fa-xmark mr-2"></i> Tolak Proposal
            </button>
            <button type="button" class="py-3 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium text-sm flex items-center justify-center shadow-md shadow-green-500/20">
                <i class="fa-solid fa-check mr-2"></i> Setujui Proposal
            </button>
        </div>
    </div>

    <!-- Riwayat Persetujuan Box -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 text-sm mb-4">Riwayat Persetujuan</h3>
        
        <div class="space-y-4">
            <!-- Item 1 -->
            <div class="flex items-start gap-4 p-4 border border-green-100 bg-green-50/30 rounded-lg">
                <div class="mt-1 w-5 h-5 rounded-full bg-green-500 text-white flex items-center justify-center text-[10px] shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-800">Ahmad Hidayat</p>
                            <p class="text-xs text-gray-500">Ketua UKM</p>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded">Disetujui</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">Proposal sudah sesuai dengan pedoman.</p>
                    <p class="text-[10px] text-gray-400 mt-1">25 Feb 2026, 16:30</p>
                </div>
            </div>
            
            <!-- Item 2 -->
            <div class="flex items-start gap-4 p-4 border border-green-100 bg-green-50/30 rounded-lg">
                <div class="mt-1 w-5 h-5 rounded-full bg-green-500 text-white flex items-center justify-center text-[10px] shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-800">Siti Nurhaliza</p>
                            <p class="text-xs text-gray-500">Bendahara</p>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded">Disetujui</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-2">Anggaran sudah diverifikasi.</p>
                    <p class="text-[10px] text-gray-400 mt-1">26 Feb 2026, 14:15</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex items-start gap-4 p-4 border border-gray-100 bg-gray-50/50 rounded-lg">
                <div class="mt-1 w-5 h-5 rounded-full bg-gray-300 text-white flex items-center justify-center text-[10px] shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-800">Dr. Budi Santoso</p>
                            <p class="text-xs text-gray-500">Pembina UKM</p>
                        </div>
                        <span class="text-[10px] font-bold text-gray-500 bg-gray-200 px-2 py-0.5 rounded">Menunggu</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 italic">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline & Informasi Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Timeline Approval -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 text-sm mb-6">Timeline Approval</h3>
            
            <div class="relative border-l border-gray-200 ml-3 space-y-8">
                <!-- Node 1 -->
                <div class="relative pl-6">
                    <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white ring-4 ring-green-50"></div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-regular fa-user text-gray-400 text-xs"></i>
                            <p class="text-xs font-bold text-gray-800">Ahmad Hidayat</p>
                        </div>
                        <p class="text-[10px] text-gray-500 mb-1">Ketua UKM</p>
                        <p class="text-[10px] text-green-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Approved</p>
                    </div>
                </div>

                <!-- Node 2 -->
                <div class="relative pl-6">
                    <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white ring-4 ring-green-50"></div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-regular fa-user text-gray-400 text-xs"></i>
                            <p class="text-xs font-bold text-gray-800">Siti Nurhaliza</p>
                        </div>
                        <p class="text-[10px] text-gray-500 mb-1">Bendahara</p>
                        <p class="text-[10px] text-green-600 font-medium"><i class="fa-solid fa-check mr-1"></i> Approved</p>
                    </div>
                </div>

                <!-- Node 3 -->
                <div class="relative pl-6">
                    <div class="absolute -left-1.5 top-1.5 w-3 h-3 bg-gray-300 rounded-full border-2 border-white ring-4 ring-gray-100"></div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-regular fa-user text-gray-400 text-xs"></i>
                            <p class="text-xs font-bold text-gray-800">Dr. Budi Santoso</p>
                        </div>
                        <p class="text-[10px] text-gray-500 mb-1">Pembina UKM</p>
                        <p class="text-[10px] text-gray-400 font-medium"><i class="fa-regular fa-clock mr-1"></i> Pending</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi -->
        <div class="bg-blue-50 rounded-xl border border-blue-100 p-6 h-fit">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded bg-blue-600 text-white flex items-center justify-center">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-sm">Informasi</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <p class="text-[11px] text-gray-500 mb-0.5">Diajukan oleh</p>
                    <p class="text-sm font-bold text-gray-800">Ahmad Hidayat</p>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 mb-0.5">Tanggal Pengajuan</p>
                    <p class="text-sm font-bold text-gray-800">25 Feb 2026</p>
                </div>
                <div>
                    <p class="text-[11px] text-gray-500 mb-0.5">Total Approval</p>
                    <p class="text-sm font-bold text-gray-800">2 dari 3 telah menyetujui</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
