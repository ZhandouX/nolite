<div id="registerModal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[9999] transition-opacity duration-300">
    <div class="bg-transparent relative md:w-full md:max-w-md p-0">

        <!-- Tombol Close -->
        <button type="button" onclick="closeRegisterModal()"
            class="absolute -top-4 -right-4 bg-white text-gray-700 hover:bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-lg text-xl z-[10000]">
            &times;
        </button>

        <!-- ===== Konten Register ===== -->
        <div class="form-container">
            <div class="form-header">
                <h1 class="text-2xl font-bold mb-2">Register</h1>
            </div>

            <div class="form-content">
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <div class="input-container">
                            <input id="registerName" type="text" name="name" required placeholder=" " class="form-input"
                                value="{{ old('name') }}" autofocus />
                            <label for="registerName" class="floating-label">Nama Lengkap*</label>
                        </div>
                        @error('name')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <div class="input-container">
                            <input id="registerEmail" type="email" name="email" required placeholder=" "
                                class="form-input" value="{{ old('email') }}" />
                            <label for="registerEmail" class="floating-label">Email*</label>
                        </div>
                        @error('email')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="input-container">
                            <input id="registerPassword" type="password" name="password" required placeholder=" "
                                class="form-input" />
                            <label for="registerPassword" class="floating-label">Password*</label>
                            <button type="button" class="password-toggle" id="registerPasswordToggle">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" id="passwordStrength"></div>
                        </div>
                        <div class="password-strength" id="passwordText">Status Password</div>
                        @error('password')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <div class="input-container">
                            <input id="registerPasswordConfirmation" type="password" name="password_confirmation"
                                required placeholder=" " class="form-input" />
                            <label for="registerPasswordConfirmation" class="floating-label">Konfirmasi
                                Password*</label>
                        </div>
                        @error('password_confirmation')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ===== hCAPTCHA ===== --}}
                    <div class="form-group">
                        <div id="hcaptcha-register" class="h-captcha" data-sitekey="{{ env('HCAPTCHA_SITEKEY') }}"
                            data-theme="light" data-size="normal">
                        </div>
                        @error('h-captcha-response')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- ===== END hCAPTCHA ===== --}}

                    <!-- Tombol Register -->
                    <button id="registerSubmit" type="submit" class="submit-btn">
                        Buat Akun Baru
                    </button>

                    <!-- Link ke Login -->
                    <div class="login-link">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <button type="button" onclick="switchToLoginModal()"
                                class="font-medium text-blue-600 hover:underline">
                                Login Disini
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================= REGISTER SUCCESS ================= --}}
@if (session('register_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            window.notyf.open({
                type: 'success',
                message: @json(session('register_success'))
            });

            setTimeout(() => {
                openLoginModal();
            }, 1800);

        });
    </script>
@endif

{{-- ================= REGISTER ERROR ================= --}}
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // buka kembali modal register
            openRegisterModal();

            // tampilkan semua error menggunakan Notyf
            setTimeout(() => {

                @foreach ($errors->all() as $error)
                    window.notyfError.open({
                        type: 'error',
                        message: @json($error)
                    });
                @endforeach

                                    }, 500);

        });
    </script>
@endif



{{-- hCaptcha CDN --}}
<script src="https://js.hcaptcha.com/1/api.js" async defer></script>

<script>
    const registerForm = document.getElementById('registerForm');
    const passwordInput = document.getElementById('registerPassword');
    const confirmPasswordInput = document.getElementById('registerPasswordConfirmation');

    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordText');
    // ===== RENDER hCaptcha saat modal dibuka =====
    let hcaptchaRendered = false;

    function openRegisterModal() {
        const modal = document.getElementById('registerModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Render hCaptcha hanya sekali
        if (!hcaptchaRendered) {
            setTimeout(() => {
                if (typeof hcaptcha !== 'undefined') {
                    hcaptcha.render('hcaptcha-register', {
                        sitekey: '{{ env('HCAPTCHA_SITEKEY') }}'
                    });
                    hcaptchaRendered = true;
                }
            }, 500);
        }
    }

    function closeRegisterModal() {
        const modal = document.getElementById('registerModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // ================= PASSWORD STRENGTH =================

    function checkPasswordStrength() {

        const password = passwordInput.value;

        const hasMinLength = password.length >= 8;
        const hasLower = /[a-z]/.test(password);
        const hasUpper = /[A-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSymbol = /[\W_]/.test(password);

        if (password.length === 0) {

            strengthBar.style.width = "0%";
            strengthBar.style.background = "#e5e7eb";
            strengthText.innerHTML = "Status Password";

            return;
        }

        const isStrong =
            hasMinLength &&
            hasLower &&
            hasUpper &&
            hasNumber &&
            hasSymbol;

        if (isStrong) {

            strengthBar.style.width = "100%";
            strengthBar.style.background = "#22c55e";
            strengthText.innerHTML = "🟢 Password Kuat";

        } else {

            strengthBar.style.width = "50%";
            strengthBar.style.background = "#ef4444";
            strengthText.innerHTML = "🔴 Password Lemah";

        }

    }

    passwordInput.addEventListener('input', checkPasswordStrength);

    // ================= VALIDASI SUBMIT =================

    registerForm.addEventListener('submit', function (e) {

        const password = passwordInput.value;
        const confirm = confirmPasswordInput.value;

        let score = 0;

        const hasMinLength = password.length >= 8;
        const hasLower = /[a-z]/.test(password);
        const hasUpper = /[A-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSymbol = /[\W_]/.test(password);

        if (password.length < 8) {

            e.preventDefault();

            window.notyfError.open({

                type: 'error',

                message: 'Password minimal harus 8 karakter.'

            });

            return;

        }

        if (!hasMinLength) {

            e.preventDefault();

            window.notyfError.open({
                type: 'error',
                message: 'Password minimal harus 8 karakter.'
            });

            return;
        }

        if (!hasLower || !hasUpper || !hasNumber || !hasSymbol) {

            e.preventDefault();

            window.notyfError.open({
                type: 'error',
                message: 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
            });

            return;
        }

        if (password !== confirm) {

            e.preventDefault();

            window.notyfError.open({

                type: 'error',

                message: 'Konfirmasi password tidak cocok.'

            });

            return;

        }

    });
</script>