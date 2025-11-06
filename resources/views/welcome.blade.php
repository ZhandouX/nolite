<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/user/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/user/keranjang.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user/kategori.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @stack('style')
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.partials_user.sidebar')

    {{-- OVERLAY --}}
    <div id="overlay"></div>

    {{-- HEADER --}}
    <header>
        @include('layouts.partials_user.navbar')
    </header>

    {{-- HERO SLIDER --}}
    <section class="hero" id="hero">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('assets/images/hero/1.jpeg')"></div>
            <div class="slide" style="background-image: url('assets/images/hero/2.jpeg')"></div>
            <div class="slide" style="background-image: url('assets/images/hero/3.jpeg')"></div>
        </div>
    </section>

    {{-- MAIN PANEL / TABS --}}
    <div class="tabs">
        <button class="tab" data-category="kategori">Kategori</button>
        <button class="tab active" data-category="all">Semua Produk</button>
        <button class="tab" data-category="diskon">Diskon</button>
    </div>

    {{-- PANEL: CATEGORY --}}
    @include('layouts.partials_user.panels.kategori')

    {{-- PANEL: PRODUCT: FILTERED --}}
    <div id="filtered-category" class="hidden">
        <div id="category-banner" class="relative h-96 bg-cover bg-center rounded-3xl shadow-lg mb-12"></div>
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800" id="category-title"></h2>
        <div id="filtered-products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
    </div>

    {{-- PANEL: DISKON --}}
    @include('layouts.partials_user.panels.diskon')

    {{-- PANEL: ALL PRODUK --}}
    @include('layouts.partials_user.panels.all-produk')

    <div class="see-all">
        <a href="{{ route('customer.allProduk') }}">
            <button class="see-all-btn">Lihat Semua Produk</button>
        </a>
    </div>

    <div class="extra-icons">
        <div class="icon-box">
            <i data-lucide="info"></i>
            <span>Tentang Kami</span>
        </div>
        <div class="icon-box">
            <a href="{{ route('customer.allProduk') }}" class="icon-box">
                <i data-lucide="shopping-bag"></i>
                <span>Semua Produk</span>
            </a>
        </div>
    </div>

    {{-- FOOTER --}}
    @include('layouts.partials_user.footer')

    {{-- KERANJANG POPUP --}}
    <div id="cartPopupContainer" class="fixed z-50 flex flex-col gap-1
            sm:bottom-[1.30rem] sm:right-24 sm:scale-100
            bottom-2 right-6 scale-75 transition-all duration-300">
    </div>

    <!-- Wrapper tombol fixed -->
    <div class="fixed bottom-4 right-4 md:bottom-6 md:right-6 flex flex-col items-end gap-4 z-50">
        <!-- Tombol tambahan (Chatbot) -->
        @include('layouts.partials_user.modals.chatbot')

        <!-- Tombol Back To Top -->
        <button id="backToTop" title="Kembali ke atas" class="w-12 h-12 bg-gray-400 text-white rounded-full flex items-center justify-center shadow-lg 
               hover:bg-gray-700 hover:scale-110 transition-all duration-500 
               opacity-0 translate-y-6 rotate-45 pointer-events-none">
            <i class="fa-solid fa-arrow-up text-lg"></i>
        </button>

        <!-- Garis divider -->
        <div id="toggleDivider"
            class="w-full h-[2px] bg-gray-300 rounded opacity-0 scale-x-0 transform transition-all duration-300 origin-right">
        </div>

        <!-- Tombol toggle utama -->
        <button id="toggleButtons" title="Menu" class="w-12 h-12 bg-gray-400 text-white rounded-full flex items-center justify-center shadow-lg 
               hover:bg-gray-700 hover:scale-110 transition-all duration-300">
            <i id="toggleIcon" class="fa-solid fa-chevron-up text-lg transition-transform duration-300"></i>
        </button>
    </div>

    {{-- MODAL --}}
    @foreach($produkTerbaru as $item)
        @include('layouts.partials_user.modal-beli', ['item' => $item])
        @include('layouts.partials_user.modal-cart', ['item' => $item])
    @endforeach
    @include('layouts.partials_user.modals.login')
    @include('layouts.partials_user.modals.register')

    {{-- ====================================== --}}
    {{-- ============= JAVASCRIPT ============= --}}
    {{-- ====================================== --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets/js/user/landing-page.js') }}"></script>
    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            routes: {
                keranjangIndex: "{{ route('keranjang.index') }}",
                keranjangStore: "{{ route('keranjang.store') }}",
                keranjangBase: "{{ url('keranjang') }}",
                keranjangCek: "{{ url('/keranjang/cek') }}",
                wishlistToggle: "{{ url('/wishlist/toggle') }}",
                allCategory: "{{ url('produk') }}"
            }
        };
    </script>
    <script src="{{ asset('assets/js/user/keranjang-popup.js') }}"></script>

    {{-- HIDDEN BUTTON --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggleButtons');
            const toggleIcon = document.getElementById('toggleIcon');
            const chatBtn = document.getElementById('chat-toggle');
            const backBtn = document.getElementById('backToTop');
            const divider = document.getElementById('toggleDivider');

            let isOpen = false;

            toggleBtn.addEventListener('click', () => {
                isOpen = !isOpen;

                if (isOpen) {
                    // Munculkan tombol tambahan dengan animasi
                    [chatBtn, backBtn].forEach((btn, i) => {
                        setTimeout(() => {
                            btn.classList.remove('opacity-0', 'translate-y-6', 'rotate-45', 'pointer-events-none');
                            btn.classList.add('opacity-100', 'translate-y-0', 'rotate-0', 'pointer-events-auto');
                        }, i * 100);
                    });

                    // Munculkan garis divider
                    divider.classList.remove('opacity-0', 'scale-x-0');
                    divider.classList.add('opacity-100', 'scale-x-100');

                    // Flip icon toggle
                    toggleIcon.style.transform = 'rotate(180deg)';
                } else {
                    // Sembunyikan tombol tambahan dengan stagger
                    [backBtn, chatBtn].forEach((btn, i) => {
                        setTimeout(() => {
                            btn.classList.add('opacity-0', 'translate-y-6', 'rotate-45', 'pointer-events-none');
                            btn.classList.remove('opacity-100', 'translate-y-0', 'rotate-0', 'pointer-events-auto');
                        }, i * 100);
                    });

                    // Sembunyikan garis divider
                    divider.classList.add('opacity-0', 'scale-x-0');
                    divider.classList.remove('opacity-100', 'scale-x-100');

                    // Flip kembali icon toggle
                    toggleIcon.style.transform = 'rotate(0deg)';
                }
            });

            // Tombol back to top
            backBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>

    {{-- JS: LOGIN & REGISTER MODAL --}}
    <script>
        //Login Modal
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

        // Register Modal
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

        // Switch modal
        function switchToRegisterModal() {
            closeLoginModal();
            setTimeout(() => openRegisterModal(), 200);
        }
        function switchToLoginModal() {
            closeRegisterModal();
            setTimeout(() => openLoginModal(), 200);
        }

        // Password Toggle (Login)
        const loginToggle = document.getElementById('loginPasswordToggle');
        const loginInput = document.getElementById('loginPassword');
        const loginIcon = loginToggle.querySelector('i');
        loginToggle.addEventListener('click', () => {
            const isHidden = loginInput.type === 'password';
            loginInput.type = isHidden ? 'text' : 'password';
            loginIcon.classList.toggle('fa-eye');
            loginIcon.classList.toggle('fa-eye-slash');
        });

        // Password Toggle (Register)
        const regToggle = document.getElementById('registerPasswordToggle');
        const regInput = document.getElementById('registerPassword');
        const regIcon = regToggle.querySelector('i');
        regToggle.addEventListener('click', () => {
            const isHidden = regInput.type === 'password';
            regInput.type = isHidden ? 'text' : 'password';
            regIcon.classList.toggle('fa-eye');
            regIcon.classList.toggle('fa-eye-slash');
        });

        // Password Strength Indicator
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

        // Loading Button
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

    {{-- SESSION LOGIN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(!empty($showLoginModal) && $showLoginModal)
                openLoginModal();
            @endif
    });
    </script>

    @stack('script')

</body>

</html>