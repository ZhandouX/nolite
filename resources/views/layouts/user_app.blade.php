<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Shop</title>
    <link rel="stylesheet" href="{{ asset('assets/css/user/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/user/keranjang.css') }}" />
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">

    @stack('style')
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.partials_user.sidebar')

    {{-- OVERLAY --}}
    <div id="overlay"></div>

    {{-- NAVBAR --}}
    <header>
        @include('layouts.partials_user.navbar')
    </header>

    @yield('content')

    {{-- FOOTER --}}
    @include('layouts.partials_user.footer')

    {{-- CART POPUP --}}
    <div id="cartPopupContainer" class="fixed bottom-6 right-24 z-50 flex flex-col gap-2"></div>

    {{-- BACK TO TOP --}}
    <button id="backToTop" title="Kembali ke atas"
        class="fixed bottom-6 right-6 w-12 h-12 bg-gray-400 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-700 hover:scale-110 transition-all duration-300 z-50">
        <i data-lucide="arrow-up" class="w-6 h-6"></i>
    </button>

    {{-- LOGIN MODAL --}}
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
                                <input id="loginEmail" type="email" name="email" required placeholder=" "
                                    class="form-input" value="{{ old('email') }}" autofocus />
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

    {{-- REGISTER MODAL --}}
    <div id="registerModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[9999] transition-opacity duration-300">
        <div class="bg-transparent relative w-full max-w-md p-0">
            <button type="button" onclick="closeRegisterModal()"
                class="absolute -top-4 -right-4 bg-white text-gray-700 hover:bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-lg text-xl z-[10000]">
                &times;
            </button>
            <div class="form-container w-full max-w-md">
                <div class="form-header">
                    <h1 class="text-2xl font-bold mb-2">Register</h1>
                </div>

                <div class="form-content">
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- NAMA --}}
                        <div class="form-group">
                            <div class="input-container">
                                <input id="registerName" type="text" name="name" required placeholder=" "
                                    class="form-input" value="{{ old('name') }}" autofocus />
                                <label for="registerName" class="floating-label">Nama Lengkap*</label>
                            </div>
                            @error('name')
                                <div class="input-error">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
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

                        {{-- PASSWORD --}}
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

                        {{-- CONFIRM PASSWORD --}}
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

                        <button type="submit" class="submit-btn">Buat Akun Baru</button>

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
            <div class="success-message hidden" id="registerSuccess">
                <i class="fas fa-check-circle"></i>
                <span>Akun berhasil dibuat!</span>
            </div>
        </div>
    </div>

    {{-- JS: LOGIN & REGISTER MODAL --}}
    <script>
        function openLoginModal() {
            closeRegisterModal();
            const modal = document.getElementById('loginModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.getElementById('loginModal').addEventListener('click', e => {
            if (e.target === e.currentTarget) closeLoginModal();
        });

        function openRegisterModal() {
            closeLoginModal();
            const modal = document.getElementById('registerModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeRegisterModal() {
            const modal = document.getElementById('registerModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        document.getElementById('registerModal').addEventListener('click', e => {
            if (e.target === e.currentTarget) closeRegisterModal();
        });

        function switchToRegisterModal() {
            closeLoginModal();
            setTimeout(() => openRegisterModal(), 200);
        }
        function switchToLoginModal() {
            closeRegisterModal();
            setTimeout(() => openLoginModal(), 200);
        }

        const loginToggle = document.getElementById('loginPasswordToggle');
        const loginInput = document.getElementById('loginPassword');
        const loginIcon = loginToggle.querySelector('i');
        loginToggle.addEventListener('click', () => {
            const isHidden = loginInput.type === 'password';
            loginInput.type = isHidden ? 'text' : 'password';
            loginIcon.classList.toggle('fa-eye');
            loginIcon.classList.toggle('fa-eye-slash');
        });

        const regToggle = document.getElementById('registerPasswordToggle');
        const regInput = document.getElementById('registerPassword');
        const regIcon = regToggle.querySelector('i');
        regToggle.addEventListener('click', () => {
            const isHidden = regInput.type === 'password';
            regInput.type = isHidden ? 'text' : 'password';
            regIcon.classList.toggle('fa-eye');
            regIcon.classList.toggle('fa-eye-slash');
        });

        const bar = document.getElementById('passwordStrength');
        const text = document.getElementById('passwordText');
        regInput.addEventListener('input', () => {
            const val = regInput.value;
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;
            const colors = ['#e53e3e', '#ed8936', '#38a169', '#1a1a1a'];
            const texts = ['Lemah', 'Cukup', 'Baik', 'Sangat Kuat'];
            bar.style.width = strength * 25 + '%';
            bar.style.backgroundColor = colors[strength - 1] || '#333';
            text.textContent = texts[strength - 1] || 'Status Password';
            text.style.color = colors[strength - 1] || '#333';
        });

        document.getElementById('loginForm').addEventListener('submit', e => {
            const btn = e.target.querySelector('.submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            btn.disabled = true;
        });
        document.getElementById('registerForm').addEventListener('submit', e => {
            const btn = e.target.querySelector('.submit-btn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;
        });
    </script>

    {{-- JS: CART POPUP --}}
    <script>
        function showCartPopup(totalProduk) {
            const container = document.getElementById('cartPopupContainer');
            container.innerHTML = '';

            const popup = document.createElement('div');
            popup.className =
                "bg-gray-400/95 text-white rounded-2xl shadow-2xl flex items-center justify-between gap-3 px-5 py-4 w-80 cursor-pointer hover:bg-gray-500/95 transition-all duration-300 animate-slide-up animate-border-gray backdrop-blur-sm";
            popup.onclick = () => {
                window.location.href = "{{ route('keranjang.index') }}";
            };

            popup.innerHTML = `
            <div class="flex items-center gap-3 relative">
                <div class="relative">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-white-400"></i>
                    <span class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                        ${totalProduk}
                    </span>
                </div>
                <span class="text-base font-medium">
                    Ada <strong>${totalProduk}</strong> produk di keranjang
                </span>
            </div>
            <button class="text-gray-400 hover:text-white text-lg font-bold" onclick="closePopup(event, this)">×</button>
        `;

            container.appendChild(popup);
            if (window.lucide) lucide.createIcons();
        }

        function closePopup(e, btn) {
            e.stopPropagation();
            const popup = btn.parentElement;
            popup.remove();
        }

        function addToCart(id) {
            const qtyInput = document.getElementById(`qty-${id}`);
            const qty = parseInt(qtyInput?.value || 1);

            fetch(`/keranjang/tambah`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    produk_id: id,
                    jumlah: qty
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showCartPopup(data.total_produk_unik);
                        updateCartBadge(data.total_produk_unik);
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', updateCartPopup);

        function updateCartPopup() {
            fetch('/keranjang/cek', {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            })
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('cartPopupContainer');
                    container.innerHTML = '';

                    if (data.items && data.items.length > 0) {
                        const totalProdukUnik = data.items.length;
                        showCartPopup(totalProdukUnik);
                        updateCartBadge(totalProdukUnik);
                    } else {
                        updateCartBadge(0);
                    }
                });
        }

        function updateCartBadge(totalProduk) {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                if (totalProduk > 0) {
                    badge.textContent = totalProduk;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        }

        const style = document.createElement('style');
        style.innerHTML = `
        @keyframes slide-up {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up {
            animation: slide-up 0.4s ease-out;
        }

        @keyframes border-pulse-gray {
            0% { box-shadow: 0 0 0 0 rgba(156, 163, 175, 0.5); }
            50% { box-shadow: 0 0 0 6px rgba(156, 163, 175, 0.2); }
            100% { box-shadow: 0 0 0 0 rgba(156, 163, 175, 0.5); }
        }

        .animate-border-gray {
            border: 1px solid #9ca3af; /* abu-abu netral */
            border-radius: 1rem;
            animation: border-pulse-gray 1.5s infinite;
        }

        /* Responsif: Jika layar kecil, popup naik ke atas tombol */
        @media (max-width: 640px) {
            #cartPopupContainer {
                right: 6px !important;
                width: 90%;
            }
        }
    `;
        document.head.appendChild(style);
    </script>
    <script src="{{ asset('assets/js/user/landing-page.js') }}"></script>
    @stack('script')

    {{-- JS: BUY & CART --}}
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeModal(id);
                });
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('hidden');
        }

        function addToCart(id) {
            const warna = document.querySelector(`#selectedColor-${id}`)?.value;
            const ukuran = document.querySelector(`#selectedSize-${id}`)?.value;
            const qty = document.querySelector(`#qty-${id}`)?.value || 1;

            if (!warna || !ukuran) {
                alert('Silakan pilih warna dan ukuran terlebih dahulu!');
                return;
            }

            if (!warna || !ukuran) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Varian Dulu!',
                    text: 'Silakan pilih warna dan ukuran sebelum menambahkan ke keranjang.',
                    confirmButtonColor: '#3b82f6',
                    background: '#fff',
                    color: '#374151',
                    iconColor: '#facc15',
                });
                return;
            }

            fetch("{{ route('keranjang.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    produk_id: id,
                    warna: warna,
                    ukuran: ukuran,
                    jumlah: qty
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.error,
                            background: '#fff',
                            color: '#374151',
                            confirmButtonColor: '#ef4444',
                            iconColor: '#ef4444'
                        });
                    } else {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            position: 'top-end',
                            toast: true,
                            background: '#ffffff',
                            color: '#333',
                            iconColor: '#22c55e',
                            showClass: { popup: 'animate__animated animate__fadeInDown' },
                            hideClass: { popup: 'animate__animated animate__fadeOutUp' }
                        });
                        closeModal(`productModal-${id}`);
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Gagal menambahkan produk ke keranjang.',
                        background: '#fff',
                        color: '#374151',
                        confirmButtonColor: '#ef4444',
                        iconColor: '#ef4444'
                    });
                    console.error(err);
                });
        }

        document.addEventListener('click', e => {
            if (e.target.closest('.color-btn')) {
                const btn = e.target.closest('.color-btn');
                const itemId = btn.dataset.item;
                document.querySelectorAll(`[data-item="${itemId}"].color-btn`)
                    .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
                btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
                document.getElementById(`selectedColor-${itemId}`).value = btn.dataset.color;
            }

            if (e.target.closest('.size-btn')) {
                const btn = e.target.closest('.size-btn');
                const itemId = btn.dataset.item;
                document.querySelectorAll(`[data-item="${itemId}"].size-btn`)
                    .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
                btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
                document.getElementById(`selectedSize-${itemId}`).value = btn.dataset.size;
            }
        });

        function decreaseQty(id) {
            const input = document.getElementById(`qty-${id}`);
            const min = parseInt(input.min);
            let value = parseInt(input.value);
            if (value > min) input.value = value - 1;
        }

        function increaseQty(id, max) {
            const input = document.getElementById(`qty-${id}`);
            const value = parseInt(input.value);
            if (value < max) input.value = value + 1;
        }

        document.addEventListener('input', e => {
            if (e.target.matches('input[id^="qty-"]')) {
                const input = e.target;
                const min = parseInt(input.min);
                const max = parseInt(input.max);
                let val = parseInt(input.value);

                if (isNaN(val) || val < min) input.value = min;
                if (val > max) input.value = max;
            }
        });

        function updateQty(btn, change) {
            const parent = btn.closest('div');
            const input = parent.querySelector('input[type="number"]');
            const max = parseInt(input.max);
            const min = parseInt(input.min);
            let value = parseInt(input.value) || 1;

            value += change;
            if (value < min) value = min;
            if (value > max) value = max;

            input.value = value;
        }

        function incrementQty(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
            input.classList.add('ring-2', 'ring-green-400');
            setTimeout(() => {
                input.classList.remove('ring-2', 'ring-green-400');
            }, 200);
        }

        function decrementQty(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const currentValue = parseInt(input.value) || 1;

            if (currentValue > 1) {
                input.value = currentValue - 1;

                input.classList.add('ring-2', 'ring-red-400');
                setTimeout(() => {
                    input.classList.remove('ring-2', 'ring-red-400');
                }, 200);
            }
        }

        function validateQty(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const value = parseInt(input.value);

            if (isNaN(value) || value < 1) {
                input.value = 1;
            }
        }
    </script>

    @if (session('showLoginModal'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('loginModal');
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                }
            });
        </script>
    @endif
</body>

</html>