@extends('layouts.admin_ukm')
@section('title', 'Dashboard Admin UKM')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 pb-8">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard {{ $ukm->nama_ukm ?? 'UKM' }}</h1>
            <p class="text-gray-500 text-sm">Ringkasan aktivitas dan laporan organisasi Anda.</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Total Anggota</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalAnggota ?? 249 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <p class="text-xs text-green-600 font-medium"><i class="fa-solid fa-arrow-up mr-1"></i> +5.2% bulan ini</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Total Kegiatan</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $kegiatanAktif ?? 22 }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
            </div>
            <p class="text-xs text-green-600 font-medium"><i class="fa-solid fa-arrow-up mr-1"></i> +12% bulan ini</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Total Pemasukan</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ isset($pemasukan) ? number_format($pemasukan, 0, ',', '.') : '45.2M' }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
            </div>
            <p class="text-xs text-green-600 font-medium"><i class="fa-solid fa-arrow-up mr-1"></i> +2.4% bulan ini</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-500 text-xs font-medium uppercase tracking-wider mb-1">Total Pengeluaran</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ isset($pengeluaran) ? number_format($pengeluaran, 0, ',', '.') : '28.5M' }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                </div>
            </div>
            <p class="text-xs text-red-600 font-medium"><i class="fa-solid fa-arrow-down mr-1"></i> -4% bulan ini</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-1">Grafik Keuangan</h3>
            <p class="text-xs text-gray-500 mb-6">Pemasukan dan pengeluaran 6 bulan terakhir</p>
            <div class="h-64">
                <canvas id="keuanganChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-1">Partisipasi Kegiatan</h3>
            <p class="text-xs text-gray-500 mb-6">Jumlah peserta per jenis kegiatan</p>
            <div class="h-64">
                <canvas id="partisipasiChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Notifications & Upcoming -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Notifikasi -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Notifikasi Terbaru</h3>
                    <p class="text-xs text-gray-500">Aktivitas terbaru sistem</p>
                </div>
                <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-800">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">3 Anggota baru bergabung</p>
                        <p class="text-xs text-gray-500 mt-1">10 menit yang lalu</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 shrink-0">
                        <i class="fa-solid fa-calendar text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Kegiatan "Workshop Design" Selesai</p>
                        <p class="text-xs text-gray-500 mt-1">1 hari yang lalu</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600 shrink-0">
                        <i class="fa-solid fa-money-bill-wave text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Pemasukan dana Rp 2.000.000</p>
                        <p class="text-xs text-gray-500 mt-1">2 hari yang lalu</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 shrink-0">
                        <i class="fa-solid fa-file-invoice text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Laporan kegiatan ditolak BEM</p>
                        <p class="text-xs text-gray-500 mt-1">3 hari yang lalu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kegiatan Mendatang -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Kegiatan Mendatang</h3>
                    <p class="text-xs text-gray-500">Jadwal kegiatan dalam waktu dekat</p>
                </div>
                <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-800">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                <div class="border border-blue-100 bg-blue-50/30 rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Workshop UI/UX Design</h4>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                            <span><i class="fa-regular fa-calendar mr-1"></i> 28 Feb 2026</span>
                            <span><i class="fa-regular fa-clock mr-1"></i> 13:00 - Selesai</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded">H-7</span>
                </div>
                <div class="border border-purple-100 bg-purple-50/30 rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Pelatihan Public Speaking</h4>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                            <span><i class="fa-regular fa-calendar mr-1"></i> 1 Mar 2026</span>
                            <span><i class="fa-regular fa-clock mr-1"></i> 09:00 - 12:00</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded">H-8</span>
                </div>
                <div class="border border-green-100 bg-green-50/30 rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Seminar Kewirausahaan</h4>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                            <span><i class="fa-regular fa-calendar mr-1"></i> 15 Mar 2026</span>
                            <span><i class="fa-regular fa-clock mr-1"></i> 10:00 - 15:00</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">H-22</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxKeuangan = document.getElementById('keuanganChart').getContext('2d');
        new Chart(ctxKeuangan, {
            type: 'line',
            data: {
                labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: [35000, 38000, 32000, 41000, 39000, 45200],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4
                    },
                    {
                        label: 'Pengeluaran',
                        data: [25000, 28000, 22000, 29000, 27000, 28500],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, usePointStyle: true } } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4] }, ticks: { callback: function(val) { return val / 1000 + 'k'; } } },
                    x: { grid: { display: false } }
                }
            }
        });

        const ctxPartisipasi = document.getElementById('partisipasiChart').getContext('2d');
        new Chart(ctxPartisipasi, {
            type: 'bar',
            data: {
                labels: ['Seminar', 'Workshop', 'Pelatihan', 'Pengabdian', 'Bakti Sosial', 'Study Tour'],
                datasets: [{
                    label: 'Peserta',
                    data: [65, 45, 80, 35, 55, 40],
                    backgroundColor: '#3b82f6',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, usePointStyle: true } } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection