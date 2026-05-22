<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        $ukmId = Auth::user()->ukm_id;

        $totalPemasukan = Keuangan::where('ukm_id', $ukmId)->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = Keuangan::where('ukm_id', $ukmId)->where('jenis', 'Pengeluaran')->sum('nominal');
        $saldoTersedia = $totalPemasukan - $totalPengeluaran;

        // Doughnut Chart Pengeluaran per Kategori
        $pengeluaranKategori = Keuangan::selectRaw('kategori, SUM(nominal) as total')
            ->where('ukm_id', $ukmId)
            ->where('jenis', 'Pengeluaran')
            ->whereNotNull('kategori')
            ->groupBy('kategori')
            ->get();

        $kategoriLabels = $pengeluaranKategori->pluck('kategori')->toArray();
        $kategoriData = $pengeluaranKategori->pluck('total')->toArray();

        // Riwayat Transaksi
        $transaksis = Keuangan::where('ukm_id', $ukmId)
            ->with('kegiatan')
            ->latest('tanggal')
            ->paginate(10);
            
        $kegiatans = Kegiatan::where('ukm_id', $ukmId)->latest('tanggal')->get();

        return view('admin_ukm.keuangan.index', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldoTersedia',
            'kategoriLabels',
            'kategoriData',
            'transaksis',
            'kegiatans'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
            'kegiatan_id' => 'nullable|exists:kegiatans,id',
        ]);

        Keuangan::create([
            'ukm_id' => Auth::user()->ukm_id,
            'kegiatan_id' => $request->kegiatan_id,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('admin-ukm.keuangan.index')->with('success', 'Data transaksi berhasil ditambahkan.');
    }
}