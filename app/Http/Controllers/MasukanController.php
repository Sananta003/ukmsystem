<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masukan;

class MasukanController extends Controller
{
    public function create()
    {
        return view('masukan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string|max:1000',
        ]);

        Masukan::create($request->all());

        return redirect()->route('welcome')->with('success', 'Terima kasih! Masukan Anda telah kami terima.');
    }
}
