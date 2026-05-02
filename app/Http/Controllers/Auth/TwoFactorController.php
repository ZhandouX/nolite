<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorController extends Controller
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    // -------------------------------------------------------
    // Halaman Setup QR Code (Admin scan pertama kali)
    // -------------------------------------------------------
    public function setup(): View|RedirectResponse
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        // Generate secret jika belum ada
        if (!$user->two_factor_secret) {
            $user->update([
                'two_factor_secret' => $this->google2fa->generateSecretKey()
            ]);
        }

        // Buat QR Code URL
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->two_factor_secret
        );

        // Render QR Code sebagai SVG
        $renderer  = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $qrCodeSvg = (new Writer($renderer))->writeString($qrCodeUrl);

        return view('auth.two-factor-setup', [
            'qrCodeSvg' => $qrCodeSvg,
            'secret'    => $user->two_factor_secret,
        ]);
    }

    // -------------------------------------------------------
    // Aktifkan 2FA setelah admin scan & input kode
    // -------------------------------------------------------
    public function enable(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user  = Auth::user();
        $valid = $this->google2fa->verifyKey(
            $user->two_factor_secret,
            $request->code
        );

        if (!$valid) {
            return back()->withErrors([
                'code' => 'Kode tidak valid, coba lagi.'
            ]);
        }

        $user->update(['two_factor_enabled' => true]);
        session(['2fa_verified' => true]);

        return redirect()->route('admin.dashboard') // ✅ fix
            ->with('success', '2FA berhasil diaktifkan!');
    }

    // -------------------------------------------------------
    // Halaman Verifikasi OTP saat login
    // -------------------------------------------------------
    public function verify(): View|RedirectResponse
    {
        // Jika sudah verified, langsung ke dashboard
        if (session('2fa_verified')) {
            return redirect()->route('admin.dashboard'); // ✅ fix
        }

        return view('auth.two-factor-verify');
    }

    // -------------------------------------------------------
    // Proses validasi OTP saat login
    // -------------------------------------------------------
    public function validateOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user  = Auth::user();
        $valid = $this->google2fa->verifyKey(
            $user->two_factor_secret,
            $request->code
        );

        if (!$valid) {
            return back()->withErrors([
                'code' => 'Kode OTP tidak valid.'
            ]);
        }

        session(['2fa_verified' => true]);

        return redirect()->intended(route('admin.dashboard')); // ✅ fix
    }

    // -------------------------------------------------------
    // Nonaktifkan 2FA
    // -------------------------------------------------------
    public function disable(): RedirectResponse
    {
        Auth::user()->update([
            'two_factor_enabled' => false,
            'two_factor_secret'  => null,
        ]);

        session()->forget('2fa_verified');

        return redirect()->route('admin.dashboard') // ✅ fix
            ->with('success', '2FA berhasil dinonaktifkan.');
    }
}
