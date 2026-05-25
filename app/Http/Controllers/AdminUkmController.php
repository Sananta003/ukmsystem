<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Kegiatan;
use App\Models\Keuangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminUkmController extends Controller
{
    public function dashboard()
    {
        $ukmId = Auth::user()->ukm_id;

        $totalAnggota = Anggota::where('ukm_id', $ukmId)->count();
        $totalKegiatan = Kegiatan::where('ukm_id', $ukmId)->count();
        $totalPemasukan = Keuangan::where('ukm_id', $ukmId)->where('jenis', 'Pemasukan')->sum('nominal');
        $totalPengeluaran = Keuangan::where('ukm_id', $ukmId)->where('jenis', 'Pengeluaran')->sum('nominal');

        // Line Chart Keuangan (6 bulan terakhir)
        $bulanLabels = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->startOfMonth()->subMonths($i);
            $bulanLabels[] = $date->translatedFormat('M Y');
            
            $pemasukanData[] = Keuangan::where('ukm_id', $ukmId)
                ->where('jenis', 'Pemasukan')
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('nominal');
                
            $pengeluaranData[] = Keuangan::where('ukm_id', $ukmId)
                ->where('jenis', 'Pengeluaran')
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('nominal');
        }

        // Bar Chart Partisipasi (6 kegiatan terakhir)
        $kegiatanTerakhir = Kegiatan::where('ukm_id', $ukmId)
            ->latest('tanggal')
            ->take(6)
            ->get()
            ->reverse();
            
        $kegiatanLabels = $kegiatanTerakhir->pluck('nama_kegiatan')->toArray();
        $partisipasiData = $kegiatanTerakhir->pluck('jumlah_pendaftar')->toArray();

        // Kegiatan Mendatang
        $kegiatanMendatang = Kegiatan::where('ukm_id', $ukmId)
            ->whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();

        // Notifikasi Dinamis
        $notifikasi = collect();

        $anggotaBaru = Anggota::where('ukm_id', $ukmId)->latest()->first();
        if ($anggotaBaru) {
            $notifikasi->push((object)[
                'icon' => 'fa-user-plus',
                'color' => 'blue',
                'title' => 'Anggota baru bergabung: ' . $anggotaBaru->nama_lengkap,
                'time' => $anggotaBaru->created_at->diffForHumans()
            ]);
        }

        $kegiatanDekat = Kegiatan::where('ukm_id', $ukmId)
            ->whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->first();
        if ($kegiatanDekat) {
            $notifikasi->push((object)[
                'icon' => 'fa-calendar',
                'color' => 'purple',
                'title' => 'Kegiatan "' . $kegiatanDekat->nama_kegiatan . '" akan datang',
                'time' => Carbon::parse($kegiatanDekat->tanggal)->diffForHumans()
            ]);
        }

        $keuanganTerakhir = Keuangan::where('ukm_id', $ukmId)->latest()->first();
        if ($keuanganTerakhir) {
            $warna = $keuanganTerakhir->jenis == 'Pemasukan' ? 'green' : 'red';
            $icon = $keuanganTerakhir->jenis == 'Pemasukan' ? 'fa-money-bill-wave' : 'fa-money-bill-transfer';
            $notifikasi->push((object)[
                'icon' => $icon,
                'color' => $warna,
                'title' => $keuanganTerakhir->jenis . ' sebesar Rp ' . number_format($keuanganTerakhir->nominal, 0, ',', '.'),
                'time' => $keuanganTerakhir->created_at->diffForHumans()
            ]);
        }

        $pengumumanTerakhir = \App\Models\Pengumuman::where('ukm_id', $ukmId)->latest()->first();
        if ($pengumumanTerakhir) {
            $notifikasi->push((object)[
                'icon' => 'fa-bullhorn',
                'color' => 'pink',
                'title' => 'Pengumuman disiarkan: ' . $pengumumanTerakhir->judul,
                'time' => $pengumumanTerakhir->created_at->diffForHumans()
            ]);
        }

        return view('admin_ukm.dashboard', compact(
            'totalAnggota',
            'totalKegiatan',
            'totalPemasukan',
            'totalPengeluaran',
            'bulanLabels',
            'pemasukanData',
            'pengeluaranData',
            'kegiatanLabels',
            'partisipasiData',
            'kegiatanMendatang',
            'notifikasi'
        ));
    }

    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        \App\Models\Pengumuman::create([
            'ukm_id' => Auth::user()->ukm_id,
            'judul' => $request->judul,
            'konten' => $request->konten,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        return back()->with('success', 'Pengumuman berhasil disiarkan ke semua member!');
    }
}
