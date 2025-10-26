<div id="loginModal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[9999] transition-opacity duration-300">
    <div class="bg-transparent relative w-full max-w-md p-0">

        <!-- Tombol Close -->
        <button type="button" onclick="closeLoginModal()"
            class="absolute -top-4 -right-4 bg-white text-gray-700 hover:bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-lg text-xl z-[10000]">
            &times;
        </button>

        <!-- ===== Konten Login ===== -->
        <div class="form-container w-full max-w-md">
            <div class="form-header">
                <h1 class="text-2xl font-bold mb-2">Login</h1>
            </div>

            <div class="form-content">
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <div class="input-container">
                            <input id="loginEmail" type="email" name="email" required placeholder=" " class="form-input"
                                value="{{ old('email') }}" autofocus />
                            <label for="loginEmail" class="floating-label">Email*</label>
                        </div>
                        @error('email')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="input-container">
                            <input id="loginPassword" type="password" name="password" required placeholder=" "
                                class="form-input" />
                            <label for="loginPassword" class="floating-label">Password*</label>
                            <button type="button" class="password-toggle" id="loginPasswordToggle">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="input-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember" class="text-sm text-gray-700">Ingat Saya</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="submit-btn">Masuk</button>

                    <!-- Link ke Register -->
                    <div class="register-link">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <button type="button" onclick="switchToRegisterModal()"
                                class="font-medium text-blue-600 hover:underline">
                                Daftar Disini
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Pesan Sukses -->
        <div class="success-message hidden" id="loginSuccess">
            <i class="fas fa-check-circle"></i>
            <span>Login berhasil!</span>
        </div>
    </div>
</div>