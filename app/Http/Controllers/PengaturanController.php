<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $ukm = Ukm::findOrFail(Auth::user()->ukm_id);
        return view('admin_ukm.pengaturan.index', compact('ukm'));
    }

    public function update(Request $request)
    {
        // 1. Tambahkan validasi untuk foto_kegiatan
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $ukm = Ukm::findOrFail(Auth::user()->ukm_id);

        // 2. Logika untuk Logo (sudah ada, dibiarkan saja)
        if ($request->hasFile('logo')) {
            if ($ukm->logo) {
                Storage::disk('public')->delete($ukm->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $ukm->logo = $path;
        }

        // 3. Logika BARU untuk Foto Kegiatan
        if ($request->hasFile('foto_kegiatan')) {
            // Hapus foto lama jika ada
            if ($ukm->foto_kegiatan) {
                Storage::disk('public')->delete($ukm->foto_kegiatan);
            }
            // Simpan foto baru ke folder 'foto_kegiatan' di dalam public storage
            $pathFoto = $request->file('foto_kegiatan')->store('foto_kegiatan', 'public');
            $ukm->foto_kegiatan = $pathFoto;
        }

        // 4. Simpan data teks
        $ukm->nama_ukm = $request->nama_ukm;
        $ukm->deskripsi = $request->deskripsi;
        
        // Save semua perubahan ke database
        $ukm->save();

        return back()->with('success', 'Profil UKM berhasil diperbarui.');
    }
}