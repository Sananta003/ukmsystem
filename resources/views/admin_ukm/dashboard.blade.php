@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <x-badge role="admin_ukm" icon="fa-shield-halved">Administrator UKM</x-badge>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-3">Ringkasan Aktivitas</h1>
    <p class="text-gray-500 dark:text-slate-400 mt-1">Pantau performa dan keuangan UKM Anda secara keseluruhan.</p>
</div>

<!-- 4 Card Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">Total Anggota</p>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalAnggota }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">Total Kegiatan</p>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalKegiatan }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-arrow-trend-up"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">Total Pemasukan</p>
            <h3 class="text-xl font-black text-gray-900 dark:text-white">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center text-xl">
            <i class="fa-solid fa-arrow-trend-down"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium">Total Pengeluaran</p>
            <h3 class="text-xl font-black text-gray-900 dark:text-white">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<!-- Grid Chart -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tren Keuangan (6 Bulan Terakhir)</h3>
        <div class="relative h-[250px] w-full">
            <canvas id="keuanganChart"></canvas>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Partisipasi Kegiatan Terakhir</h3>
        <div class="relative h-[250px] w-full">
            <canvas id="partisipasiChart"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Kegiatan Mendatang -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 p-6 flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Kegiatan Mendatang</h2>
            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm">
                Lihat Semua
            </a>
        </div>

        @if($kegiatanMendatang->count() > 0)
        <div class="space-y-3 flex-1">
            @foreach($kegiatanMendatang as $kegiatan)
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-lg border border-gray-200/70 dark:border-slate-700">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 text-blue-600 dark:text-blue-400 rounded-md flex flex-col items-center justify-center shrink-0">
                        <span class="text-[10px] font-bold uppercase">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('M') }}</span>
                        <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d') }}</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ $kegiatan->nama_kegiatan }}</h4>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5"><i class="fa-solid fa-location-dot w-3"></i> {{ $kegiatan->lokasi ?? 'Lokasi belum ditentukan' }}</p>
                    </div>
                </div>
                <x-badge :role="$kegiatan->status == 'Direncanakan' ? 'bpm' : 'admin_ukm'" icon="fa-tag">
                    {{ $kegiatan->status ?? 'Direncanakan' }}
                </x-badge>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex-1 flex flex-col items-center justify-center py-8">
            <i class="fa-regular fa-calendar-xmark text-4xl text-gray-300 dark:text-slate-600 mb-3"></i>
            <p class="text-sm text-gray-500 dark:text-slate-400">Belum ada kegiatan mendatang.</p>
        </div>
        @endif
    </div>

    <!-- Notifikasi Terbaru -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200/70 dark:border-slate-700 p-6 flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Notifikasi Terbaru</h2>
        </div>
        
        <div class="space-y-4 flex-1">
            @if(isset($notifikasi) && $notifikasi->count() > 0)
                @foreach($notifikasi as $notif)
                <div class="flex items-start gap-3 pb-4 {{ !$loop->last ? 'border-b border-gray-100 dark:border-slate-700/50' : '' }}">
                    <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-500 dark:text-blue-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid {{ $notif->icon ?? 'fa-bell' }} text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 dark:text-slate-200">{{ $notif->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">{{ $notif->time }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="flex-1 flex flex-col items-center justify-center py-8">
                    <i class="fa-regular fa-bell-slash text-4xl text-gray-300 dark:text-slate-600 mb-3"></i>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Belum ada notifikasi terbaru.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari Controller
    const bulanLabels = @json($bulanLabels);
    const pemasukanData = @json($pemasukanData);
    const pengeluaranData = @json($pengeluaranData);
    
    const kegiatanLabels = @json($kegiatanLabels);
    const partisipasiData = @json($partisipasiData);

    const ctxKeuangan = document.getElementById('keuanganChart').getContext('2d');
    new Chart(ctxKeuangan, {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: pemasukanData,
                    borderColor: '#2563eb', // blue-600
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    borderColor: '#dc2626', // red-600
                    backgroundColor: 'rgba(220, 38, 38, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    const ctxPartisipasi = document.getElementById('partisipasiChart').getContext('2d');
    new Chart(ctxPartisipasi, {
        type: 'bar',
        data: {
            labels: kegiatanLabels,
            datasets: [{
                label: 'Peserta',
                data: partisipasiData,
                backgroundColor: '#2563eb', // blue-600
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection
