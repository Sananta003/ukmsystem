@extends('layouts.admin_ukm')
@section('title', 'Daftar Proposal Kegiatan')

@section('content')
<div class="w-full pb-10">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-slate-100 transition-colors">Proposal Kegiatan</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-2 transition-colors">Pilih kegiatan untuk mengelola pengajuan dan persetujuan proposal.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/80 dark:bg-slate-900/50 text-gray-500 dark:text-slate-400 text-xs uppercase tracking-wider font-bold border-b border-gray-100 dark:border-slate-700 transition-colors">
                        <th class="p-5">Informasi Kegiatan</th>
                        <th class="p-5">Tanggal</th>
                        <th class="p-5">Status Proposal</th>
                        <th class="p-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                    @forelse($kegiatans as $item)
                    @php
                        $proposal = \App\Models\Proposal::where('kegiatan_id', $item->id)->first();
                        $statusProposal = $proposal ? $proposal->status_akhir : 'Belum Ada';
                    @endphp
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-slate-700/30 transition-colors group">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 transition-colors">
                                    <i class="fa-solid fa-file-signature"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-slate-200 group-hover:text-brand-accent transition-colors">{{ $item->nama_kegiatan }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5 transition-colors">ID: #{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-5">
                            <div class="text-sm font-medium text-gray-800 dark:text-slate-200 transition-colors">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</div>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border
                                {{ $statusProposal == 'Disetujui' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' : 
                                  ($statusProposal == 'Belum Ada' ? 'bg-gray-50 text-gray-600 border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700' : 
                                  ($statusProposal == 'Ditolak' ? 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800/50' : 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50')) }} transition-colors">
                                {{ $statusProposal }}
                            </span>
                        </td>
                        <td class="p-5 text-right">
                            <a href="{{ route('admin-ukm.proposal.show', $item->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 hover:text-white font-bold rounded-lg text-sm transition-colors border border-indigo-100 dark:border-indigo-800/50 hover:border-indigo-600">
                                Cek Proposal
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500 mb-4 transition-colors">
                                <i class="fa-solid fa-folder-open text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-slate-200 mb-1 transition-colors">Belum Ada Kegiatan</h3>
                            <p class="text-gray-500 dark:text-slate-400 text-sm transition-colors">Tambahkan kegiatan terlebih dahulu di menu Kegiatan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
