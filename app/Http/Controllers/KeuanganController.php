<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        $ukm_id = Auth::user()->ukm_id;

        $totalPemasukan = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pengeluaran')->sum('nominal');
        $saldoTersedia = $totalPemasukan - $totalPengeluaran;

        // Doughnut Chart Pengeluaran
        $pengeluaranKategori = Keuangan::where('ukm_id', $ukm_id)
            ->where('jenis', 'Pengeluaran')
            ->whereNotNull('kategori')
            ->selectRaw('kategori, SUM(nominal) as total')
            ->groupBy('kategori')
            ->get();

        $kategoriLabels = $pengeluaranKategori->pluck('kategori')->toArray();
        $kategoriData = $pengeluaranKategori->pluck('total')->toArray();

        $transaksis = Keuangan::where('ukm_id', $ukm_id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin_ukm.keuangan.index', compact(
            'totalPemasukan', 'totalPengeluaran', 'saldoTersedia',
            'kategoriLabels', 'kategoriData',
            'transaksis'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required|numeric|min:1',
            'kategori' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        Keuangan::create([
            'ukm_id' => Auth::user()->ukm_id,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin-ukm.keuangan.index')->with('success', 'Transaksi berhasil ditambahkan');
    }
}