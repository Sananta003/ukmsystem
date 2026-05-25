@extends('layouts.admin_ukm')
@section('title', 'Laporan Keuangan UKM')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-slate-100 transition-colors">Laporan Pertanggungjawaban</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-2 transition-colors">Ringkasan aktivitas dan arus kas keuangan UKM Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-gray-900 dark:hover:text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </button>
            <a href="{{ route('admin-ukm.laporan.cetak-pdf') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-indigo-600/20 flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>

    <!-- Statistik Kas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center justify-between group hover:border-green-200 dark:hover:border-green-500/50 transition-colors">
            <div>
                <p class="text-gray-500 dark:text-slate-400 text-sm font-medium mb-1 transition-colors">Total Pemasukan</p>
                <h3 class="text-2xl font-black text-gray-800 dark:text-slate-100 transition-colors">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/30 text-green-500 dark:text-green-400 flex items-center justify-center text-xl group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition-colors">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 flex items-center justify-between group hover:border-red-200 dark:hover:border-red-500/50 transition-colors">
            <div>
                <p class="text-gray-500 dark:text-slate-400 text-sm font-medium mb-1 transition-colors">Total Pengeluaran</p>
                <h3 class="text-2xl font-black text-gray-800 dark:text-slate-100 transition-colors">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400 flex items-center justify-center text-xl group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                <i class="fa-solid fa-arrow-trend-down"></i>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-6 rounded-2xl shadow-lg shadow-indigo-600/30 flex items-center justify-between text-white relative overflow-hidden">
            <!-- Dekorasi background -->
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-black/10 rounded-full blur-xl"></div>
            
            <div class="relative z-10">
                <p class="text-indigo-100 text-sm font-medium mb-1">Saldo Akhir Kas</p>
                <h3 class="text-3xl font-black">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/20 text-white flex items-center justify-center text-xl backdrop-blur-sm relative z-10 border border-white/10">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden print-area transition-colors">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 transition-colors">
            <h3 class="text-lg font-bold text-gray-800 dark:text-slate-200 flex items-center gap-2 transition-colors">
                <i class="fa-solid fa-list-check text-indigo-500"></i> Rincian Transaksi Keuangan
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-gray-50/80 dark:bg-slate-900/50 text-gray-500 dark:text-slate-400 text-xs uppercase tracking-wider font-bold transition-colors">
                    <tr>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">Tanggal</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700">Keterangan</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-right">Pemasukan</th>
                        <th class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 text-right">Pengeluaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50 transition-colors">
                    @forelse($transaksi as $item)
                    <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-gray-700 dark:text-slate-300 font-medium transition-colors">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-800 dark:text-slate-200 font-bold transition-colors">
                            {{ $item->keterangan }}
                            @if($item->kategori)
                                <span class="block text-xs font-normal text-gray-400 dark:text-slate-500 mt-0.5 transition-colors">{{ $item->kategori }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-green-600 dark:text-green-400 transition-colors">
                            {{ $item->jenis == 'Pemasukan' ? '+ Rp '.number_format($item->nominal, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-red-600 dark:text-red-400 transition-colors">
                            {{ $item->jenis == 'Pengeluaran' ? '- Rp '.number_format($item->nominal, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-slate-500 mb-4 transition-colors">
                                <i class="fa-solid fa-money-bill-transfer text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-slate-200 mb-1 transition-colors">Belum Ada Transaksi</h3>
                            <p class="text-gray-500 dark:text-slate-400 text-sm transition-colors">Arus kas keuangan UKM Anda masih kosong.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .print-area, .print-area * { visibility: visible; }
        .print-area { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; margin: 0; padding: 0; }
        .max-w-6xl { max-width: 100%; margin: 0; }
        button, a[href*="cetak-pdf"] { display: none !important; }
        aside, header { display: none !important; }
        .shadow-sm, .shadow-lg, .shadow-md { box-shadow: none !important; }
        .rounded-2xl, .rounded-xl, .rounded-lg { border-radius: 0 !important; }
        .border-gray-100 { border-color: #e5e7eb !important; }
    }
</style>
@endsection