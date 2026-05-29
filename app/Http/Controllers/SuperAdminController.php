<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Keuangan;
use App\Models\KodePengajuan;
use App\Models\PengajuanUkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class SuperAdminController extends Controller
{
    public function index()
    {
        $ukms = Ukm::withCount(['users' => function ($query) {
            $query->where('role', 'member');
        }])->orderBy('created_at', 'desc')->paginate(10);

        $totalUkm = Ukm::count();
        $totalMahasiswa = User::where('role', 'member')->count();

        $kodeTersedia = KodePengajuan::where('status', 'tersedia')->latest()->get();
        $pengajuans = PengajuanUkm::where('status', 'pending_superadmin')->with('user')->latest()->get();
        
        $proposals = \App\Models\ProposalApproval::with(['proposal.kegiatan.ukm'])
            ->where('role_approval', 'super_admin')
            ->where('status', 'Menunggu')
            ->orderBy('id', 'desc')
            ->get();

        return view('superadmin.dashboard', compact('ukms', 'totalUkm', 'totalMahasiswa', 'kodeTersedia', 'pengajuans', 'proposals'));
    }

    public function create()
    {
        return view('superadmin.create_ukm');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'nama_ketua' => 'required|string|max:255',
            'email_ketua' => 'required|email|unique:users,email',
            'password_ketua' => 'required|min:6',
        ]);

        $ukm = Ukm::create([
            'nama_ukm' => $request->nama_ukm,
            'deskripsi' => $request->deskripsi,
        ]);

        User::create([
            'name' => $request->nama_ketua,
            'email' => $request->email_ketua,
            'password' => Hash::make($request->password_ketua),
            'role' => 'admin_ukm',
            'ukm_id' => $ukm->id,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'UKM Baru dan Akun Ketua berhasil dibuat!');
    }

    public function destroy($id)
    {
        $ukm = Ukm::findOrFail($id);
        
        User::where('ukm_id', $ukm->id)->delete();
        $ukm->delete();

        return redirect()->route('superadmin.dashboard')->with('success', 'UKM dan seluruh datanya berhasil dihapus.');
    }

    public function show($id)
    {
        $ukm = Ukm::findOrFail($id);
        $anggota = User::where('ukm_id', $id)->where('role', 'member')->get();
        $kegiatan = Kegiatan::where('ukm_id', $id)->orderBy('tanggal', 'desc')->get();
        $keuangan = Keuangan::where('ukm_id', $id)->orderBy('tanggal', 'desc')->get();

        $pemasukan = $keuangan->where('jenis', 'Pemasukan')->sum('nominal');
        $pengeluaran = $keuangan->where('jenis', 'Pengeluaran')->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;

        $grafikPengeluaran = Keuangan::where('ukm_id', $id)
            ->where('jenis', 'Pengeluaran')
            ->whereNotNull('kegiatan_id')
            ->selectRaw('kegiatan_id, sum(nominal) as total')
            ->groupBy('kegiatan_id')
            ->with('kegiatan')
            ->get()
            ->map(function($item) {
                return [
                    'nama_program' => $item->kegiatan ? $item->kegiatan->nama : 'Lainnya',
                    'total' => $item->total
                ];
            });

        $pengeluaranLainnya = Keuangan::where('ukm_id', $id)
            ->where('jenis', 'Pengeluaran')
            ->whereNull('kegiatan_id')
            ->sum('nominal');

        if ($pengeluaranLainnya > 0) {
            $grafikPengeluaran->push([
                'nama_program' => 'Operasional / Lainnya',
                'total' => $pengeluaranLainnya
            ]);
        }

        return view('superadmin.show_ukm', compact('ukm', 'anggota', 'kegiatan', 'keuangan', 'pemasukan', 'pengeluaran', 'saldo', 'grafikPengeluaran'));
    }

    public function showPengajuan($id)
    {
        $pengajuan = PengajuanUkm::with('user')->findOrFail($id);
        return view('superadmin.pengajuan_show', compact('pengajuan'));
    }

    public function approvePengajuan($id)
    {
        $pengajuan = PengajuanUkm::with('user')->findOrFail($id);

        $ukm = Ukm::create([
            'nama_ukm' => $pengajuan->nama_ukm,
            'deskripsi' => $pengajuan->latar_belakang,
            'logo' => $pengajuan->logo,
        ]);

        $pengajuan->user->update([
            'role' => 'admin_ukm',
            'ukm_id' => $ukm->id
        ]);

        $pengajuan->update(['status' => 'approved']);

        return redirect()->route('superadmin.dashboard')->with('success', 'Proposal disetujui! UKM resmi didirikan dan mahasiswa pengaju otomatis menjadi Admin UKM tersebut.');
    }

    public function rejectPengajuan($id)
    {
        $pengajuan = PengajuanUkm::findOrFail($id);
        $pengajuan->update(['status' => 'rejected']);

        return redirect()->route('superadmin.dashboard')->with('success', 'Proposal pengajuan UKM ditolak.');
    }
}