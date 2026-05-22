<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluasi;
use Illuminate\Support\Facades\Auth;

class EvaluasiController extends Controller
{
    public function index()
    {
        $ukmId = Auth::user()->ukm_id;
        
        $evaluasis = Evaluasi::with(['kegiatan', 'user'])
            ->whereHas('kegiatan', function ($query) use ($ukmId) {
                $query->where('ukm_id', $ukmId);
            })
            ->latest()
            ->paginate(15);

        $rataRata = Evaluasi::whereHas('kegiatan', function ($query) use ($ukmId) {
            $query->where('ukm_id', $ukmId);
        })->avg('rating');

        $rataRata = $rataRata ? number_format($rataRata, 1) : 0;

        // Distribusi Rating
        $distribusi = Evaluasi::selectRaw('rating, COUNT(*) as total')
            ->whereHas('kegiatan', function ($query) use ($ukmId) {
                $query->where('ukm_id', $ukmId);
            })
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->toArray();

        $ratingLabels = ['Bintang 5', 'Bintang 4', 'Bintang 3', 'Bintang 2', 'Bintang 1'];
        $ratingData = [
            $distribusi[5] ?? 0,
            $distribusi[4] ?? 0,
            $distribusi[3] ?? 0,
            $distribusi[2] ?? 0,
            $distribusi[1] ?? 0,
        ];

        return view('admin_ukm.evaluasi.index', compact('evaluasis', 'rataRata', 'ratingLabels', 'ratingData'));
    }
}
