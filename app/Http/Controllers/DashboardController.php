<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\User;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function admin()
    {
        $user = Auth::user();
        $ukm = \App\Models\Ukm::find($user->ukm_id);
        
        // 1. Variabel untuk Kotak Statistik (Ini yang bikin error tadi)
        $totalAnggota = User::where('ukm_id', $user->ukm_id)->where('role', 'member')->count();
        $kegiatanAktif = Kegiatan::where('ukm_id', $user->ukm_id)->count(); 
        
        $pemasukan = Keuangan::where('ukm_id', $user->ukm_id)->where('jenis', 'Pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('ukm_id', $user->ukm_id)->where('jenis', 'Pengeluaran')->sum('nominal');
        $saldoKas = $pemasukan - $pengeluaran;

        // 2. Variabel untuk Grafik Bulanan
        $keuanganBulanan = Keuangan::where('ukm_id', $user->ukm_id)
            ->select(
                \Illuminate\Support\Facades\DB::raw('MONTH(tanggal) as bulan'),
                \Illuminate\Support\Facades\DB::raw('YEAR(tanggal) as tahun'),
                \Illuminate\Support\Facades\DB::raw("SUM(CASE WHEN jenis = 'Pemasukan' THEN nominal ELSE 0 END) as total_pemasukan"),
                \Illuminate\Support\Facades\DB::raw("SUM(CASE WHEN jenis = 'Pengeluaran' THEN nominal ELSE 0 END) as total_pengeluaran")
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        $labelBulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        foreach ($keuanganBulanan as $kb) {
            $labelBulan[] = \Carbon\Carbon::create()->month($kb->bulan)->translatedFormat('F') . ' ' . $kb->tahun;
            $dataPemasukan[] = $kb->total_pemasukan;
            $dataPengeluaran[] = $kb->total_pengeluaran;
        }

        return view('admin_ukm.dashboard', compact(
            'ukm', 'totalAnggota', 'kegiatanAktif', 'saldoKas', 'pemasukan', 'pengeluaran',
            'labelBulan', 'dataPemasukan', 'dataPengeluaran'
        ));
    }
}