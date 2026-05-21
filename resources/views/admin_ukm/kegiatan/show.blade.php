@extends('layouts.admin')

@section('title', 'Detail Kegiatan - ' . $kegiatan->nama_kegiatan)

@section('content')
<!-- Header -->
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
    <div>
        <div class="flex items-center space-x-3 text-sm text-gray-500 mb-3">
            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="hover:text-indigo-600"><i class="fas fa-arrow-left mr-1"></i> Daftar Kegiatan</a>
            <span>/</span>
            <span class="text-gray-900 font-medium truncate">{{ $kegiatan->nama_kegiatan }}</span>
        </div>
        <div class="flex items-center flex-wrap gap-3">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kegiatan->nama_kegiatan }}</h1>
            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                @if($kegiatan->status == 'Direncanakan') bg-yellow-100 text-yellow-800 
                @elseif($kegiatan->status == 'Berjalan') bg-blue-100 text-blue-800 
                @else bg-green-100 text-green-800 @endif">
                {{ $kegiatan->status }}
            </span>
        </div>
        <div class="mt-2 text-sm text-gray-500 flex flex-wrap gap-4">
            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</span>
            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $kegiatan->waktu ? \Carbon\Carbon::parse($kegiatan->waktu)->format('H:i') : '-' }}</span>
            <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>{{ $kegiatan->lokasi ?? '-' }}</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Kolom Kiri: Progress & Dokumen -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Progress Bar Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Progress Pelaksanaan</h3>
            
            <!-- Progress Anggaran -->
            <div class="mb-6">
                <div class="flex justify-between items-end mb-2">
                    <div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 block">Realisasi Anggaran</span>
                        <span class="text-xs text-gray-500">Rp {{ number_format($kegiatan->realisasi_anggaran, 0, ',', '.') }} dari Rp {{ number_format($kegiatan->anggaran, 0, ',', '.') }}</span>
                    </div>
                    <span class="text-sm font-bold {{ $persenAnggaran > 90 ? 'text-red-500' : 'text-indigo-600' }}">{{ round($persenAnggaran) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 overflow-hidden">
                    <div class="{{ $persenAnggaran > 90 ? 'bg-red-500' : ($persenAnggaran > 75 ? 'bg-yellow-400' : 'bg-green-500') }} h-2.5 rounded-full transition-all duration-1000" style="width: {{ $persenAnggaran }}%"></div>
                </div>
            </div>

            <!-- Progress Peserta -->
            <div>
                <div class="flex justify-between items-end mb-2">
                    <div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 block">Pendaftar / Target Peserta</span>
                        <span class="text-xs text-gray-500">{{ $kegiatan->jumlah_pendaftar }} Orang terdaftar @if($kegiatan->target_peserta > 0) (Target: {{ $kegiatan->target_peserta }}) @endif</span>
                    </div>
                    @if($kegiatan->target_peserta > 0)
                        <span class="text-sm font-bold text-indigo-600">{{ round($persenPeserta) }}%</span>
                    @endif
                </div>
                @if($kegiatan->target_peserta > 0)
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 overflow-hidden">
                    <div class="bg-indigo-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $persenPeserta }}%"></div>
                </div>
                @else
                <div class="text-sm font-medium text-blue-600 bg-blue-50 py-2 px-3 rounded inline-block">Target Peserta Tidak Terbatas</div>
                @endif
            </div>
        </div>

        <!-- Dokumen Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Dokumen Terkait</h3>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <!-- Upload Proposal Card -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col items-center justify-center text-center hover:bg-gray-50 dark:hover:bg-gray-700/50 transition relative overflow-hidden group">
                    <div class="bg-red-100 text-red-600 p-3 rounded-full mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Proposal Kegiatan</h4>
                    @if($kegiatan->file_proposal)
                        <p class="text-xs text-green-500 mt-1 font-medium flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Tersedia</p>
                        <a href="#" class="mt-3 text-xs bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-md font-medium hover:bg-indigo-100 w-full">Download File</a>
                    @else
                        <p class="text-xs text-gray-500 mt-1">Belum ada file.</p>
                        <button class="mt-3 text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-md font-medium hover:bg-indigo-700 w-full flex items-center justify-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg> Upload Proposal</button>
                    @endif
                </div>

                <!-- Upload LPJ Card -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col items-center justify-center text-center hover:bg-gray-50 dark:hover:bg-gray-700/50 transition relative overflow-hidden group">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Laporan Kegiatan (LPJ)</h4>
                    @if($kegiatan->file_laporan)
                        <p class="text-xs text-green-500 mt-1 font-medium flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Tersedia</p>
                        <a href="#" class="mt-3 text-xs bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-md font-medium hover:bg-indigo-100 w-full">Download File</a>
                    @else
                        <p class="text-xs text-gray-500 mt-1">Belum ada file.</p>
                        <button class="mt-3 text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-md font-medium hover:bg-indigo-700 w-full flex items-center justify-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg> Upload Laporan</button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Timeline Approval -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Persetujuan</h3>
            </div>
            <div class="p-6">
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($timeline as $index => $item)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $item['done'] ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-700' }}" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800 {{ $item['done'] ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-400 dark:bg-gray-700' }}">
                                            @if($item['done'])
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            @else
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm font-medium {{ $item['done'] ? 'text-gray-900 dark:text-white' : 'text-gray-500' }}">
                                                {{ $item['status'] }} <span class="text-gray-500 font-normal">oleh {{ $item['role'] }}</span>
                                            </p>
                                        </div>
                                        <div class="text-right text-xs whitespace-nowrap text-gray-500">
                                            <time>{{ $item['waktu'] }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
