@extends('layouts.app')
@section('title', 'Manajemen Keuangan UKM')

@section('content')
<div class="mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Keuangan UKM</h1>
        <p class="text-gray-500">Kelola arus kas, pemasukan, dan pengeluaran.</p>
    </div>
</div>

<!-- Alert Peringatan -->
@if($saldoTersedia < 20000000)
<div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mb-6 shadow-sm" role="alert">
    <div class="flex items-center">
        <i class="fa-solid fa-triangle-exclamation text-xl mr-3"></i>
        <div>
            <p class="font-bold">Peringatan: Dana Hampir Habis!</p>
            <p class="text-sm">Saldo UKM saat ini berada di bawah batas aman (Rp 20.000.000). Harap perhatikan pengeluaran mendatang.</p>
        </div>
    </div>
</div>
@endif

<!-- 3 Card Statistik Keuangan -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 font-medium">Total Pemasukan</p>
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center"><i class="fa-solid fa-arrow-down"></i></div>
        </div>
        <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
    </div>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 font-medium">Total Pengeluaran</p>
            <div class="w-10 h-10 bg-red-50 text-red-600 rounded-full flex items-center justify-center"><i class="fa-solid fa-arrow-up"></i></div>
        </div>
        <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
    </div>
    
    <div class="bg-blue-600 p-6 rounded-2xl shadow-lg text-white">
        <div class="flex items-center justify-between mb-2">
            <p class="text-blue-100 font-medium">Saldo Tersedia</p>
            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center"><i class="fa-solid fa-wallet"></i></div>
        </div>
        <h3 class="text-3xl font-black">Rp {{ number_format($saldoTersedia, 0, ',', '.') }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8" x-data="{ modalBuka: false }">
    <!-- Chart Kategori -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Pengeluaran per Kategori</h3>
        @if(count($kategoriData) > 0)
            <div class="relative w-full aspect-square max-h-[300px] mx-auto">
                <canvas id="kategoriChart"></canvas>
            </div>
        @else
            <div class="flex items-center justify-center h-48 text-gray-400">Belum ada data pengeluaran</div>
        @endif
    </div>

    <!-- Tabel Riwayat & Tombol Tambah -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
            <h2 class="text-xl font-bold text-gray-800">Riwayat Transaksi</h2>
            <button @click="modalBuka = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                <i class="fa-solid fa-plus mr-1"></i> Tambah Transaksi
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-4 py-3 rounded-tl-lg">Tanggal</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3">Jenis/Kategori</th>
                        <th class="px-4 py-3 text-right rounded-tr-lg">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transaksis as $trx)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <p class="font-bold text-gray-800">{{ $trx->keterangan }}</p>
                            @if($trx->kegiatan)
                                <p class="text-xs text-indigo-600">Ref: {{ $trx->kegiatan->nama_kegiatan }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs font-bold rounded {{ $trx->jenis == 'Pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $trx->jenis }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $trx->kategori }}</p>
                        </td>
                        <td class="px-4 py-3 text-right font-bold {{ $trx->jenis == 'Pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trx->jenis == 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $transaksis->links() }}
        </div>

        <!-- Modal Tambah Transaksi -->
        <div x-show="modalBuka" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div x-show="modalBuka" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="modalBuka = false" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="modalBuka" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('admin-ukm.keuangan.store') }}" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4" id="modal-title">Tambah Transaksi Baru</h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi</label>
                                        <select name="jenis" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Pilih Jenis</option>
                                            <option value="Pemasukan">Pemasukan</option>
                                            <option value="Pengeluaran">Pengeluaran</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                        <select name="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="Dana Kampus">Dana Kampus</option>
                                            <option value="Sponsor">Sponsor</option>
                                            <option value="Iuran Anggota">Iuran Anggota</option>
                                            <option value="Operasional">Operasional</option>
                                            <option value="Kegiatan">Kegiatan</option>
                                            <option value="Konsumsi">Konsumsi</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                                    <input type="number" name="nominal" min="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: 500000" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <textarea name="keterangan" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Detail transaksi..." required></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Terkait Kegiatan? (Opsional)</label>
                                    <select name="kegiatan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Tidak terkait kegiatan --</option>
                                        @foreach($kegiatans as $keg)
                                            <option value="{{ $keg->id }}">{{ $keg->nama_kegiatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Transaksi
                            </button>
                            <button type="button" @click="modalBuka = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const kategoriLabels = @json($kategoriLabels);
    const kategoriData = @json($kategoriData);

    if(kategoriLabels.length > 0) {
        const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
        new Chart(ctxKategori, {
            type: 'doughnut',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    data: kategoriData,
                    backgroundColor: [
                        '#ef4444', // red
                        '#f59e0b', // amber
                        '#3b82f6', // blue
                        '#10b981', // green
                        '#8b5cf6', // purple
                        '#6b7280'  // gray
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
</script>
@endsection