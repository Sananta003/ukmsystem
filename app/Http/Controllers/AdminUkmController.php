<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Kegiatan;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminUkmController extends Controller
{
    public function dashboard()
    {
        $ukm_id = Auth::user()->ukm_id;

        $totalAnggota = Anggota::where('ukm_id', $ukm_id)->count();
        $totalKegiatan = Kegiatan::where('ukm_id', $ukm_id)->count();
        $totalPemasukan = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = Keuangan::where('ukm_id', $ukm_id)->where('jenis', 'Pengeluaran')->sum('nominal');

        // Line Chart: 6 bulan terakhir
        $bulanLabels = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::today()->startOfMonth()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('F Y');

            $pemasukanData[] = Keuangan::where('ukm_id', $ukm_id)
                ->where('jenis', 'Pemasukan')
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('nominal');

            $pengeluaranData[] = Keuangan::where('ukm_id', $ukm_id)
                ->where('jenis', 'Pengeluaran')
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('nominal');
        }

        // Bar Chart: 6 kegiatan terakhir
        $latestKegiatans = Kegiatan::where('ukm_id', $ukm_id)
            ->whereNotNull('nama_kegiatan')
            ->orderBy('tanggal', 'desc')
            ->take(6)
            ->get();

        $kegiatanLabels = $latestKegiatans->pluck('nama_kegiatan')->toArray();
        $partisipasiData = $latestKegiatans->pluck('jumlah_pendaftar')->toArray();

        // Kegiatan Mendatang
        $kegiatanMendatang = Kegiatan::where('ukm_id', $ukm_id)
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();

        return view('admin_ukm.dashboard', compact(
            'totalAnggota', 'totalKegiatan', 'totalPemasukan', 'totalPengeluaran',
            'bulanLabels', 'pemasukanData', 'pengeluaranData',
            'kegiatanLabels', 'partisipasiData',
            'kegiatanMendatang'
        ));
    }
}
