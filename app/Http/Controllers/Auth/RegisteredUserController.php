<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /* Show the registration view. */
    public function create(): View
    {
        return view('auth.register');
    }

    /* Handle an incoming registration request */
    public function store(Request $request): RedirectResponse
    {
        // ===== VALIDASI hCAPTCHA =====
        $hcaptcha = Http::asForm()->post('https://hcaptcha.com/siteverify', [
            'secret'   => 'ES_344252689c0d43018ff2374e334434db',
            'response' => $request->input('h-captcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$hcaptcha->json('success')) {
            return back()
                ->withErrors(['h-captcha-response' => 'Verifikasi captcha gagal, silakan coba lagi.'])
                ->withInput();
        }
        // ===== END hCAPTCHA =====

        // Validasi form
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Beri role default "customer" saat register
        $user->assignRole('customer');

        // Event Pendaftaran
        event(new Registered($user));

        return redirect('/')
            ->with('register_success', 'Akun berhasil dibuat. Silakan login menggunakan akun Anda.');
    }
}
