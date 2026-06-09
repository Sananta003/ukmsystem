@extends('layouts.member')
@section('title', 'Agenda Kegiatan')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Agenda & Riwayat Kegiatan</h2>
        <p class="text-sm text-gray-500">Seluruh jadwal kegiatan UKM Anda.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="border-b border-gray-200 bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pelaksanaan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kegiatan as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 font-bold text-blue-600">{{ $item->nama_kegiatan }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->lokasi ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                            {{ $item->status == 'Selesai' ? 'bg-green-100 text-green-700' : ($item->status == 'Berjalan' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-gray-500">Belum ada riwayat kegiatan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $kegiatan->links() }}</div>
</div>
@endsection