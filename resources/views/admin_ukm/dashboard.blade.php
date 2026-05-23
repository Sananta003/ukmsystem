@extends('layouts.admin_ukm')
@section('title', 'Dashboard Admin UKM')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard UKM</h1>
    <p class="text-gray-500">Ringkasan aktivitas dan keuangan UKM Anda.</p>
</div>

<!-- 4 Card Statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-2xl">
            <i class="fa-solid fa-users"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Anggota</p>
            <h3 class="text-2xl font-black text-gray-800">{{ $totalAnggota }}</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Kegiatan</p>
            <h3 class="text-2xl font-black text-gray-800">{{ $totalKegiatan }}</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-2xl">
            <i class="fa-solid fa-arrow-trend-up"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Pemasukan</p>
            <h3 class="text-xl font-black text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-14 h-14 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-2xl">
            <i class="fa-solid fa-arrow-trend-down"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Pengeluaran</p>
            <h3 class="text-xl font-black text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<!-- Grid Chart -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Chart Keuangan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Keuangan (6 Bulan Terakhir)</h3>
        <canvas id="keuanganChart" height="250"></canvas>
    </div>

    <!-- Chart Partisipasi -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Partisipasi Kegiatan Terakhir</h3>
        <canvas id="partisipasiChart" height="250"></canvas>
    </div>
</div>

<!-- Notifikasi Terbaru -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-bold text-gray-800">Notifikasi Terbaru</h2>
        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">Lihat Semua</a>
    </div>
    
    <div class="space-y-4">
        <!-- Notif 1 -->
        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-user-plus text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-800">1 Anggota baru bergabung</p>
                <p class="text-xs text-gray-400 mt-1"><i class="fa-regular fa-clock mr-1"></i> 10 menit lalu</p>
            </div>
        </div>
        
        <!-- Notif 2 -->
        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-calendar text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-800">Kegiatan "Workshop Design" besok</p>
                <p class="text-xs text-gray-400 mt-1"><i class="fa-regular fa-clock mr-1"></i> 2 jam lalu</p>
            </div>
        </div>
        
        <!-- Notif 3 -->
        <div class="flex items-start gap-4 pb-4 border-b border-gray-50">
            <div class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-money-bill-wave text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-800">Pemasukan dana Rp 3.000.000</p>
                <p class="text-xs text-gray-400 mt-1"><i class="fa-regular fa-clock mr-1"></i> 5 jam lalu</p>
            </div>
        </div>
        
        <!-- Notif 4 -->
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                <i class="fa-regular fa-bell text-sm"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-800">Deadline laporan hari ini</p>
                <p class="text-xs text-gray-400 mt-1"><i class="fa-regular fa-clock mr-1"></i> 12 jam lalu</p>
            </div>
        </div>
    </div>
</div>

<!-- Kegiatan Mendatang -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Kegiatan Mendatang</h2>
        <a href="{{ route('admin-ukm.kegiatan.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition-colors">
            Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
        </a>
    </div>

    @if($kegiatanMendatang->count() > 0)
    <div class="space-y-4">
        @foreach($kegiatanMendatang as $kegiatan)
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex flex-col items-center justify-center shrink-0">
                    <span class="text-xs font-bold">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('M') }}</span>
                    <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d') }}</span>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800">{{ $kegiatan->nama_kegiatan }}</h4>
                    <p class="text-sm text-gray-500"><i class="fa-solid fa-location-dot mr-1"></i> {{ $kegiatan->lokasi ?? 'Lokasi belum ditentukan' }}</p>
                </div>
            </div>
            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $kegiatan->status == 'Direncanakan' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                {{ $kegiatan->status ?? 'Direncanakan' }}
            </span>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8 text-gray-500">
        <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-gray-300"></i>
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