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

    {{-- KERANJANG POPUP --}}
    <div id="cartPopupContainer" class="fixed z-50 flex flex-col gap-1
            sm:bottom-[1.30rem] sm:right-24 sm:scale-100
            bottom-2 right-6 scale-75 transition-all duration-300">
    </div>


    {{-- BACK TO TOP --}}
    <button id="backToTop" title="Kembali ke atas" class="fixed w-9 h-9 bottom-[1.2rem] right-4 bg-gray-400 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-700 hover:scale-110 transition-all duration-300 z-50
           sm:w-12 sm:h-12 sm:bottom-6 sm:right-6">
        <i data-lucide="arrow-up" class="w-4 h-4 sm:w-6 sm:h-6"></i>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets/js/user/landing-page.js') }}"></script>
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
    <script>
        // --- Format IDR ---
        function formatIDR(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })
                .format(angka).replace('Rp', 'IDR');
        }

        // --- Hitung subtotal/total global ---
        function updateTotal() {
            const checkboxes = document.querySelectorAll('.select-item');
            let total = 0;
            const selected = [];

            checkboxes.forEach(cb => {
                const qty = parseInt(cb.dataset.jumlah) || 0;
                const harga = parseFloat(cb.dataset.harga) || 0;
                if (cb.checked) {
                    total += harga * qty;
                    selected.push(cb.dataset.keranjang);
                }
            });

            document.getElementById('subtotal').textContent = formatIDR(total);
            document.getElementById('total').textContent = formatIDR(total);
            document.getElementById('checkout-btn').disabled = selected.length === 0;
            document.getElementById('selected-items').value = JSON.stringify(selected);
        }

        // --- Cart popup real-time ---
        function refreshCartPopup() {
            fetch('/keranjang/cek', { headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" } })
                .then(res => res.json())
                .then(data => {
                    const container = document.getElementById('cartPopupContainer');
                    container.innerHTML = '';

                    if (data.items && data.items.length > 0) {
                        const totalProdukUnik = data.items.length;
                        showCartPopup(totalProdukUnik);
                        animateCartBadge(totalProdukUnik);
                    } else {
                        animateCartBadge(0);
                    }
                });
        }

        function showCartPopup(totalProduk) {
            const container = document.getElementById('cartPopupContainer');
            container.innerHTML = '';

            const popup = document.createElement('div');
            popup.className = "bg-gray-400/95 text-white rounded-2xl shadow-2xl flex items-center justify-between gap-3 px-5 py-4 w-80 cursor-pointer hover:bg-gray-500/95 transition-all duration-300 animate-slide-up animate-border-gray backdrop-blur-sm";
            popup.onclick = () => { window.location.href = "{{ route('keranjang.index') }}"; };

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
            btn.parentElement.remove();
        }

        function animateCartBadge(total) {
            const badge = document.getElementById('cartBadge');
            if (!badge) return;

            if (total > 0) {
                badge.textContent = total;
                badge.classList.remove('hidden');
                badge.classList.add('animate-bounce');
                setTimeout(() => badge.classList.remove('animate-bounce'), 300);
            } else {
                badge.classList.add('hidden');
            }
        }

        // --- Add to cart ---
        function addToCart(id) {
            const warna = document.querySelector(`#selectedColor-${id}`)?.value;
            const ukuran = document.querySelector(`#selectedSize-${id}`)?.value;
            const qty = parseInt(document.querySelector(`#qty-${id}`)?.value || 1);

            if (!warna || !ukuran) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Varian Dulu!',
                    text: 'Silakan pilih warna dan ukuran sebelum menambahkan ke keranjang.',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            fetch("{{ route('keranjang.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ produk_id: id, warna: warna, ukuran: ukuran, jumlah: qty })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: data.error, confirmButtonColor: '#ef4444' });
                    } else {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            position: 'top-end'
                        });
                        closeModal(`productModal-${id}`);
                        refreshCartPopup();
                    }
                });
        }

        // --- Update quantity ---
        function updateQuantity(id, change) {
            const qtyEl = document.getElementById(`qty-${id}`);
            let currentQty = parseInt(qtyEl.textContent) || 0;
            let newQty = currentQty + change;

            if (newQty < 1) {
                hapusKeranjang(id);
                return;
            }

            qtyEl.textContent = newQty;

            const checkbox = document.querySelector(`.select-item[data-keranjang='${id}']`);
            if (checkbox) {
                checkbox.dataset.jumlah = newQty;
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('change'));
            }

            fetch(`{{ url('keranjang') }}/${id}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ jumlah: newQty })
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message });
                        qtyEl.textContent = currentQty;
                        if (checkbox) {
                            checkbox.dataset.jumlah = currentQty;
                            checkbox.dispatchEvent(new Event('change'));
                        }
                    } else {
                        refreshCartPopup();
                    }
                });
        }

        // --- Hapus keranjang ---
        function hapusKeranjang(id) {
            Swal.fire({
                title: 'Hapus item ini?',
                text: "Produk akan dihapus dari keranjangmu.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`{{ url('keranjang') }}/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const itemEl = document.querySelector(`.item-keranjang[data-id='${id}']`);
                                if (itemEl) itemEl.remove();
                                updateTotal();
                                refreshCartPopup();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    toast: true,
                                    position: 'top-end'
                                });
                            }
                        });
                }
            });
        }

        // --- Init on load ---
        document.addEventListener('DOMContentLoaded', () => {
            refreshCartPopup();
            document.querySelectorAll('.select-item').forEach(cb => cb.addEventListener('change', updateTotal));
            const selectAll = document.getElementById('select-all');
            if (selectAll) selectAll.addEventListener('change', function () {
                document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
                updateTotal();
            });
        });
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

    @stack('script')
</body>

</html>