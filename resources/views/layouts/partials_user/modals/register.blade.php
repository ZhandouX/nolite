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

                    <!-- Tombol Register -->
                    <button type="submit" class="submit-btn">Buat Akun Baru</button>

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

        <!-- Pesan Sukses -->
        <div class="success-message hidden" id="registerSuccess">
            <i class="fas fa-check-circle"></i>
            <span>Akun berhasil dibuat!</span>
        </div>
    </div>
</div>