<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verifikasi 2FA - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="/assets/css/auth/login.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="form-container w-full max-w-md">

        {{-- Header --}}
        <div class="form-header">
            <h1 class="text-2xl font-bold mb-2">Verifikasi 2FA</h1>
            <p class="text-sm opacity-80">Masukkan kode dari Google Authenticator</p>
        </div>

        {{-- Form Content --}}
        <div class="form-content">

            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md text-sm text-blue-700">
                <i class="fas fa-info-circle mr-1"></i>
                Buka aplikasi <strong>Google Authenticator</strong> di HP kamu dan masukkan kode 6 digit yang tertera.
            </div>

            <form method="POST" action="{{ route('2fa.validate') }}">
                @csrf
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kode OTP
                    </label>
                    <div class="input-container">
                        <input
                            type="text"
                            name="code"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]{6}"
                            class="form-input text-center text-2xl tracking-widest"
                            placeholder="000000"
                            required
                            autofocus
                        />
                    </div>
                    @error('code')
                        <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-check-circle mr-2"></i> Verifikasi & Masuk
                </button>
            </form>

            {{-- Logout --}}
            <div class="register-link mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:underline">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                    </button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>
