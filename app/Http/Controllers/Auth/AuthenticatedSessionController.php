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
        // Proses autentikasi user
        $request->authenticate();

        // Regenerasi session setelah login untuk keamanan
        $request->session()->regenerate();

        // Ambil user yang baru login
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard');
        }

        // Jika role tidak dikenali
        Auth::logout();
        return redirect('/')
            ->with('showLoginModal', true);
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout user
        Auth::guard('web')->logout();

        // Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman awal
        return redirect('/');
    }
}
