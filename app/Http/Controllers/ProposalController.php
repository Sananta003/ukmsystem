<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Proposal;
use App\Models\ProposalApproval;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index()
    {
        $ukm_id = Auth::user()->ukm_id;
        
        // Ambil semua kegiatan milik UKM ini beserta data proposalnya
        $kegiatans = Kegiatan::where('ukm_id', $ukm_id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin_ukm.proposal.index', compact('kegiatans'));
    }

    public function show($id)
    {
        // $id adalah ID dari kegiatan
        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);
        $proposal = Proposal::where('kegiatan_id', $kegiatan->id)->first();
        
        $approvals = [];
        if ($proposal) {
            $approvals = ProposalApproval::where('proposal_id', $proposal->id)
                ->with('user')
                ->orderBy('id', 'asc')
                ->get();
        }

        return view('admin_ukm.proposal.show', compact('kegiatan', 'proposal', 'approvals'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_proposal' => 'required|mimes:pdf,doc,docx|max:10240' // 10MB
        ]);

        $kegiatan = Kegiatan::where('ukm_id', Auth::user()->ukm_id)->findOrFail($id);

        $path = $request->file('file_proposal')->store('proposals', 'public');

        $proposal = Proposal::updateOrCreate(
            ['kegiatan_id' => $kegiatan->id],
            [
                'file_proposal' => $path,
                'status_akhir' => 'Diajukan'
            ]
        );

        // Jika belum ada riwayat sama sekali, kita buat riwayat pertama:
        if ($proposal->approvals()->count() === 0) {
            // Asumsi urutan standar: BEM -> Kampus
            ProposalApproval::create([
                'proposal_id' => $proposal->id,
                'role_approval' => 'admin_ukm',
                'user_id' => Auth::id(),
                'status' => 'Disetujui',
                'catatan' => 'Proposal diajukan oleh Pengurus UKM'
            ]);

            ProposalApproval::create([
                'proposal_id' => $proposal->id,
                'role_approval' => 'bem',
                'status' => 'Menunggu',
            ]);
            
            ProposalApproval::create([
                'proposal_id' => $proposal->id,
                'role_approval' => 'super_admin',
                'status' => 'Menunggu',
            ]);
        }

        return back()->with('success', 'File proposal berhasil diupload dan diajukan!');
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Revisi',
            'catatan' => 'nullable|string'
        ]);

        $proposal = Proposal::findOrFail($id);
        $userRole = Auth::user()->role; // 'bem', 'bpm', 'super_admin', etc.

        // Cari approval untuk role ini yang masih menunggu
        $approval = ProposalApproval::where('proposal_id', $proposal->id)
            ->where('role_approval', $userRole)
            ->where('status', 'Menunggu')
            ->first();

        if ($approval) {
            $approval->update([
                'user_id' => Auth::id(),
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);

            // Jika ditolak/revisi, set status akhir proposal
            if ($request->status != 'Disetujui') {
                $proposal->update(['status_akhir' => $request->status]);
            } else {
                // Cek apakah semua sudah disetujui
                $pending = ProposalApproval::where('proposal_id', $proposal->id)
                    ->where('status', 'Menunggu')
                    ->count();
                
                if ($pending == 0) {
                    $proposal->update(['status_akhir' => 'Disetujui']);
                }
            }

            return back()->with('success', 'Status persetujuan berhasil disimpan!');
        }

        return back()->with('error', 'Tidak ada aksi persetujuan yang bisa dilakukan saat ini.');
    }
}
