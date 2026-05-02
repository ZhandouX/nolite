<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Setup 2FA - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="/assets/css/auth/login.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="form-container w-full max-w-md">

        {{-- Header --}}
        <div class="form-header">
            <h1 class="text-2xl font-bold mb-2">Setup Google Authenticator</h1>
            <p class="text-sm opacity-80">Keamanan Akun Admin</p>
        </div>

        {{-- Form Content --}}
        <div class="form-content">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Langkah --}}
            <div class="mb-4 text-sm text-gray-600 space-y-1">
                <p><i class="fas fa-mobile-alt mr-1 text-blue-500"></i> 1. Download <strong>Google Authenticator</strong> di HP kamu</p>
                <p><i class="fas fa-plus-circle mr-1 text-blue-500"></i> 2. Tap tombol <strong>+</strong> → pilih <strong>Scan QR Code</strong></p>
                <p><i class="fas fa-qrcode mr-1 text-blue-500"></i> 3. Scan QR code di bawah ini:</p>
            </div>

            {{-- QR Code --}}
            <div class="flex justify-center mb-4 p-4 bg-white border rounded-lg shadow-sm">
                {!! $qrCodeSvg !!}
            </div>

            {{-- Manual Secret --}}
            <p class="text-xs text-gray-500 mb-1 text-center">
                Atau masukkan kode ini secara manual ke aplikasi:
            </p>
            <div class="bg-gray-100 p-3 rounded-lg text-center font-mono tracking-widest text-sm mb-6 select-all cursor-pointer border"
                 title="Klik untuk copy" onclick="navigator.clipboard.writeText('{{ $secret }}'); alert('Kode disalin!')">
                {{ $secret }}
                <i class="fas fa-copy ml-2 text-gray-400 text-xs"></i>
            </div>

            {{-- Form Konfirmasi --}}
            <form method="POST" action="{{ route('2fa.enable') }}">
                @csrf
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Masukkan 6 digit kode dari aplikasi:
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
                    <i class="fas fa-shield-alt mr-2"></i> Aktifkan 2FA
                </button>
            </form>

            {{-- Back --}}
            <div class="register-link mt-4">
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-500 hover:underline">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</body>
</html>
