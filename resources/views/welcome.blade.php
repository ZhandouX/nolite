<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="/assets/css/user/style.css" />
    <link rel="stylesheet" href="/assets/css/user/keranjang.css">
    <link rel="stylesheet" href="/assets/css/auth/login.css">
    <link rel="stylesheet" href="/assets/css/auth/register.css">
    <link rel="stylesheet" href="/assets/css/user/kategori.css">
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

    {{-- FOOTER KONDISIONAL --}}
    @php
        $routeName = Route::currentRouteName();
        $footerFullRoutes = [
            'landing',
            'customer.dashboard',
            'customer.all-produk',
            'customer.kategori-hoodie',
            'customer.kategori-tshirt',
            'customer.kategori-jersey',
            'customer.unggulan',
            'customer.diskon'
        ];
    @endphp

    @if (in_array($routeName, $footerFullRoutes))
        {{-- FOOTER LENGKAP --}}
        @include('layouts.partials_user.footer')
    @else
        {{-- FOOTER SIMPEL --}}
        @include('layouts.partials_user.simple-footer')
    @endif

    <!-- BUTTON GROUP -->
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
            transition-all duration-500 ease-out max-w-[250px] w-max max-h-[50px] h-max whitespace-normal break-words leading-snug overflow-hidden">
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

    {{-- ====================================== --}}
    {{-- ============= JAVASCRIPT ============= --}}
    {{-- ====================================== --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        if (window.lucide) lucide.createIcons();

        document.addEventListener("DOMContentLoaded", () => {
            const tooltip = document.getElementById("chat-tooltip");
            const arrow = document.getElementById("chat-arrow");
            const fullText = "Halo! Saya asisten AI Nolite Aspiciens. Ada yang ingin kamu tanyakan?";
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
    <script>
        // === Sidebar Toggle (Tailwind Version) ===
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const menuBtn = document.getElementById("menuBtn");
        const closeSidebar = document.getElementById("closeSidebar");
        const backToTopButton = document.getElementById("backToTop");

        if (menuBtn && sidebar && overlay) {
            menuBtn.addEventListener("click", () => {
                // Sidebar muncul
                sidebar.classList.remove("-translate-x-full");
                sidebar.classList.add("translate-x-0");

                // Overlay aktif
                overlay.classList.remove("opacity-0", "pointer-events-none");
                overlay.classList.add("opacity-100", "pointer-events-auto");
            });

            closeSidebar.addEventListener("click", () => {
                // Sidebar sembunyi
                sidebar.classList.remove("translate-x-0");
                sidebar.classList.add("-translate-x-full");

                // Overlay nonaktif
                overlay.classList.remove("opacity-100", "pointer-events-auto");
                overlay.classList.add("opacity-0", "pointer-events-none");
            });

            overlay.addEventListener("click", () => {
                sidebar.classList.remove("translate-x-0");
                sidebar.classList.add("-translate-x-full");
                overlay.classList.remove("opacity-100", "pointer-events-auto");
                overlay.classList.add("opacity-0", "pointer-events-none");
            });
        }

        // === Dropdown Sidebar ===
        document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
            toggle.addEventListener("click", function (e) {
                e.preventDefault();
                this.parentElement.classList.toggle("open");
            });
        });

        // === Simple Search Filter ===
        const searchInput = document.querySelector(".search-bar input");

        if (searchInput) {
            searchInput.addEventListener("input", function () {
                const value = this.value.toLowerCase();
                allProducts.forEach((prod) => {
                    const text = prod.innerText.toLowerCase();
                    prod.style.display = text.includes(value) ? "block" : "none";
                });
            });
        }

        // === Inisialisasi Lucide Icon ===
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }

        // === Hero Slider ===
        let slides = document.querySelectorAll(".slide");
        let currentSlide = 0;

        function changeSlide() {
            slides[currentSlide].classList.remove("active");
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add("active");
        }

        // IMAGES SLIDER
        setInterval(changeSlide, 4000);

        function openDetail(productName) {
            alert("Buka detail produk: " + productName);
        }

        // === Footer Payment Toggle ===
        function toggleFooterPayment() {
            const logosMobile = document.getElementById("footerLogosMobile");
            const icon = document.getElementById("footerIcon");

            logosMobile.classList.toggle("hidden");
            icon.classList.toggle("rotate-180");
        }

        // === Back To Top Button ===
        window.addEventListener("scroll", () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove("hidden");
                backToTopButton.classList.add("flex");
            } else {
                backToTopButton.classList.add("hidden");
                backToTopButton.classList.remove("flex");
            }
        });

        backToTopButton.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });

        // === Re-initialize Lucide (safe call) ===
        if (typeof lucide !== "undefined") {
            lucide.createIcons();
        }
    </script>
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
    <script src="/assets/js/user/keranjang-popup.js"></script>

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
    {{-- JS: KATEGORI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allProducts = @json($produk);
            window.showCategory = function (jenis) {
                const kategoriPanel = document.getElementById('panel-kategori');
                const filteredPanel = document.getElementById('filtered-category');
                const grid = document.getElementById('filtered-products');
                const bannerTitle = document.getElementById('category-banner-title');
                const bannerImg = document.getElementById('category-banner-img');
                kategoriPanel.classList.add('hidden');
                filteredPanel.classList.remove('hidden');
                bannerTitle.textContent = jenis;
                const bannerMap = {
                    'T-Shirt': '/assets/images/banner/tshirt.jpeg',
                    'Hoodie': '/assets/images/banner/hoodie-1.jpg',
                    'Jersey': '/assets/images/banner/jersey.jpg',
                };
                bannerImg.src = bannerMap[jenis] || '/assets/images/default-banner.jpg';
                const filtered = allProducts.filter(p => p.jenis === jenis);
                grid.innerHTML = '';

                if (filtered.length === 0) {
                    grid.innerHTML = `<p class='col-span-3 text-center text-gray-500 text-lg py-12'>Belum ada produk untuk kategori ${jenis}</p>`;
                    return;
                }

                filtered.forEach(item => {
                    const foto = item.fotos?.length ? `/storage/${item.fotos[0].foto}` : `/assets/images/no-image.png`;

                    const card = `
                                                                            <div class="group bg-white rounded-2xl overflow-hidden border border-gray-300 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                                                                                data-id="${item.id}" data-nama="${item.nama_produk}" data-harga="${item.harga}"
                                                                                data-foto="${foto}" data-category="${item.kategori ?? 'umum'}">

                                                                                <a href="/produk/detail/${item.id}" class="block overflow-hidden rounded-t-2xl bg-gray-50">
                                                                                    <img src="${foto}" alt="${item.nama_produk}" class="w-full h-72 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                                                                                </a>

                                                                                <div class="p-6 flex flex-col gap-3">
                                                                                    <h3 class="text-center text-xl font-bold text-gray-900 line-clamp-1">${item.nama_produk}</h3>
                                                                                    <p class="text-center text-lg text-black font-bold">
                                                                                        IDR ${new Intl.NumberFormat('id-ID').format(item.harga)}
                                                                                    </p>

                                                                                    <div class="flex gap-2 w-full mt-2">
                                                                                        <!-- CART -->
                                                                                        <button
                                                                                            class="bg-gray-600 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0"
                                                                                            onclick="openModal('productModal-${item.id}')" title="Tambah ke Keranjang">
                                                                                            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                                                                                                <path stroke-linecap='round' stroke-linejoin='round'
                                                                                                    d='M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'/>
                                                                                            </svg>
                                                                                        </button>

                                                                                        <!-- BUY -->
                                                                                        <button
                                                                                            class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center gap-2"
                                                                                            onclick="openModal('productBeliModal-${item.id}')">
                                                                                            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                                                                                                <path stroke-linecap='round' stroke-linejoin='round' d='M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'/>
                                                                                            </svg>
                                                                                            <span>Beli Sekarang</span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>`;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            };

            window.backToCategories = function () {
                document.getElementById('filtered-category').classList.add('hidden');
                document.getElementById('panel-kategori').classList.remove('hidden');
            };
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