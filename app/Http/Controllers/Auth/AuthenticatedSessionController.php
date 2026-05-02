<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->hasRole('admin')) {

        // Belum setup 2FA → setup QR dulu (hanya pertama kali)
        if (!$user->two_factor_secret || !$user->two_factor_enabled) {
            return redirect()->route('2fa.setup');
        }

        // Sudah setup → langsung minta OTP setiap login
        return redirect()->route('2fa.verify');
    }

    if ($user->hasRole('customer')) {
        return redirect()->route('customer.dashboard');
    }

    Auth::logout();
    return redirect('/')->with('showLoginModal', true);
}

public function destroy(Request $request): RedirectResponse
{
    Auth::guard('web')->logout();

    // Hapus session 2FA saat logout agar login berikutnya minta OTP lagi
    $request->session()->forget('2fa_verified');

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
}
