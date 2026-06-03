@extends('layouts.member')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Dashboard {{ strtoupper(Auth::user()->role) }}</h1>
            <p class="text-gray-500 mt-2">Daftar Pengajuan UKM Baru dan Proposal Kegiatan yang memerlukan tinjauan.</p>
        </div>
    </div>

    <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-2xl shadow-xl border border-white/60 dark:border-slate-700 overflow-hidden transition-all duration-300">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse backdrop-blur-sm">
                <thead>
                    <tr class="bg-white/40 dark:bg-slate-800/40 text-gray-700 dark:text-slate-300 uppercase text-xs font-bold tracking-wider border-b border-gray-200 dark:border-slate-700">
                        <th class="p-4">Tgl Pengajuan</th>
                        <th class="p-4">Pengaju</th>
                        <th class="p-4">Jenis Pengajuan</th>
                        <th class="p-4">Detail Tambahan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Loop Pengajuan UKM Baru --}}
                    @foreach($pengajuans as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-600">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-sm font-medium text-gray-800">{{ $item->user->name }}</td>
                            <td class="p-4">
                                <span class="bg-purple-100 text-purple-700 text-xs px-2.5 py-1 rounded-md font-bold border border-purple-200">
                                    <i class="fa-solid fa-users mr-1"></i> Pembentukan UKM Baru
                                </span>
                            </td>
                            <td class="p-4 text-sm font-bold text-indigo-600">{{ $item->nama_ukm }}</td>
                            <td class="p-4">
                                @if($item->status == 'pending_bem' || $item->status == 'pending_bpm')
                                    <x-role-badge role="{{ Auth::user()->role === 'bem' ? 'bem' : 'bpm' }}">Menunggu Tinjauan</x-role-badge>
                                @else
                                    <x-role-badge role="inisiator">Sedang Direvisi</x-role-badge>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('birokrasi.pengajuan.show', $item->id) }}" class="inline-flex items-center text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg px-4 py-2 transition-colors">
                                    Detail & Review <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    {{-- Loop Proposal Kegiatan --}}
                    @foreach($proposals as $approval)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-600">{{ $approval->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-sm font-medium text-gray-800">{{ $approval->proposal->kegiatan->ukm->nama_ukm }}</td>
                            <td class="p-4">
                                <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-md font-bold border border-emerald-200">
                                    <i class="fa-solid fa-file-pdf mr-1"></i> Proposal Kegiatan
                                </span>
                            </td>
                            <td class="p-4 text-sm font-bold text-gray-800">{{ $approval->proposal->kegiatan->nama_kegiatan }}</td>
                            <td class="p-4">
                                @if($approval->status == 'pending')
                                    <x-role-badge role="{{ Auth::user()->role === 'bem' ? 'bem' : 'bpm' }}">Menunggu Persetujuan</x-role-badge>
                                @elseif($approval->status == 'approved')
                                    <x-role-badge role="{{ Auth::user()->role === 'bem' ? 'bem' : 'bpm' }}">Telah Disetujui</x-role-badge>
                                @else
                                    <x-role-badge role="admin_ukm">Sedang Direvisi</x-role-badge>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('birokrasi.proposal.show', $approval->proposal->id) }}" class="inline-flex items-center text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg px-4 py-2 transition-colors">
                                    Review <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if(count($pengajuans) == 0 && count($proposals) == 0)
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                <i class="fa-solid fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada pengajuan atau proposal baru yang masuk.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
