<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ukm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $role = Auth::user()->role;
            if ($role === 'super_admin') {
                return redirect()->route('superadmin.dashboard'); 
            } elseif ($role === 'admin_ukm') {
                return redirect()->route('admin-ukm.dashboard');
            } elseif ($role === 'member') {
                if (is_null(Auth::user()->ukm_id)) {
                    return redirect()->route('inisiator.dashboard');
                }
                return redirect()->route('member.dashboard');
            } elseif (in_array($role, ['bem', 'bpm'])) {
                return redirect()->route('birokrasi.dashboard');
            }
            
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    public function register(Request $request)
    {
        $ukms = Ukm::all();
        $selectedUkm = $request->query('ukm'); 
        
       return view('register', compact('ukms', 'selectedUkm'));
    }

    public function registerFounder()
    {
        return view('auth.register_founder');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'ukm_id' => 'nullable|exists:ukms,id', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'ukm_id' => $request->ukm_id,
        ]);

        Auth::login($user);

        if (is_null($request->ukm_id)) {
            return redirect()->route('inisiator.pengajuan.create');
        }

        return redirect()->route('member.dashboard');    
    }
    
}