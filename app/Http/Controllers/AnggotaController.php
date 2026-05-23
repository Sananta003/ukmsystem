<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Anggota;
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
            'nim' => 'required|string|max:50',
            'fakultas' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|max:20',
            'status' => 'required|string',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('anggotas', 'public');
        }

        // Create user login with default password
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'member',
            'ukm_id' => Auth::user()->ukm_id,
        ]);

        // Create anggota record
        Anggota::create([
            'ukm_id' => Auth::user()->ukm_id,
            'nama' => $request->name,
            'nim' => $request->nim,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin-ukm.anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
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