<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::where('ukm_id', Auth::user()->ukm_id)
            ->latest('tanggal')
            ->paginate(10);
            
        return view('admin_ukm.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('admin_ukm.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'target_peserta' => 'required|integer|min:1',
            'pic_nama' => 'required|string|max:255',
            'pic_kontak' => 'required|string|max:255',
        ]);

        Kegiatan::create([
            'ukm_id' => Auth::user()->ukm_id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'lokasi' => $request->lokasi,
            'anggaran' => $request->anggaran,
            'target_peserta' => $request->target_peserta,
            'pic_nama' => $request->pic_nama,
            'pic_kontak' => $request->pic_kontak,
            'status' => 'Direncanakan',
            'realisasi_anggaran' => 0,
            'jumlah_pendaftar' => 0,
        ]);

        return redirect()->route('admin-ukm.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        
        $persenAnggaran = $kegiatan->anggaran > 0 ? min(100, ($kegiatan->realisasi_anggaran / $kegiatan->anggaran) * 100) : 0;
        $persenPeserta = $kegiatan->target_peserta > 0 ? min(100, ($kegiatan->jumlah_pendaftar / $kegiatan->target_peserta) * 100) : 0;

        return view('admin_ukm.kegiatan.show', compact('kegiatan', 'persenAnggaran', 'persenPeserta'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        return view('admin_ukm.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'target_peserta' => 'required|integer|min:1',
            'pic_nama' => 'required|string|max:255',
            'pic_kontak' => 'required|string|max:255',
        ]);

        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        
        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'lokasi' => $request->lokasi,
            'anggaran' => $request->anggaran,
            'target_peserta' => $request->target_peserta,
            'pic_nama' => $request->pic_nama,
            'pic_kontak' => $request->pic_kontak,
        ]);

        return redirect()->route('admin-ukm.kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('admin-ukm.kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}