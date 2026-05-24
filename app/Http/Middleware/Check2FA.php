<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Check2FA
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Jika user punya 2FA secret, dan belum melewati verifikasi 2FA di sesi ini
        if ($user && $user->google2fa_secret && !session('2fa_passed')) {
            // Kecualikan rute 2fa verify agar tidak looping
            if (!$request->is('2fa/verify') && !$request->is('logout')) {
                return redirect()->route('2fa.verify');
            }
        }

        return $next($request);
    }
}
