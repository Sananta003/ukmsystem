<?php

namespace App\Http\Controllers;

use App\Models\Evaluasi;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
{
    public function index()
    {
        $ukm_id = Auth::user()->ukm_id;

        $kegiatanIds = Kegiatan::where('ukm_id', $ukm_id)->pluck('id');

        $evaluasis = Evaluasi::with(['user', 'kegiatan'])
            ->whereIn('kegiatan_id', $kegiatanIds)
            ->latest()
            ->get();

        $rataRata = $evaluasis->avg('rating') ?? 0;

        $distribusi = [
            5 => $evaluasis->where('rating', 5)->count(),
            4 => $evaluasis->where('rating', 4)->count(),
            3 => $evaluasis->where('rating', 3)->count(),
            2 => $evaluasis->where('rating', 2)->count(),
            1 => $evaluasis->where('rating', 1)->count(),
        ];

        $chartLabels = ['5 Bintang', '4 Bintang', '3 Bintang', '2 Bintang', '1 Bintang'];
        $chartData = [
            $distribusi[5],
            $distribusi[4],
            $distribusi[3],
            $distribusi[2],
            $distribusi[1],
        ];

        return view('admin_ukm.evaluasi.index', compact('evaluasis', 'rataRata', 'chartLabels', 'chartData'));
    }
}
