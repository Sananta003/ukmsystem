<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Google2FA;

class TwoFactorController extends Controller
{
    public function setup()
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        if ($user->google2fa_secret) {
            return redirect()->route('dashboard')->with('info', '2FA sudah aktif.');
        }

        // Generate secret
        $secret = $google2fa->generateSecretKey();
        
        // Simpan secret ke session sementara sebelum diverifikasi
        session(['2fa_secret_setup' => $secret]);

        // Generate QR Code URL
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('auth.2fa_setup', ['QR_Image' => $QR_Image, 'secret' => $secret]);
    }

    public function verifySetup(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = session('2fa_secret_setup');

        if (!$secret) {
            return redirect()->route('2fa.setup')->withErrors(['otp' => 'Sesi setup kadaluarsa, silakan ulang.']);
        }

        $valid = $google2fa->verifyKey($secret, $request->otp);

        if ($valid) {
            // Save to database
            $user->update(['google2fa_secret' => $secret]);
            session()->forget('2fa_secret_setup');
            
            return redirect()->route('dashboard')->with('success', 'Autentikasi 2 Langkah berhasil diaktifkan!');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah. Silakan coba lagi.']);
    }

    public function verifyLogin()
    {
        return view('auth.2fa_verify');
    }

    public function postVerifyLogin(Request $request)
    {
        $request->validate(['one_time_password' => 'required|digits:6']);
        
        // This relies on pragmarx/google2fa-laravel default middleware
        // which automatically intercepts this. If we implement manual checking:
        
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            session(['2fa_passed' => true]);
            return redirect()->intended('/member/dashboard');
        }

        return back()->withErrors(['one_time_password' => 'Kode OTP tidak valid.']);
    }
}
