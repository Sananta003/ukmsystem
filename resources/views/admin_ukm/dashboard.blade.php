@extends('layouts.admin_ukm')
@section('title', 'Dashboard Admin UKM')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Dashboard UKM</h1>
    <p class="text-gray-500 dark:text-slate-400 transition-colors">Ringkasan aktivitas dan keuangan UKM Anda.</p>
</div>

<!-- 4 Card Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 transition-colors">
        <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center text-2xl transition-colors">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium transition-colors">Total Anggota</p>
            <h3 class="text-2xl font-black text-gray-800 dark:text-slate-100 transition-colors">{{ $totalAnggota }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 transition-colors">
        <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl flex items-center justify-center text-2xl transition-colors">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium transition-colors">Total Kegiatan</p>
            <h3 class="text-2xl font-black text-gray-800 dark:text-slate-100 transition-colors">{{ $totalKegiatan }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 transition-colors">
        <div class="w-14 h-14 bg-green-50 dark:bg-green-900/40 text-green-600 dark:text-green-400 rounded-xl flex items-center justify-center text-2xl transition-colors">
            <i class="fa-solid fa-arrow-trend-up"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium transition-colors">Total Pemasukan</p>
            <h3 class="text-xl font-black text-gray-800 dark:text-slate-100 transition-colors">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center gap-4 transition-colors">
        <div class="w-14 h-14 bg-red-50 dark:bg-red-900/40 text-red-600 dark:text-red-400 rounded-xl flex items-center justify-center text-2xl transition-colors">
            <i class="fa-solid fa-arrow-trend-down"></i>
        </div>
        <div>
            <p class="text-gray-500 dark:text-slate-400 text-sm font-medium transition-colors">Total Pengeluaran</p>
            <h3 class="text-xl font-black text-gray-800 dark:text-slate-100 transition-colors">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<!-- Grid Chart -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Chart Keuangan -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 transition-colors">
        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-4 transition-colors">Tren Keuangan (6 Bulan Terakhir)</h3>
        <div class="relative h-[250px] w-full">
            <canvas id="keuanganChart"></canvas>
        </div>
    </div>

    <!-- Chart Partisipasi -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 transition-colors">
        <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100 mb-4 transition-colors">Partisipasi Kegiatan Terakhir</h3>
        <div class="relative h-[250px] w-full">
            <canvas id="partisipasiChart"></canvas>
        </div>
    </div>
</div>

<!-- Notifikasi Terbaru -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-8 transition-colors">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-slate-700 pb-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Notifikasi Terbaru</h2>
    </div>
    
    <div class="space-y-4">
        @if(isset($notifikasi) && $notifikasi->count() > 0)
            @foreach($notifikasi as $notif)
            <div class="flex items-start gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-50 dark:border-slate-700/50' : '' }} transition-colors">
                <div class="w-10 h-10 rounded-full bg-{{ $notif->color }}-50 dark:bg-{{ $notif->color }}-900/30 text-{{ $notif->color }}-500 dark:text-{{ $notif->color }}-400 flex items-center justify-center shrink-0 transition-colors">
                    <i class="fa-solid {{ $notif->icon }} text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 dark:text-slate-200 transition-colors">{{ $notif->title }}</p>
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-1 transition-colors"><i class="fa-regular fa-clock mr-1"></i> {{ $notif->time }}</p>
                </div>
            </div>
            @endforeach
        @else
            <div class="text-center py-6 text-gray-500 dark:text-slate-400 transition-colors">
                <i class="fa-regular fa-bell-slash text-3xl mb-3 text-gray-300 dark:text-slate-600"></i>
                <p>Belum ada notifikasi terbaru.</p>
            </div>
        @endif
    </div>
</div>

<!-- Kegiatan Mendatang -->
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 dark:border-slate-700 pb-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-slate-100 transition-colors">Kegiatan Mendatang</h2>
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium text-sm transition-colors">
            Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
        </a>
    </div>

    @if($kegiatanMendatang->count() > 0)
    <div class="space-y-4">
        @foreach($kegiatanMendatang as $kegiatan)
        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-xl border border-gray-100 dark:border-slate-700/50 transition-colors">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg flex flex-col items-center justify-center shrink-0 transition-colors">
                    <span class="text-xs font-bold">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('M') }}</span>
                    <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d') }}</span>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 dark:text-slate-200 transition-colors">{{ $kegiatan->nama_kegiatan }}</h4>
                    <p class="text-sm text-gray-500 dark:text-slate-400 transition-colors"><i class="fa-solid fa-location-dot mr-1"></i> {{ $kegiatan->lokasi ?? 'Lokasi belum ditentukan' }}</p>
                </div>
            </div>
            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $kegiatan->status == 'Direncanakan' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-400' }} transition-colors">
                {{ $kegiatan->status ?? 'Direncanakan' }}
            </span>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8 text-gray-500 dark:text-slate-400 transition-colors">
        <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-gray-300 dark:text-slate-600"></i>
        <p>Belum ada kegiatan mendatang.</p>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari Controller
    const bulanLabels = @json($bulanLabels);
    const pemasukanData = @json($pemasukanData);
    const pengeluaranData = @json($pengeluaranData);
    
    const kegiatanLabels = @json($kegiatanLabels);
    const partisipasiData = @json($partisipasiData);

    // Render Line Chart Keuangan
    const ctxKeuangan = document.getElementById('keuanganChart').getContext('2d');
    new Chart(ctxKeuangan, {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: pemasukanData,
                    borderColor: '#10b981', // green-500
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    borderColor: '#ef4444', // red-500
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); } } }
            }
        }
    });

    // Render Bar Chart Partisipasi
    const ctxPartisipasi = document.getElementById('partisipasiChart').getContext('2d');
    new Chart(ctxPartisipasi, {
        type: 'bar',
        data: {
            labels: kegiatanLabels,
            datasets: [{
                label: 'Jumlah Pendaftar/Peserta',
                data: partisipasiData,
                backgroundColor: '#6366f1', // indigo-500
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection