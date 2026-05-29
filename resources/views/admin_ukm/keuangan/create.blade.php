@extends('layouts.admin_ukm')
@section('title', 'Tambah Transaksi')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">
    <div class="mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-xl font-bold text-gray-800">Catat Transaksi Keuangan</h2>
        <p class="text-sm text-gray-500">Masukkan data pemasukan atau pengeluaran kas UKM.</p>
    </div>

    <form action="{{ route('admin-ukm.keuangan.store') }}" method="POST">
        @csrf
        <div class="space-y-5">
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi <span class="text-red-500">*</span></label>
                    <select name="jenis" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option value="Pemasukan">Pemasukan (+)</option>
                        <option value="Pengeluaran">Pengeluaran (-)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="nominal" required min="1" placeholder="Contoh: 500000" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Transaksi <span class="text-red-500">*</span></label>
                <input type="text" name="keterangan" required placeholder="Contoh: Iuran anggota bulan Maret" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Terkait Kegiatan? (Opsional)</label>
                <select name="kegiatan_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                    <option value="">-- Tidak Terkait Kegiatan --</option>
                    @foreach($kegiatan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kegiatan }} ({{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin-ukm.keuangan.index') }}" class="px-5 py-2.5 text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg font-medium transition-colors">Batal</a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Simpan Transaksi</button>
        </div>
    </form>
</div>
@endsection