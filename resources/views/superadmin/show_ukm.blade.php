@extends('layouts.app')
@section('title', 'Pantau UKM: ' . $ukm->nama_ukm)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="{{ route('superadmin.dashboard') }}" class="text-gray-500 hover:text-purple-600 font-medium text-sm mb-2 inline-block">&larr; Kembali ke Dashboard</a>
        <h2 class="text-2xl font-black text-gray-800 flex items-center gap-3">
            @if($ukm->logo) <img src="{{ asset('storage/'.$ukm->logo) }}" class="w-8 h-8 rounded border"> @endif
            Pantauan: {{ $ukm->nama_ukm }}
        </h2>
    </div>
</div>

<div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-green-500">
        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pemasukan Kas</p>
        <h3 class="text-xl font-bold text-green-600">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm border-l-4 border-l-red-500">
        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Pengeluaran Kas</p>
        <h3 class="text-xl font-bold text-red-600">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-purple-600 p-5 rounded-2xl border border-purple-700 shadow-sm text-white">
        <p class="text-xs text-purple-200 font-bold uppercase tracking-wider mb-1">Sisa Saldo Tersedia</p>
        <h3 class="text-xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Diagram Serapan Anggaran Program</h3>
        <div class="h-64 relative">
            @if(count($grafikPengeluaran) > 0)
                <canvas id="expenseChart"></canvas>
            @else
                <div class="flex h-full items-center justify-center text-gray-400 text-sm italic">Belum ada data pengeluaran program.</div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm overflow-hidden flex flex-col">
        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Daftar Anggota ({{ $anggota->count() }})</h3>
        <div class="flex-1 overflow-y-auto max-h-64 space-y-3 pr-2">
            @forelse($anggota as $mhs)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 font-bold text-xs flex items-center justify-center uppercase">{{ substr($mhs->name, 0, 2) }}</div>
                    <div>
                        <p class="text-sm font-bold text-gray-800 leading-tight">{{ $mhs->name }}</p>
                        <p class="text-xs text-gray-500">{{ $mhs->email }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada anggota.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Pantauan Proposal & Kegiatan</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500">
                <tr>
                    <th class="p-3 rounded-tl-lg">Tanggal</th>
                    <th class="p-3">Nama Program/Kegiatan</th>
                    <th class="p-3">Anggaran (Rp)</th>
                    <th class="p-3">Terserap (Rp)</th>
                    <th class="p-3 rounded-tr-lg">Status Laporan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kegiatan as $keg)
                <tr class="hover:bg-gray-50">
                    <td class="p-3">{{ \Carbon\Carbon::parse($keg->tanggal)->format('d M Y') }}</td>
                    <td class="p-3 font-bold text-gray-800">{{ $keg->nama_kegiatan }}</td>
                    <td class="p-3 text-blue-600">{{ number_format($keg->anggaran, 0, ',', '.') }}</td>
                    <td class="p-3 text-red-600">{{ number_format($keg->realisasi, 0, ',', '.') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-bold 
                            {{ $keg->status == 'Selesai' ? 'bg-green-100 text-green-700' : ($keg->status == 'Berjalan' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                            {{ $keg->status == 'Selesai' ? '✔ Laporan Selesai' : '⏳ ' . $keg->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-4 text-center text-gray-500">Belum ada proposal program yang diajukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(count($grafikPengeluaran) > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('expenseChart').getContext('2d');
        const labels = {!! json_encode($grafikPengeluaran->pluck('nama_program')) !!};
        const data = {!! json_encode($grafikPengeluaran->pluck('total')) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Pengeluaran (Rp)',
                    data: data,
                    backgroundColor: 'rgba(147, 51, 234, 0.2)',
                    borderColor: 'rgba(147, 51, 234, 1)',
                    borderWidth: 2,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endif
@endsection
