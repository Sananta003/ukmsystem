<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ukm;

class UkmController extends Controller
{
    public function explore()
    {
        $ukms = Ukm::withCount(['users' => function ($query) {
            $query->where('role', 'member');
        }])->get();
        
        return view('ukm.explore', compact('ukms'));
    }
}
