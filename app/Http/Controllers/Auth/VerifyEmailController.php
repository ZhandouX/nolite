<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Jika sudah diverifikasi sebelumnya
        if ($user->hasVerifiedEmail()) {
            return $this->redirectByRole($user);
        }

        // Jika berhasil memverifikasi sekarang
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectByRole($user);
    }

    /**
     * Redirect user ke dashboard sesuai role
     */
    private function redirectByRole($user): RedirectResponse
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('verified', 1);
        } elseif ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard')->with('verified', 1);
        }

        // Jika role tidak dikenal
        return redirect('/login')->with('error', 'Role tidak dikenali');
    }
}
