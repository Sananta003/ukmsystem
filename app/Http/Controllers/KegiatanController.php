<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->orderBy('tanggal', 'desc')->paginate(10);
        return view('admin_ukm.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin_ukm.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'anggaran' => 'required|numeric|min:0',
        ]);

        Kegiatan::create([
            'ukm_id' => Auth::user()->ukm_id,
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'status' => 'Direncanakan',
            'anggaran' => $request->anggaran,
            'realisasi' => 0,
        ]);

        return redirect()->route('admin-ukm.kegiatan.index');
    }
    public function edit($id)
    {
        // Cari kegiatan berdasarkan ID dan pastikan itu milik UKM yang sedang login
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        return view('admin_ukm.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'status' => 'required|in:Direncanakan,Berjalan,Selesai',
            'anggaran' => 'required|numeric|min:0',
        ]);

        $kegiatan->update([
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
            'anggaran' => $request->anggaran,
        ]);

        return redirect()->route('admin-ukm.kegiatan.index');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('admin-ukm.kegiatan.index');
    }
}