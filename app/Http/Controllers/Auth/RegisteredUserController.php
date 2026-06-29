<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
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
                ->withErrors([
                    'h-captcha-response' => 'Verifikasi captcha gagal, silakan coba lagi.'
                ])
                ->withInput();
        }

        // ================= VALIDASI =================
        $validator = Validator::make($request->all(), [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
            ],

            'password_confirmation' => [
                'required',
            ],

        ], [

            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',

        ]);

        $validator->after(function ($validator) use ($request) {

            $password = $request->password;

            // Password minimal 8 karakter
            if (strlen($password) < 8) {
                $validator->errors()->add(
                    'password',
                    'Password minimal harus 8 karakter.'
                );
                return;
            }

            $score = 0;

            if (preg_match('/[a-z]/', $password)) $score++;
            if (preg_match('/[A-Z]/', $password)) $score++;
            if (preg_match('/[0-9]/', $password)) $score++;
            if (preg_match('/[\W_]/', $password)) $score++;

            // Password Lemah
            if ($score <= 2) {
                $validator->errors()->add(
                    'password',
                    'Password masih lemah. Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol.'
                );
            }

            // Password Cukup
            elseif ($score == 3) {
                $validator->errors()->add(
                    'password',
                    'Password cukup kuat, tetapi belum memenuhi standar keamanan. Tambahkan kombinasi karakter agar menjadi kuat.'
                );
            }

            // Konfirmasi password
            if ($request->password !== $request->password_confirmation) {
                $validator->errors()->add(
                    'password_confirmation',
                    'Konfirmasi password tidak cocok.'
                );
            }

        });

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // ================= SIMPAN USER =================
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Role default
        $user->assignRole('customer');

        // Event
        event(new Registered($user));

        return redirect('/')
            ->with(
                'register_success',
                'Akun berhasil dibuat. Silakan login menggunakan akun Anda.'
            );
    }
}
