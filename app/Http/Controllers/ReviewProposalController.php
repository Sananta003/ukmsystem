<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\ProposalApproval;
use Illuminate\Support\Facades\Auth;

class ReviewProposalController extends Controller
{
    public function show($id)
    {
        $proposal = Proposal::with('kegiatan')->findOrFail($id);
        
        $approvals = ProposalApproval::where('proposal_id', $proposal->id)
            ->with('user')
            ->orderBy('id', 'asc')
            ->get();

        return view('review_proposal', compact('proposal', 'approvals'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Revisi',
            'catatan' => 'nullable|string'
        ]);

        $proposal = Proposal::findOrFail($id);
        $userRole = Auth::user()->role; 

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
                // Majukan ke langkah berikutnya
                if ($userRole === 'bem') {
                    $nextApproval = ProposalApproval::where('proposal_id', $proposal->id)->where('role_approval', 'bpm')->first();
                    if ($nextApproval) $nextApproval->update(['status' => 'Menunggu']);
                } elseif ($userRole === 'bpm') {
                    $nextApproval = ProposalApproval::where('proposal_id', $proposal->id)->where('role_approval', 'super_admin')->first();
                    if ($nextApproval) $nextApproval->update(['status' => 'Menunggu']);
                } elseif ($userRole === 'super_admin') {
                    $proposal->update(['status_akhir' => 'Disetujui']);
                }
            }

            return back()->with('success', 'Status persetujuan berhasil disimpan!');
        }

        return back()->with('error', 'Tidak ada aksi persetujuan yang bisa dilakukan saat ini.');
    }
}
