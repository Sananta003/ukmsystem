<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan model User, BUKAN model Kegiatan
        $query = User::where('ukm_id', Auth::user()->ukm_id)->where('role', 'member');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $anggota = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
            
        return view('admin_ukm.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('admin_ukm.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'ukm_id' => Auth::user()->ukm_id,
        ]);

        return redirect()->route('admin-ukm.anggota.index');
    }

    public function destroy($id)
    {
        $anggota = User::where('ukm_id', Auth::user()->ukm_id)
            ->where('role', 'member')
            ->findOrFail($id);
            
        $anggota->delete();

        return redirect()->route('admin-ukm.anggota.index');
    }
}