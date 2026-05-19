@extends('layouts.admin_ukm')
@section('title', 'Laporan UKM')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b pb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Laporan Pertanggungjawaban</h2>
            <p class="text-sm text-gray-500">Ringkasan aktivitas dan keuangan UKM</p>
        </div>
        <a href="{{ route('admin-ukm.laporan.cetak-pdf') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
            <i class="fa-solid fa-file-pdf mr-2"></i> Download PDF
        </a>
            <i class="fa-solid fa-print mr-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="p-4 border border-gray-200 rounded-lg text-center">
            <p class="text-sm text-gray-500 mb-1">Total Pemasukan</p>
            <h3 class="text-xl font-bold text-green-600">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
        </div>
        <div class="p-4 border border-gray-200 rounded-lg text-center">
            <p class="text-sm text-gray-500 mb-1">Total Pengeluaran</p>
            <h3 class="text-xl font-bold text-red-600">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
        </div>
        <div class="p-4 border border-blue-200 bg-blue-50 rounded-lg text-center">
            <p class="text-sm text-blue-600 mb-1">Saldo Akhir Kas</p>
            <h3 class="text-xl font-bold text-blue-800">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Rincian Transaksi</h3>
        <table class="w-full text-left text-sm border-collapse border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border border-gray-200 p-2">Tanggal</th>
                    <th class="border border-gray-200 p-2">Keterangan</th>
                    <th class="border border-gray-200 p-2">Pemasukan</th>
                    <th class="border border-gray-200 p-2">Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $item)
                <tr>
                    <td class="border border-gray-200 p-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td class="border border-gray-200 p-2">{{ $item->keterangan }}</td>
                    <td class="border border-gray-200 p-2">{{ $item->jenis == 'Pemasukan' ? 'Rp '.number_format($item->nominal, 0, ',', '.') : '-' }}</td>
                    <td class="border border-gray-200 p-2">{{ $item->jenis == 'Pengeluaran' ? 'Rp '.number_format($item->nominal, 0, ',', '.') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .bg-white, .bg-white * { visibility: visible; }
        .bg-white { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; }
        button { display: none; }
    }
</style>
@endsection