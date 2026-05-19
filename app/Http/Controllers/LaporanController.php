<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Kegiatan;
use App\Models\User;
use App\Models\Ukm;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $ukm_id = Auth::user()->ukm_id;
        
        $pemasukan = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pengeluaran')->sum('nominal');
        $saldoKas = $pemasukan - $pengeluaran;
        
        $totalKegiatan = Kegiatan::where('ukm_id', $ukm_id)->count();
        $totalAnggota = User::where('ukm_id', $ukm_id)->where('role', 'member')->count();

        $transaksi = Keuangan::where('ukm_id', $ukm_id)->orderBy('tanggal', 'desc')->get();

        return view('admin_ukm.laporan.index', compact('pemasukan', 'pengeluaran', 'saldoKas', 'totalKegiatan', 'totalAnggota', 'transaksi'));
    }

    public function cetakPdf()
    {
        $ukm_id = Auth::user()->ukm_id;
        $ukm = Ukm::find($ukm_id);
        
        $pemasukan = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pengeluaran')->sum('nominal');
        $saldoKas = $pemasukan - $pengeluaran;

        $transaksi = Keuangan::where('ukm_id', $ukm_id)->orderBy('tanggal', 'asc')->get();

        $pdf = Pdf::loadView('admin_ukm.laporan.pdf', compact('ukm', 'pemasukan', 'pengeluaran', 'saldoKas', 'transaksi'));
        
        return $pdf->download('Laporan_Keuangan_' . str_replace(' ', '_', $ukm->nama_ukm) . '.pdf');
    }
}