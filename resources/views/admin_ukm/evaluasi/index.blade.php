@extends('layouts.admin')

@section('title', 'Evaluasi Keseluruhan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Statistik & Evaluasi Kegiatan</h1>
    <p class="text-sm text-gray-500 mt-1">Review dari anggota terkait seluruh kegiatan UKM.</p>
</div>

<!-- Header Statistik & Grafik -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Box Rata-rata Rating -->
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl shadow-lg p-6 flex flex-col items-center justify-center text-center text-white relative overflow-hidden">
        <div class="absolute -right-10 -top-10 opacity-10">
            <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
        </div>
        <h3 class="text-lg font-medium text-indigo-100 mb-2 relative z-10">Rata-rata Penilaian Keseluruhan</h3>
        <div class="text-6xl font-extrabold tracking-tight mb-2 relative z-10">{{ number_format($rataRata, 1) }}</div>
        <div class="flex text-yellow-300 text-2xl mb-2 relative z-10">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= round($rataRata))
                    <i class="fas fa-star"></i>
                @else
                    <i class="far fa-star opacity-50"></i>
                @endif
            @endfor
        </div>
        <p class="text-sm text-indigo-200 relative z-10">Berdasarkan {{ count($evaluasis) }} total evaluasi</p>
    </div>

    <!-- Grafik Bar Distribusi Rating -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Distribusi Bintang Rating</h3>
        <div class="relative h-48 w-full">
            <canvas id="ratingChart"></canvas>
        </div>
    </div>
</div>

<!-- Daftar Komentar -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Komentar Peserta</h3>
    </div>
    
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($evaluasis as $eval)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                    <div class="flex items-center mb-2 sm:mb-0">
                        <!-- Avatar -->
                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold mr-3 shadow-sm">
                            {{ substr($eval->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $eval->user->name ?? 'Anonim' }}</h4>
                            <p class="text-xs text-gray-500">
                                Kegiatan: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $eval->kegiatan->nama_kegiatan ?? '-' }}</span> 
                                • {{ $eval->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <!-- Stars -->
                    <div class="flex text-yellow-400 text-sm bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-md border border-yellow-100 dark:border-yellow-800/50">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $eval->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="mt-3 pl-13">
                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 text-sm text-gray-700 dark:text-gray-300 border border-gray-100 dark:border-gray-700/50">
                        "{{ $eval->komentar ?? 'Hanya memberikan rating tanpa ulasan.' }}"
                    </div>
                </div>
            </div>
        @empty
            <div class="p-10 text-center flex flex-col items-center">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <h3 class="text-base font-medium text-gray-900 dark:text-white">Belum Ada Evaluasi</h3>
                <p class="mt-1 text-sm text-gray-500">Anggota belum memberikan ulasan atau rating untuk kegiatan apapun.</p>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxRating = document.getElementById('ratingChart').getContext('2d');
        new Chart(ctxRating, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Jumlah Orang',
                    data: @json($chartData),
                    backgroundColor: [
                        '#10B981', // 5 star: green
                        '#84CC16', // 4 star: lime
                        '#FBBF24', // 3 star: yellow/amber
                        '#F97316', // 2 star: orange
                        '#EF4444'  // 1 star: red
                    ],
                    borderRadius: 4,
                    borderWidth: 0
                }]
            },
            options: {
                indexAxis: 'y', // Horizontal bar chart
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw + ' Penilaian';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
