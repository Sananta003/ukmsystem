@extends('layouts.app')
@section('title', 'Evaluasi Kegiatan UKM')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Evaluasi & Feedback</h1>
        <p class="text-gray-500">Ulasan dan rating dari kegiatan yang telah diselenggarakan.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Rata-rata Rating -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center h-full">
        <h3 class="text-gray-500 font-medium mb-2">Rata-Rata Rating Keseluruhan</h3>
        <h1 class="text-6xl font-black text-gray-800 mb-4">{{ $rataRata }}</h1>
        <div class="flex text-yellow-400 text-2xl mb-2">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= round($rataRata))
                    <i class="fa-solid fa-star"></i>
                @else
                    <i class="fa-regular fa-star text-gray-300"></i>
                @endif
            @endfor
        </div>
        <p class="text-sm text-gray-500">Dari {{ $evaluasis->total() }} ulasan peserta</p>
    </div>

    <!-- Grafik Distribusi -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Rating</h3>
        <div class="relative w-full h-48">
            <canvas id="ratingChart"></canvas>
        </div>
    </div>
</div>

<!-- Daftar Komentar -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4">Feedback Peserta</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($evaluasis as $eval)
        <div class="border border-gray-100 rounded-xl p-5 hover:shadow-md transition bg-gray-50">
            <div class="flex justify-between items-start mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                        {{ substr($eval->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">{{ $eval->user->name ?? 'Anonim' }}</h4>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($eval->created_at)->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="flex text-yellow-400 text-xs">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $eval->rating)
                            <i class="fa-solid fa-star"></i>
                        @else
                            <i class="fa-regular fa-star text-gray-300"></i>
                        @endif
                    @endfor
                </div>
            </div>
            @if($eval->kegiatan)
            <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-2 py-1 rounded font-medium mb-2">{{ $eval->kegiatan->nama_kegiatan }}</span>
            @endif
            <p class="text-gray-600 text-sm italic">"{{ $eval->komentar ?? 'Tidak ada komentar tertulis.' }}"</p>
        </div>
        @empty
        <div class="col-span-1 md:col-span-2 text-center py-10">
            <div class="text-gray-300 mb-3"><i class="fa-regular fa-comment-dots text-5xl"></i></div>
            <p class="text-gray-500 font-medium">Belum ada evaluasi kegiatan.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $evaluasis->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ratingLabels = @json($ratingLabels);
    const ratingData = @json($ratingData);

    const ctxRating = document.getElementById('ratingChart').getContext('2d');
    new Chart(ctxRating, {
        type: 'bar',
        data: {
            labels: ratingLabels,
            datasets: [{
                label: 'Jumlah Ulasan',
                data: ratingData,
                backgroundColor: '#f59e0b', // amber-500
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y', // Horizontal bar chart
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
</script>
@endsection
