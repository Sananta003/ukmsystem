@extends('layouts.admin_ukm')
@section('title', 'Manajemen Kegiatan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Kegiatan</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola kegiatan dan acara UKM Anda</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <form action="{{ route('admin-ukm.kegiatan.index') }}" method="GET" class="flex flex-1 gap-4 max-w-2xl">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan atau lokasi..." 
                            class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow">
                    </div>
                    <button type="button" class="px-4 py-2.5 border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="px-4 py-2.5 text-red-500 border border-red-100 rounded-lg hover:bg-red-50 transition-colors flex items-center justify-center text-sm font-medium">Reset</a>
                    @endif
                </form>
                <a href="{{ route('admin-ukm.kegiatan.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow-sm shadow-blue-500/30 flex items-center justify-center whitespace-nowrap">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Kegiatan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Anggaran</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Realisasi</th>
                        <th class="px-6 py-4 text-center"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kegiatan as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-5 text-sm font-semibold text-gray-800">{{ $item->nama }}</td>
                        <td class="px-6 py-5 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M') }}<br>
                            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($item->tanggal)->format('Y') }}</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-600">{{ $item->lokasi ?? '-' }}</td>
                        <td class="px-6 py-5">
                            @php
                                $statusClass = match($item->status) {
                                    'Selesai' => 'bg-green-100 text-green-700',
                                    'Berjalan' => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-blue-100 text-blue-700',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold tracking-wide {{ $statusClass }}">
                                {{ $item->status ?? 'Direncanakan' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-gray-800">
                            Rp {{ number_format($item->anggaran ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm font-bold text-gray-800 mb-1">Rp {{ number_format($item->realisasi ?? 0, 0, ',', '.') }}</div>
                            @if(isset($item->anggaran) && $item->anggaran > 0)
                            <div class="text-[10px] text-gray-400 font-medium">{{ round(($item->realisasi / $item->anggaran) * 100) }}% dari anggaran</div>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right space-x-2">
                            <a href="{{ route('admin-ukm.kegiatan.show', $item->id) }}" class="text-gray-400 hover:text-blue-600 transition-colors" title="Lihat Detail">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-regular fa-calendar-xmark text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-sm font-medium text-gray-900">Belum ada kegiatan</h3>
                            <p class="text-xs text-gray-500 mt-1">Mulai tambahkan kegiatan baru untuk UKM Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kegiatan->hasPages())
        <div class="p-4 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-500">
                Menampilkan {{ $kegiatan->firstItem() }} - {{ $kegiatan->lastItem() }} dari {{ $kegiatan->total() }} kegiatan
            </span>
            <div>
                {{ $kegiatan->links('pagination::tailwind') }}
            </div>
        </div>
        @else
        <div class="p-4 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-500">
                Menampilkan {{ $kegiatan->count() }} kegiatan
            </span>
        </div>
        @endif
    </div>
</div>
@endsection