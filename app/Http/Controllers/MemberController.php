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
        $kegiatanTerdekat = null;

        if ($user->ukm_id) {
            $ukm = Ukm::find($user->ukm_id);
            $kegiatanTerdekat = \App\Models\Kegiatan::where('ukm_id', $user->ukm_id)
                ->where('tanggal', '>=', now()->toDateString())
                ->orderBy('tanggal', 'asc')
                ->first();
        }

        return view('member.dashboard', compact('ukm', 'user', 'kegiatanTerdekat'));
    }

    public function inisiatorDashboard()
    {
        $user = Auth::user();
        $pengajuan = \App\Models\PengajuanUkm::where('user_id', $user->id)->with('revisis.user')->latest()->first();
        
        return view('inisiator.dashboard', compact('user', 'pengajuan'));
    }

    public function kegiatan()
    {
        $user = Auth::user();
        
        if ($user->ukm_id) {
            $kegiatan = \App\Models\Kegiatan::where('ukm_id', $user->ukm_id)
                                            ->orderBy('tanggal', 'desc')
                                            ->paginate(10);
        } else {
            $kegiatan = \App\Models\Kegiatan::where('id', '<', 0)->paginate(10);
        }

        return view('member.kegiatan', compact('kegiatan'));
    }

    public function buatPengajuan()
    {
        return view('pengajuan.create');
    }
    public function storePengajuan(Request $request)
    {
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_proposal' => 'required|mimes:pdf|max:5120',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $proposalPath = null;
        if ($request->hasFile('file_proposal')) {
            $proposalPath = $request->file('file_proposal')->store('proposals', 'public');
        }

        \App\Models\PengajuanUkm::create([
            'user_id' => Auth::id(),
            'nama_ukm' => $request->nama_ukm,
            'latar_belakang' => $request->deskripsi, // deskripsi maps to latar_belakang
            'rencana_kegiatan' => '-', // Placeholder since form only has deskripsi
            'daftar_anggota' => '-', // Placeholder
            'logo' => $logoPath,
            'file_proposal' => $proposalPath,
            'status' => 'pending_bem',
        ]);

        return redirect()->route('inisiator.dashboard')->with('success', 'Proposal berhasil diajukan dan sedang menunggu tinjauan BEM.');
    }

    public function editPengajuan($id)
    {
        $pengajuan = \App\Models\PengajuanUkm::with('revisis.user')->findOrFail($id);

        if ($pengajuan->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($pengajuan->status, ['revisi_bem', 'revisi_bpm'])) {
            return redirect()->route('inisiator.dashboard')->with('error', 'Proposal tidak dalam masa revisi.');
        }

        return view('pengajuan.edit', compact('pengajuan'));
    }

    public function updatePengajuan(Request $request, $id)
    {
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_proposal' => 'nullable|mimes:pdf|max:5120',
        ]);

        $pengajuan = \App\Models\PengajuanUkm::findOrFail($id);

        if ($pengajuan->user_id !== Auth::id() || !in_array($pengajuan->status, ['revisi_bem', 'revisi_bpm'])) {
            abort(403);
        }

        $dataUpdate = [
            'nama_ukm' => $request->nama_ukm,
            'latar_belakang' => $request->deskripsi,
        ];

        if ($request->hasFile('logo')) {
            $dataUpdate['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('file_proposal')) {
            $dataUpdate['file_proposal'] = $request->file('file_proposal')->store('proposals', 'public');
        }

        if ($pengajuan->status === 'revisi_bem') {
            $dataUpdate['status'] = 'pending_bem';
        } elseif ($pengajuan->status === 'revisi_bpm') {
            $dataUpdate['status'] = 'pending_bpm';
        }

        $pengajuan->update($dataUpdate);

        return redirect()->route('inisiator.dashboard')->with('success', 'Proposal revisi berhasil dikirim ulang.');
    }
}