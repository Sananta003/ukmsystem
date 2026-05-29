<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        try {
            if ($request->has('ukm_id')) {
                $request->session()->put('pending_ukm_id', $request->ukm_id);
            }
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $th) {
            return redirect()->route('login')->withErrors(['error' => 'Sistem SSO Google error: ' . $th->getMessage() . '. Pastikan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET sudah diisi di file .env']);
        }
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $pendingUkmId = session()->pull('pending_ukm_id');

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update google_id if empty
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                
                // If registering for a UKM via SSO but account already exists, attach ukm_id if they are a standard member without one
                if ($pendingUkmId && is_null($user->ukm_id) && $user->role === 'member') {
                    $user->update(['ukm_id' => $pendingUkmId]);
                }
                
                Auth::login($user);
            } else {
                // Register new user automatically as member
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)), // Random password for SSO users
                    'role' => 'member',
                    'ukm_id' => $pendingUkmId,
                ]);
                Auth::login($user);
            }

            $role = $user->role;
            if ($role === 'super_admin') {
                return redirect()->intended(route('superadmin.dashboard')); 
            } elseif ($role === 'admin_ukm') {
                return redirect()->intended(route('admin-ukm.dashboard'));
            } elseif ($role === 'inisiator') {
                return redirect()->intended(route('inisiator.dashboard'));
            } elseif ($role === 'member') {
                return redirect()->intended(route('member.dashboard'));
            } elseif (in_array($role, ['bem', 'bpm'])) {
                return redirect()->intended(route('birokrasi.dashboard'));
            }

            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Gagal login dengan Google: ' . $e->getMessage()]);
        }
    }
}
