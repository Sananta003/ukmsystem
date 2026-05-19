<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ukm;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $ukm = null;

        if ($user->ukm_id) {
            $ukm = Ukm::find($user->ukm_id);
        }

        return view('member.dashboard', compact('ukm', 'user'));
    }

    public function kegiatan()
    {
        return view('member.kegiatan');
    }

    public function buatPengajuan()
    {
        return view('pengajuan.create');
    }
    public function storePengajuan(Request $request)
    {
        $request->validate([
            'kode_kampus' => 'required',
            'nama_ukm' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kode = \App\Models\KodePengajuan::where('kode', $request->kode_kampus)
            ->where('status', 'tersedia')
            ->first();

        if (!$kode) {
            return back()->withErrors(['kode_kampus' => 'Kode otorisasi tidak valid atau sudah terpakai.'])->withInput();
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        \App\Models\PengajuanUkm::create([
            'user_id' => Auth::id(),
            'nama_ukm' => $request->nama_ukm,
            'deskripsi' => $request->deskripsi,
            'logo' => $logoPath,
            'status' => 'pending',
        ]);

        $kode->update(['status' => 'terpakai']);

        return redirect()->route('member.dashboard');
    }
}