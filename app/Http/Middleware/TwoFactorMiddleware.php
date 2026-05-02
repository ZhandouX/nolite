<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {

            // Hindari redirect loop
            if ($request->routeIs('2fa.*') || $request->routeIs('logout')) {
                return $next($request);
            }

            // Belum punya secret → setup QR (hanya sekali seumur hidup akun)
            if (!$user->two_factor_secret || !$user->two_factor_enabled) {
                return redirect()->route('2fa.setup');
            }

            // Sudah setup, tapi belum verifikasi OTP di session ini → minta OTP
            if (!session('2fa_verified')) {
                return redirect()->route('2fa.verify');
            }
        }

        return $next($request);
    }
}
