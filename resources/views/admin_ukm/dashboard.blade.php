@extends('layouts.admin')

@section('title', 'Dashboard Admin UKM')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Admin UKM</h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan statistik dan aktivitas UKM Anda.</p>
    </div>
</div>

<!-- Grid 4 Card -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Anggota</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalAnggota }}</p>
        </div>
        <div class="p-4 bg-blue-50 text-blue-600 rounded-xl dark:bg-blue-900/30 dark:text-blue-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kegiatan</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalKegiatan }}</p>
        </div>
        <div class="p-4 bg-indigo-50 text-indigo-600 rounded-xl dark:bg-indigo-900/30 dark:text-indigo-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pemasukan</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-green-50 text-green-600 rounded-xl dark:bg-green-900/30 dark:text-green-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
        <div class="p-4 bg-red-50 text-red-600 rounded-xl dark:bg-red-900/30 dark:text-red-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path></svg>
        </div>
    </div>
</div>

<!-- Charts Grid -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tren Keuangan 6 Bulan Terakhir</h3>
        <div class="relative h-72 w-full">
            <canvas id="keuanganChart"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Partisipasi Peserta 6 Kegiatan Terakhir</h3>
        <div class="relative h-72 w-full">
            <canvas id="partisipasiChart"></canvas>
        </div>
    </div>
</div>

<!-- Kegiatan Mendatang -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Kegiatan Mendatang</h3>
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Lihat Semua</a>
    </div>
    <div class="p-6">
        @if($kegiatanMendatang->isEmpty())
            <div class="text-center py-6">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada kegiatan</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada agenda kegiatan mendatang.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($kegiatanMendatang as $keg)
                <div class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <div class="flex-shrink-0 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 w-12 h-12 rounded-lg flex flex-col items-center justify-center font-bold">
                        <span class="text-sm leading-none">{{ \Carbon\Carbon::parse($keg->tanggal)->format('d') }}</span>
                        <span class="text-xs leading-none uppercase">{{ \Carbon\Carbon::parse($keg->tanggal)->format('M') }}</span>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-base font-semibold text-gray-900 dark:text-white">{{ $keg->nama_kegiatan }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $keg->lokasi ?? 'Lokasi belum ditentukan' }}
                        </p>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                            {{ $keg->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Line Chart: Keuangan
        const ctxKeuangan = document.getElementById('keuanganChart').getContext('2d');
        new Chart(ctxKeuangan, {
            type: 'line',
            data: {
                labels: @json($bulanLabels),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($pemasukanData),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($pengeluaranData),
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Bar Chart: Partisipasi Kegiatan
        const ctxPartisipasi = document.getElementById('partisipasiChart').getContext('2d');
        new Chart(ctxPartisipasi, {
            type: 'bar',
            data: {
                labels: @json($kegiatanLabels),
                datasets: [{
                    label: 'Jumlah Peserta / Pendaftar',
                    data: @json($partisipasiData),
                    backgroundColor: '#6366F1',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endpush
@endsection