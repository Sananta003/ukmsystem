@extends('layouts.member')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    @if(Auth::user()->ukm_id && $ukm)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -mr-20 -mt-20"></div>

            <div class="relative flex flex-col md:flex-row items-center md:items-start gap-6">
                <div class="w-24 h-24 rounded-2xl bg-white border-2 border-gray-100 flex items-center justify-center overflow-hidden shadow-sm flex-shrink-0">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/'.$ukm->logo) }}" alt="{{ $ukm->nama_ukm }}" class="w-full h-full object-cover">
                    @else
                        <i class="fa-solid fa-users text-4xl text-gray-300"></i>
                    @endif
                </div>

                <div class="text-center md:text-left">
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Member Aktif</span>
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Dashboard {{ $ukm->nama_ukm }}</h1>
                    <p class="text-gray-600 leading-relaxed max-w-2xl">{{ $ukm->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-500 text-sm font-medium">Total Anggota</span>
                        <i class="fa-solid fa-users text-blue-600 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalAnggota }}</p>
                    <p class="text-xs text-gray-400 mt-1">Anggota aktif</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-500 text-sm font-medium">Kegiatan Aktif</span>
                        <i class="fa-solid fa-calendar-check text-green-600 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">{{ $kegiatanAktif }}</p>
                    <p class="text-xs text-gray-400 mt-1">Kegiatan berjalan</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-50 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-500 text-sm font-medium">Pemasukan</span>
                        <i class="fa-solid fa-arrow-trend-up text-purple-600 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($pemasukan ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Total pemasukan</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-orange-50 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-500 text-sm font-medium">Saldo Kas</span>
                        <i class="fa-solid fa-wallet text-orange-600 text-lg"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Saldo tersedia</p>
                </div>
            </div>
        </div>

        <!-- Grafik Keuangan -->
        @if(count($labelBulan) > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-6">Laporan Keuangan Bulanan</h2>
                <div style="height: 300px;">
                    <canvas id="finansialChart"></canvas>
                </div>
            </div>
        @endif

        <!-- Welcome Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-1 md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Selamat datang, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-gray-600 mb-4">Anda adalah Admin dari {{ $ukm->nama_ukm }}. Dashboard ini menampilkan ringkasan data UKM Anda termasuk anggota, kegiatan, dan laporan keuangan.</p>
            </div>
            
            <div class="bg-gradient-to-br from-green-600 to-green-800 rounded-2xl shadow-md p-6 text-white text-center">
                <i class="fa-solid fa-chart-line text-4xl mb-4 opacity-80"></i>
                <h3 class="text-lg font-bold mb-2">Manajemen UKM</h3>
                <p class="text-green-100 text-sm mb-4">Kelola semua aspek organisasi Anda</p>
                <a href="{{ route('admin-ukm.kegiatan.index') }}" class="inline-block bg-white text-green-600 font-semibold px-4 py-2 rounded-lg hover:bg-green-50 transition-colors">
                    Kelola Data
                </a>
            </div>
        </div>

    @else
        <div class="bg-indigo-50 border border-indigo-200 rounded-3xl p-10 text-center max-w-3xl mx-auto mt-10 shadow-sm relative overflow-hidden">
            <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Langkah Selanjutnya: Ajukan Proposal</h2>
            <p class="text-gray-600 mb-8 text-lg">Anda terdaftar sebagai calon Inisiator UKM. Lengkapi formulir pengajuan Visi, Misi, dan Logo UKM baru Anda agar dapat ditinjau oleh pihak Kampus.</p>
            
            <a href="{{ route('member.pengajuan.create') }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-indigo-200 hover:-translate-y-0.5">
                Mulai Isi Formulir Pengajuan <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    @endif

</div>

@if(count($labelBulan) > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('finansialChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelBulan) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($dataPemasukan) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($dataPengeluaran) !!},
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: { size: 14, weight: '600' },
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            },
                            font: { size: 12 }
                        },
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    });
</script>
@endif

@endsection