<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/assets/css/user/style.css" />
    <link rel="stylesheet" href="/assets/css/user/keranjang.css">
    <link rel="stylesheet" href="/assets/css/auth/login.css">
    <link rel="stylesheet" href="/assets/css/auth/register.css">
    <link rel="stylesheet" href="/assets/css/user/kategori.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @stack('style')
</head>

<body>
    {{-- SIDEBAR --}}
    @include('layouts.partials_user._sidebar')

    {{-- OVERLAY --}}
    <div id="overlay"></div>

    {{-- HEADER --}}
    <header>
        @include('layouts.partials_user._navbar')
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

    {{-- PANEL ==> KATEGORI --}}
    @include('layouts.partials_user.panels.kategori')

    {{-- PANEL ==> PRODUK DISKON --}}
    @include('layouts.partials_user.panels.diskon')

    {{-- PANEL ==> SEMUA PRODUK --}}
    @include('layouts.partials_user.panels.all-produk')

    <div class="see-all">
        <a href="{{ route('customer.allProduk') }}">
            <button class="see-all-btn">Lihat Semua Produk</button>
        </a>
    </div>

    {{-- BUTTON BOXS ==> LIHAT SEMUA PRODUK | TENTANG KAMI | SEMUA PRODUK --}}
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
    @include('layouts.partials_user._footer')

    {{-- BUTTON GROUP ==> BACK TO TOP | CHATBOT | CART POPUP --}}
    <div class="fixed bottom-20 right-4 lg:bottom-2 md:right-6 flex flex-col items-end gap-4 z-50">

        <!-- BACK TO TOP BUTTON -->
        <button id="backToTop" title="Kembali ke atas" class="group w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-400 text-white rounded-2xl flex items-center justify-center shadow-xl 
        hover:shadow-2xl hover:scale-105 transition-all duration-300 ease-out transform hover:-translate-y-1
        border border-gray-600/30 backdrop-blur-sm">
            <i class="fa-solid fa-chevron-up text-lg group-hover:animate-bounce"></i>
        </button>

        <!-- WRAPPER CHATBOT -->
        <div class="relative flex items-center gap-3">

            <!-- WRAPPER TOOLTIP -->
            <div class="absolute inline-block right-16 pointer-events-none">
                <!-- TEKS ANIMASI -->
                <div id="chat-tooltip"
                    class="relative bg-gray-800 text-white text-[12px] px-3 py-2 rounded-xl shadow-lg opacity-0 translate-x-4
            transition-all duration-500 ease-out max-w-[250px] w-max max-h-[120px] h-max whitespace-normal break-words leading-snug overflow-hidden">
                    <span class="typing-text"></span>
                </div>

                <!-- Segitiga kecil -->
                <div id="chat-arrow" class="absolute top-1/2 -right-2 transform -translate-y-1/2 w-0 h-0 
            border-t-8 border-t-transparent border-l-8 border-l-gray-800 border-b-8 border-b-transparent
            opacity-0 translate-x-4 transition-all duration-500 ease-out">
                </div>
            </div>

            <!-- CHATBOT BUTTON -->
            <button id="chat-toggle" title="Chat AI Nolite" class="group w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-2xl flex items-center justify-center shadow-xl
        hover:shadow-2xl hover:scale-105 transition-all duration-300 ease-out transform hover:-translate-y-1
        border border-gray-400/40 backdrop-blur-sm relative">

                <!-- Ikon AI -->
                <i data-lucide="sparkles"
                    class="w-6 h-6 text-white group-hover:rotate-12 group-hover:scale-110 transition-transform duration-300"></i>

                <!-- Titik notifikasi -->
                <span
                    class="absolute -top-1 -right-1 w-3 h-3 bg-blue-400 rounded-full border-2 border-white animate-pulse"></span>
            </button>
        </div>

        {{-- CHATBOT MODAL (MOBILE) --}}
        @include('layouts.partials_user.modals.chatbot')

        {{-- KERANJANG POPUP (MOBILE) --}}
        <div id="cartPopupMobile" class="group flex items-center justify-center shadow-xl 
        hover:shadow-2xl hover:scale-105 transition-all duration-300 ease-out transform hover:-translate-y-1 relative">
        </div>

        {{-- KERANJANG POPUP (DESKTOP) --}}
        <div id="cartPopupDesktop" class="group hidden lg:flex z-50 flex-col gap-1
            sm:scale-100 scale-75 transition-all duration-300">
        </div>
    </div>

    {{-- MODAL --}}
    @foreach($produkTerbaru as $item)
        @include('layouts.partials_user.modal-beli', ['item' => $item])
        @include('layouts.partials_user.modal-cart', ['item' => $item])
    @endforeach
    @include('layouts.partials_user.modals.login')
    @include('layouts.partials_user.modals.register')

    {{-- ============================================= --}}
    {{-- ============= LIBARY JAVASCRIPT ============= --}}
    {{-- ============================================= --}}

    {{-- ===== JS ====> MODALS CONTAINER untuk produk dari search --}}
    <div id="dynamicModalsContainer"></div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tooltip = document.getElementById("chat-tooltip");
            const arrow = document.getElementById("chat-arrow");
            const fullText = "Halo @auth{{ explode(' ', auth()->user()->name)[0] ?? 'Pelanggan Nolite' }}@else Nolite Aspiciens @endauth! Selamat datang di Nolite Aspiciens. Ada produk yang ingin kamu lihat atau tanyakan?";
            let index = 0;

            // Delay awal sebelum tooltip muncul
            setTimeout(() => {
                // Tampilkan tooltip dan arrow
                tooltip.classList.remove("opacity-0", "translate-x-4");
                arrow.classList.remove("opacity-0", "translate-x-4");

                // Mulai animasi typing
                const typing = setInterval(() => {
                    if (index < fullText.length) {
                        tooltip.querySelector(".typing-text").textContent += fullText.charAt(index);
                        index++;
                    } else {
                        clearInterval(typing);

                        // Setelah selesai mengetik, tunggu 6 detik lalu sembunyikan
                        setTimeout(() => {
                            tooltip.classList.add("opacity-0", "translate-x-4");
                            arrow.classList.add("opacity-0", "translate-x-4");
                        }, 6000);
                    }
                }, 50); // Kecepatan mengetik (50ms per huruf)
            }, 800); // Delay 800ms sebelum mulai
        });
    </script>

    {{-- ===== JS ====> MODAL FUNCTION --}}
    <script>
        // Fungsi modal dasar (fallback)
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }
    </script>

    {{-- ===== JS ====> LOAD GLOBAL MODAL (BELI & KERANJANG) --}}
    <script>
        async function loadProductModals(productId) {
            // Cek jika modal sudah ada
            if (document.getElementById(`productModal-${productId}`)) return;

            try {
                const response = await fetch(`/get-product-modals/${productId}`);
                const html = await response.text();
                document.getElementById('dynamicModalsContainer').innerHTML += html;

                // Render ulang icon Lucide (bundler)
                if (window.createIcons) window.createIcons();

            } catch (error) {
                console.error('Error loading modals:', error);
            }
        }

        // Override openModal function untuk handle dynamic loading
        const originalOpenModal = window.openModal;
        window.openModal = async function (modalId) {
            const productId = modalId.match(/\d+/)[0];

            // Load modal jika belum ada
            await loadProductModals(productId);

            // Tunggu sebentar untuk memastikan modal sudah di-inject
            setTimeout(() => {
                if (originalOpenModal) {
                    originalOpenModal(modalId);
                } else {
                    // Fallback jika function asli tidak ada
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.addEventListener('click', function (e) {
                            if (e.target === modal) closeModal(modalId);
                        });
                    }
                }
            }, 100);
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/user/landing-page.js"></script>

    {{-- ===== JS ====> CART POPUP --}}
    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            isLoggedIn: @json(auth()->check()),
            routes: {
                keranjangIndex: "{{ route('keranjang.index') }}",
                keranjangStore: "{{ route('keranjang.store') }}",
                keranjangBase: "{{ url('keranjang') }}",
                keranjangCek: "{{ url('/keranjang/cek') }}",
                keranjangSessionUpdate: "{{ route('keranjang.session.update') }}",
                wishlistToggle: "{{ url('/wishlist/toggle') }}",
                allCategory: "{{ url('produk') }}"
            }
        };
    </script>

    <script src="/assets/js/user/keranjang-popup.js"></script>

    {{-- ===== JS ====> HIDDEN BRAND NAV --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuBtn = document.getElementById("menuBtn");
            const closeSidebar = document.getElementById("closeSidebar");
            const sidebar = document.getElementById("sidebar");
            const headerLogo = document.getElementById("headerLogo");

            // Saat tombol menu diklik → buka sidebar dan sembunyikan logo
            if (menuBtn) {
                menuBtn.addEventListener("click", function () {
                    sidebar.classList.remove("-translate-x-full");
                    sidebar.classList.add("translate-x-0");

                    // Sembunyikan logo
                    headerLogo.classList.add("opacity-0", "pointer-events-none");
                });
            }

            // Saat tombol closeSidebar diklik → tutup sidebar dan tampilkan logo
            if (closeSidebar) {
                closeSidebar.addEventListener("click", function () {
                    sidebar.classList.add("-translate-x-full");
                    sidebar.classList.remove("translate-x-0");

                    // Tampilkan lagi logo
                    headerLogo.classList.remove("opacity-0", "pointer-events-none");
                });
            }
        });
    </script>

    {{-- ===== JS ====> TABS / MAIN PANELS --}}
    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(panel => {
                    panel.classList.add('hidden');
                    panel.classList.remove('block');
                });

                const filteredCategory = document.getElementById('filtered-category');
                if (filteredCategory) filteredCategory.classList.add('hidden');
                const target = tab.dataset.category;
                const targetPanel = document.getElementById(`panel-${target}`);
                if (targetPanel) {
                    targetPanel.classList.remove('hidden');
                    targetPanel.classList.add('block');
                }
            });
        });
    </script>

    {{-- ===== JS ====> LOGIN & REGISTER MODAL --}}
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

    {{-- ===== JS ====> SESSION LOGIN --}}
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