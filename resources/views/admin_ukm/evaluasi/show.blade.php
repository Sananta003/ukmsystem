@extends('layouts.admin')

@section('title', 'Hasil Evaluasi - ' . $kegiatan->nama_kegiatan)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin-ukm.evaluasi.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mb-4 inline-flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Evaluasi
    </a>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Evaluasi: {{ $kegiatan->nama_kegiatan }}</h1>
    <p class="text-sm text-gray-500 mt-1">Ringkasan feedback dari {{ $totalEvaluasi }} peserta.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Rata-rata Rating -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 flex flex-col items-center justify-center text-center">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Rata-rata Rating</h3>
        <div class="text-5xl font-extrabold text-indigo-600 dark:text-indigo-400 mb-2">{{ number_format($rataRata, 1) }}</div>
        <div class="flex text-yellow-400 text-2xl mb-2">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= round($rataRata))
                    <i class="fas fa-star"></i>
                @else
                    <i class="far fa-star text-gray-300"></i>
                @endif
            @endfor
        </div>
        <p class="text-sm text-gray-500">Dari total {{ $totalEvaluasi }} ulasan</p>
    </div>

    <!-- Distribusi Rating (Bar Chart) -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Distribusi Rating</h3>
        <div class="space-y-3">
            @for($i = 5; $i >= 1; $i--)
                @php
                    $count = $distribusi[$i] ?? 0;
                    $percent = $totalEvaluasi > 0 ? ($count / $totalEvaluasi) * 100 : 0;
                @endphp
                <div class="flex items-center">
                    <div class="w-12 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $i }} Bintang</div>
                    <div class="flex-1 mx-4">
                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                    <div class="w-10 text-right text-sm text-gray-500">{{ $count }}</div>
                </div>
            @endfor
        </div>
    </div>
</div>

<!-- Daftar Komentar -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Komentar Peserta</h3>
    </div>
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($evaluasis as $eval)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-3">
                            {{ substr($eval->user->name ?? 'Anonim', 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $eval->user->name ?? 'Anonim' }}</h4>
                            <p class="text-xs text-gray-500">{{ $eval->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $eval->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star text-gray-300"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ $eval->komentar ?? 'Tidak ada komentar tertulis.' }}</p>
            </div>
        @empty
            <div class="p-8 text-center text-gray-500">
                Belum ada komentar atau feedback untuk kegiatan ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
