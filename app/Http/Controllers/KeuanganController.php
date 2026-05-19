<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Keuangan::where('ukm_id', $user->ukm_id);

        if ($request->has('search') && $request->search != '') {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        $keuangan = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();
        
        $pemasukan = Keuangan::where('ukm_id', $user->ukm_id)->where('jenis', 'Pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('ukm_id', $user->ukm_id)->where('jenis', 'Pengeluaran')->sum('nominal');
        $saldoKas = $pemasukan - $pengeluaran;

        return view('admin_ukm.keuangan.index', compact('keuangan', 'pemasukan', 'pengeluaran', 'saldoKas'));
    }

    public function create()
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->orderBy('tanggal', 'desc')->get();
        return view('admin_ukm.keuangan.create', compact('kegiatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kegiatan_id' => 'nullable|exists:kegiatans,id',
        ]);

        Keuangan::create([
            'ukm_id' => Auth::user()->ukm_id,
            'kegiatan_id' => $request->kegiatan_id,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        if ($request->kegiatan_id && $request->jenis === 'Pengeluaran') {
            $kegiatan = Kegiatan::find($request->kegiatan_id);
            $kegiatan->realisasi += $request->nominal;
            $kegiatan->save();
        }

        return redirect()->route('admin-ukm.keuangan.index');
    }
    public function edit($id)
    {
        $keuangan = Keuangan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->orderBy('tanggal', 'desc')->get();
        
        return view('admin_ukm.keuangan.edit', compact('keuangan', 'kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $keuangan = Keuangan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);

        $request->validate([
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kegiatan_id' => 'nullable|exists:kegiatans,id',
        ]);

        // 1. Tarik kembali nominal dari kegiatan lama (jika ada)
        if ($keuangan->kegiatan_id && $keuangan->jenis === 'Pengeluaran') {
            $oldKegiatan = Kegiatan::find($keuangan->kegiatan_id);
            if ($oldKegiatan) {
                $oldKegiatan->realisasi -= $keuangan->nominal;
                $oldKegiatan->save();
            }
        }

        // 2. Update data transaksi
        $keuangan->update([
            'kegiatan_id' => $request->kegiatan_id,
            'jenis' => $request->jenis,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
        ]);

        // 3. Masukkan nominal ke kegiatan baru (jika ada)
        if ($request->kegiatan_id && $request->jenis === 'Pengeluaran') {
            $newKegiatan = Kegiatan::find($request->kegiatan_id);
            if ($newKegiatan) {
                $newKegiatan->realisasi += $request->nominal;
                $newKegiatan->save();
            }
        }

        return redirect()->route('admin-ukm.keuangan.index');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);

        // Tarik kembali dana dari tabel kegiatan sebelum dihapus
        if ($keuangan->kegiatan_id && $keuangan->jenis === 'Pengeluaran') {
            $kegiatan = Kegiatan::find($keuangan->kegiatan_id);
            if ($kegiatan) {
                $kegiatan->realisasi -= $keuangan->nominal;
                $kegiatan->save();
            }
        }

        $keuangan->delete();
        return redirect()->route('admin-ukm.keuangan.index');
    }
}