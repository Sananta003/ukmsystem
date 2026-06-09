@extends('layouts.app')
@section('title', 'Dashboard Admin UKM')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-start justify-between gap-4">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <x-badge role="admin_ukm">Administrator UKM</x-badge>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Ringkasan Aktivitas</h1>
        <p class="text-gray-500 mt-1 text-sm">Pantau performa dan keuangan UKM Anda secara keseluruhan.</p>
    </div>
    
    <div>
        <a href="{{ route('admin-ukm.kegiatan.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-slate-800 border border-transparent rounded-md shadow-sm hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors">
            <i class="fa-solid fa-plus mr-2"></i> Buat Kegiatan
        </a>
    </div>
</div>

<!-- 4 Card Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <p class="text-gray-500 text-sm font-medium">Total Anggota</p>
            <i class="fa-solid fa-users text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $totalAnggota }}</h3>
    </div>
    
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <p class="text-gray-500 text-sm font-medium">Total Kegiatan</p>
            <i class="fa-solid fa-calendar-check text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900">{{ $totalKegiatan }}</h3>
    </div>
    
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <p class="text-gray-500 text-sm font-medium">Total Pemasukan</p>
            <i class="fa-solid fa-arrow-trend-up text-gray-400"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
    </div>
    
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex flex-col">
        <div class="flex items-center justify-between mb-4">
            <p class="text-gray-500 text-sm font-medium">Total Pengeluaran</p>
            <i class="fa-solid fa-arrow-trend-down text-gray-400"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
    </div>
</div>

<!-- Grid Chart -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-base font-semibold text-gray-900 mb-4">Tren Keuangan</h3>
        <div class="relative h-[250px] w-full">
            <canvas id="keuanganChart"></canvas>
        </div>
    </div>
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
        <h3 class="text-base font-semibold text-gray-900 mb-4">Partisipasi Kegiatan</h3>
        <div class="relative h-[250px] w-full">
            <canvas id="partisipasiChart"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
    <!-- Kegiatan Mendatang -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col">
        <div class="flex justify-between items-center p-5 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Kegiatan Mendatang</h2>
            <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-slate-600 hover:text-slate-900 font-medium text-sm transition-colors">
                Lihat Semua
            </a>
        </div>

        <div class="p-0 flex-1">
            @if($kegiatanMendatang->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($kegiatanMendatang as $kegiatan)
                <li class="p-5 hover:bg-gray-50 transition-colors flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 border border-gray-200 bg-white text-gray-900 rounded flex flex-col items-center justify-center shrink-0">
                            <span class="text-[9px] font-bold uppercase text-gray-500">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('M') }}</span>
                            <span class="text-sm font-bold leading-none">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d') }}</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $kegiatan->nama_kegiatan }}</h4>
                            <p class="text-xs text-gray-500 mt-1"><i class="fa-solid fa-location-dot w-3 text-gray-400"></i> {{ $kegiatan->lokasi ?? 'Lokasi belum ditentukan' }}</p>
                        </div>
                    </div>
                    <div>
                        <x-badge :role="$kegiatan->status == 'Direncanakan' ? 'bpm' : 'admin_ukm'" icon="fa-tag">
                            {{ $kegiatan->status ?? 'Direncanakan' }}
                        </x-badge>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <i class="fa-regular fa-calendar text-3xl text-gray-300 mb-3"></i>
                <p class="text-sm text-gray-500">Belum ada kegiatan mendatang.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Notifikasi Terbaru -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col">
        <div class="flex justify-between items-center p-5 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Aktivitas Terakhir</h2>
        </div>
        
        <div class="p-0 flex-1">
            @if(isset($notifikasi) && $notifikasi->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($notifikasi as $notif)
                <li class="p-5 flex items-start gap-3 hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 rounded-full border border-gray-200 bg-gray-50 text-gray-500 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid {{ $notif->icon ?? 'fa-bell' }} text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $notif->title }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $notif->time }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <i class="fa-regular fa-bell text-3xl text-gray-300 mb-3"></i>
                <p class="text-sm text-gray-500">Belum ada aktivitas terbaru.</p>
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
                    borderColor: '#1e293b', // slate-800
                    backgroundColor: 'rgba(30, 41, 59, 0.05)',
                    borderWidth: 2,
                    tension: 0, // strict straight lines
                    fill: true,
                    pointBackgroundColor: '#1e293b',
                    pointRadius: 3
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    borderColor: '#94a3b8', // slate-400
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    tension: 0,
                    fill: false,
                    pointBackgroundColor: '#94a3b8',
                    pointRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    position: 'bottom',
                    labels: { boxWidth: 12, usePointStyle: true }
                } 
            },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#f1f5f9' }, border: { dash: [4, 4] } }
            }
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
                backgroundColor: '#334155', // slate-700
                borderRadius: 2,
                barPercentage: 0.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { 
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { dash: [4, 4] } }
            }
        }
    });
</script>
@endsection
