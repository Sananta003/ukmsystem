@extends('layouts.admin_ukm')
@section('title', 'Cek Proposal UKM')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Proposal & Approval</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola pengajuan dan persetujuan proposal kegiatan</p>
    </div>

    <div class="space-y-6">
        <!-- Box 1: Info Proposal -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Workshop UI/UX Design</h2>
                <p class="text-sm text-gray-500 mt-1">ID Proposal: #2026-001</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-bold border border-blue-100">
                <i class="fa-solid fa-spinner"></i> Diajukan
            </span>
        </div>

        <!-- Box 2: Upload Proposal -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-md font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fa-regular fa-file-lines text-blue-500"></i> Upload Proposal
            </h3>
            
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-10 flex flex-col items-center justify-center text-center hover:bg-gray-50 transition cursor-pointer">
                <div class="w-12 h-12 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center text-xl mb-3">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                </div>
                <p class="text-sm font-bold text-gray-700 mb-1">Drop file di sini atau <span class="text-blue-600">browse</span></p>
                <p class="text-xs text-gray-400">PDF, DOC, atau DOCX. Maksimal 10MB</p>
            </div>
        </div>

        <!-- Box 3: Aksi Persetujuan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-md font-bold text-gray-800 mb-1">Aksi Persetujuan</h3>
            <p class="text-sm text-gray-500 mb-6">Tinjau proposal dengan seksama sebelum memberikan persetujuan atau penolakan.</p>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <button class="flex-1 py-3 px-4 border border-red-200 text-red-500 hover:bg-red-50 rounded-xl font-bold text-sm transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Tolak Proposal
                </button>
                <button class="flex-1 py-3 px-4 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold text-sm shadow-md transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i> Setujui Proposal
                </button>
            </div>
        </div>

        <!-- Box 4: Riwayat Persetujuan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-md font-bold text-gray-800 mb-6">Riwayat Persetujuan</h3>
            
            <div class="space-y-6 relative before:absolute before:inset-0 before:ml-3.5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gray-100 pl-4 md:pl-0">
                
                <!-- Item 1 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                    <div class="flex items-start w-full md:w-[calc(100%-3rem)] bg-gray-50/50 p-4 rounded-xl border border-gray-100 ml-4 md:ml-0 md:group-odd:mr-8 md:group-even:ml-8 relative">
                        <div class="absolute -left-[38px] md:group-odd:left-auto md:group-odd:-right-[54px] top-4 md:top-1/2 md:-translate-y-1/2 flex items-center justify-center w-7 h-7 rounded-full border-4 border-white bg-green-500 text-white">
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Ahmad Hidayat</h4>
                                    <p class="text-xs text-gray-500">Ketua UKM</p>
                                </div>
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">Disetujui</span>
                            </div>
                            <p class="text-sm text-gray-700 mt-3">Proposal sudah sesuai dengan guidelines</p>
                            <p class="text-xs text-gray-400 mt-2">28 Feb 2026, 10:30</p>
                        </div>
                    </div>
                </div>
                
                <!-- Item 2 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group border-b border-gray-50 pb-6 last:border-0 last:pb-0">
                    <div class="flex items-start w-full md:w-[calc(100%-3rem)] bg-gray-50/50 p-4 rounded-xl border border-gray-100 ml-4 md:ml-0 md:group-odd:mr-8 md:group-even:ml-8 relative">
                        <div class="absolute -left-[38px] md:group-odd:left-auto md:group-odd:-right-[54px] top-4 md:top-1/2 md:-translate-y-1/2 flex items-center justify-center w-7 h-7 rounded-full border-4 border-white bg-green-500 text-white">
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Siti Nurhaliza</h4>
                                    <p class="text-xs text-gray-500">Bendahara</p>
                                </div>
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold">Disetujui</span>
                            </div>
                            <p class="text-sm text-gray-700 mt-3">Anggaran sudah difasilitasi</p>
                            <p class="text-xs text-gray-400 mt-2">28 Feb 2026, 14:15</p>
                        </div>
                    </div>
                </div>
                
                <!-- Item 3 -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-start w-full md:w-[calc(100%-3rem)] bg-white p-4 rounded-xl border border-gray-200 ml-4 md:ml-0 md:group-odd:mr-8 md:group-even:ml-8 relative">
                        <div class="absolute -left-[38px] md:group-odd:left-auto md:group-odd:-right-[54px] top-4 md:top-1/2 md:-translate-y-1/2 flex items-center justify-center w-7 h-7 rounded-full border-4 border-white bg-gray-200 text-gray-400">
                            <i class="fa-solid fa-hourglass-half text-[10px]"></i>
                        </div>
                        
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Dr. Budi Santoso</h4>
                                    <p class="text-xs text-gray-500">Pembina UKM</p>
                                </div>
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-bold">Menunggu</span>
                            </div>
                            <p class="text-sm text-gray-400 mt-3 italic">-</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Box 5: Timeline Approval -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-md font-bold text-gray-800 mb-6">Timeline Approval</h3>
            
            <div class="flex flex-col space-y-4 border-l-2 border-gray-100 ml-5 pl-6 py-2">
                
                <div class="relative">
                    <div class="absolute -left-[34px] w-8 h-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-gray-500 font-bold text-xs top-0">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Ahmad Hidayat</h4>
                        <p class="text-xs text-gray-500">Ketua UKM</p>
                        <p class="text-xs font-bold text-green-500 mt-1 flex items-center gap-1"><i class="fa-solid fa-check-circle"></i> Approved</p>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="absolute -left-[34px] w-8 h-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-gray-500 font-bold text-xs top-0">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Siti Nurhaliza</h4>
                        <p class="text-xs text-gray-500">Bendahara</p>
                        <p class="text-xs font-bold text-green-500 mt-1 flex items-center gap-1"><i class="fa-solid fa-check-circle"></i> Approved</p>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="absolute -left-[34px] w-8 h-8 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-gray-500 font-bold text-xs top-0">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">Dr. Budi Santoso</h4>
                        <p class="text-xs text-gray-500">Pembina UKM</p>
                        <p class="text-xs font-bold text-gray-400 mt-1 flex items-center gap-1"><i class="fa-regular fa-clock"></i> Pending</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Box 6: Informasi -->
        <div class="bg-blue-50 rounded-xl shadow-sm border border-blue-100 p-6">
            <h3 class="text-md font-bold text-blue-900 mb-4 flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-file-lines text-sm"></i>
                </div>
                Informasi
            </h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-blue-500 uppercase tracking-wide font-semibold">Diajukan oleh</p>
                    <p class="text-sm font-bold text-blue-900 mt-0.5">Ahmad Hidayat</p>
                </div>
                
                <div>
                    <p class="text-xs text-blue-500 uppercase tracking-wide font-semibold">Tanggal Pengajuan</p>
                    <p class="text-sm font-bold text-blue-900 mt-0.5">25 Feb 2026</p>
                </div>
                
                <div>
                    <p class="text-xs text-blue-500 uppercase tracking-wide font-semibold">Total Approval</p>
                    <p class="text-sm font-bold text-blue-900 mt-0.5">2 dari 3 telah menyetujui</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
