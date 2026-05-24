@extends('layouts.admin_ukm')
@section('title', 'Laporan Keuangan UKM')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900">Laporan Pertanggungjawaban</h1>
            <p class="text-gray-500 mt-2">Ringkasan aktivitas dan arus kas keuangan UKM Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </button>
            <a href="{{ route('admin-ukm.laporan.cetak-pdf') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-indigo-600/20 flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>

    <!-- Statistik Kas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:border-green-200 transition-colors">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Pemasukan</p>
                <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-50 text-green-500 flex items-center justify-center text-xl group-hover:bg-green-100 transition-colors">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:border-red-200 transition-colors">
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Total Pengeluaran</p>
                <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-xl group-hover:bg-red-100 transition-colors">
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
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden print-area">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-indigo-500"></i> Rincian Transaksi Keuangan
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-6 py-4 border-b border-gray-100">Tanggal</th>
                        <th class="px-6 py-4 border-b border-gray-100">Keterangan</th>
                        <th class="px-6 py-4 border-b border-gray-100 text-right">Pemasukan</th>
                        <th class="px-6 py-4 border-b border-gray-100 text-right">Pengeluaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transaksi as $item)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 text-gray-700 font-medium">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-800 font-bold">
                            {{ $item->keterangan }}
                            @if($item->kategori)
                                <span class="block text-xs font-normal text-gray-400 mt-0.5">{{ $item->kategori }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-green-600">
                            {{ $item->jenis == 'Pemasukan' ? '+ Rp '.number_format($item->nominal, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-red-600">
                            {{ $item->jenis == 'Pengeluaran' ? '- Rp '.number_format($item->nominal, 0, ',', '.') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                                <i class="fa-solid fa-money-bill-transfer text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Transaksi</h3>
                            <p class="text-gray-500 text-sm">Arus kas keuangan UKM Anda masih kosong.</p>
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