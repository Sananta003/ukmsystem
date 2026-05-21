<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        return view('admin_ukm.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin_ukm.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'target_peserta' => 'required|integer|min:0',
            'pic_nama' => 'nullable|string|max:255',
            'pic_kontak' => 'nullable|string|max:255',
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
            'realisasi_anggaran' => 0,
            'target_peserta' => $request->target_peserta,
            'jumlah_pendaftar' => 0,
            'status' => 'Direncanakan',
            'pic_nama' => $request->pic_nama,
            'pic_kontak' => $request->pic_kontak,
        ]);

        return redirect()->route('admin-ukm.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        
        $persenAnggaran = 0;
        if ($kegiatan->anggaran > 0) {
            $persenAnggaran = min(100, ($kegiatan->realisasi_anggaran / $kegiatan->anggaran) * 100);
        }

        $persenPeserta = 0;
        if ($kegiatan->target_peserta > 0) {
            $persenPeserta = min(100, ($kegiatan->jumlah_pendaftar / $kegiatan->target_peserta) * 100);
        }

        // Timeline Approval
        $timeline = [
            ['status' => 'Dibuat', 'role' => 'Admin UKM', 'waktu' => $kegiatan->created_at->format('d M Y H:i'), 'done' => true],
            ['status' => 'Menunggu', 'role' => 'BEM', 'waktu' => '-', 'done' => false],
            ['status' => 'Menunggu', 'role' => 'BPM', 'waktu' => '-', 'done' => false],
            ['status' => 'Menunggu', 'role' => 'Super Admin', 'waktu' => '-', 'done' => false],
        ];

        return view('admin_ukm.kegiatan.show', compact('kegiatan', 'persenAnggaran', 'persenPeserta', 'timeline'));
    }
}