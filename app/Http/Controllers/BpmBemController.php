<?php

namespace App\Http\Controllers;

use App\Models\PengajuanUkm;
use App\Models\RevisiPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BpmBemController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $statusTarget = $role === 'bem' ? 'pending_bem' : 'pending_bpm';

        $pengajuans = PengajuanUkm::with('user')
            ->where('status', $statusTarget)
            ->latest()
            ->get();
            
        $proposals = \App\Models\ProposalApproval::with(['proposal.kegiatan.ukm'])
            ->where('role_approval', $role)
            ->where('status', 'Menunggu')
            ->orderBy('id', 'desc')
            ->get();
            
        return view('bpm_bem.dashboard', compact('pengajuans', 'proposals'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanUkm::with(['user', 'revisis.user'])->findOrFail($id);
        
        // Cek otorisasi akses berdasar status
        $role = Auth::user()->role;
        if ($role === 'bem' && $pengajuan->status !== 'pending_bem') {
            return redirect()->route('birokrasi.dashboard')->with('error', 'Akses ditolak.');
        }
        if ($role === 'bpm' && $pengajuan->status !== 'pending_bpm') {
            return redirect()->route('birokrasi.dashboard')->with('error', 'Akses ditolak.');
        }

        return view('bpm_bem.show', compact('pengajuan'));
    }

    public function acc($id)
    {
        $pengajuan = PengajuanUkm::findOrFail($id);
        $role = Auth::user()->role;

        if ($role === 'bem' && $pengajuan->status === 'pending_bem') {
            $pengajuan->update(['status' => 'pending_bpm']);
            return redirect()->route('birokrasi.dashboard')->with('success', 'Proposal di-ACC oleh BEM, diteruskan ke BPM.');
        } elseif ($role === 'bpm' && $pengajuan->status === 'pending_bpm') {
            $pengajuan->update(['status' => 'pending_superadmin']);
            return redirect()->route('birokrasi.dashboard')->with('success', 'Proposal di-ACC oleh BPM, diteruskan ke Super Admin.');
        }

        return redirect()->back()->with('error', 'Gagal memproses ACC.');
    }

    public function storeRevisi(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string',
            'file_revisi' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png|max:5120',
        ]);

        $pengajuan = PengajuanUkm::findOrFail($id);
        $role = Auth::user()->role;

        $filePath = null;
        if ($request->hasFile('file_revisi')) {
            $filePath = $request->file('file_revisi')->store('revisi_files', 'public');
        }

        RevisiPengajuan::create([
            'pengajuan_ukm_id' => $pengajuan->id,
            'user_id' => Auth::id(),
            'komentar' => $request->komentar,
            'file_revisi' => $filePath,
        ]);

        if ($role === 'bem' && $pengajuan->status === 'pending_bem') {
            $pengajuan->update(['status' => 'revisi_bem']);
        } elseif ($role === 'bpm' && $pengajuan->status === 'pending_bpm') {
            $pengajuan->update(['status' => 'revisi_bpm']);
        }

        return redirect()->route('birokrasi.dashboard')->with('success', 'Komentar/Revisi berhasil dikirimkan ke Inisiator.');
    }
}
