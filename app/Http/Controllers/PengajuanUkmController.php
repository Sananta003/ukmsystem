<?php

namespace App\Http\Controllers;

use App\Models\PengajuanUkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanUkmController extends Controller
{
    public function create()
    {
        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'kode_kampus' => 'required|string',
            'nama_ukm' => 'required|string|max:255',
            'latar_belakang' => 'required|string',
            'rencana_kegiatan' => 'required|string',
            'daftar_anggota' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. LOGIKA VALIDASI KODE KHUSUS
        // Di sini kita cek apakah kode yang dimasukkan mahasiswa benar.
        // (Bisa kamu cocokkan dengan database tabel kode, atau untuk sementara di hardcode)
        $kodeValidDariKampus = "UKM-MANTAP-2024"; // Ganti dengan logika databasemu nanti
        
        if (strtoupper($request->kode_kampus) !== $kodeValidDariKampus) {
            return back()->withInput()->withErrors(['kode_kampus' => 'Kode Otorisasi tidak valid atau sudah kadaluarsa!']);
        }

        // 3. Proses File Logo Jika Ada
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('pengajuan_logos', 'public');
        }

        // 4. Simpan sebagai Proposal (Pending)
        PengajuanUkm::create([
            'user_id' => Auth::id(), // ID mahasiswa yang login
            'kode_kampus' => $request->kode_kampus,
            'nama_ukm' => $request->nama_ukm,
            'latar_belakang' => $request->latar_belakang,
            'rencana_kegiatan' => $request->rencana_kegiatan,
            'daftar_anggota' => $request->daftar_anggota,
            'logo' => $logoPath,
            'status' => 'pending' // Otomatis belum di ACC
        ]);

        return redirect()->route('dashboard')->with('success', 'Proposal pengajuan UKM berhasil dikirim! Menunggu ACC dari Super Admin.');
    }
}