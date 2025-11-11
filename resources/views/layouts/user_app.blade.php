<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="/assets/css/user/style.css" />
    <link rel="stylesheet" href="/assets/css/user/keranjang.css" />
    <link rel="stylesheet" href="/assets/css/auth/login.css">
    <link rel="stylesheet" href="/assets/css/auth/register.css">
    <link rel="stylesheet" href="/assets/css/user/kategori.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;800&display=swap" rel="stylesheet">

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

    {{-- FOOTER KONDISIONAL --}}
    @php
        $routeName = Route::currentRouteName();
        $footerFullRoutes = [
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

    {{-- MODALS --}}
    @foreach($produkTerbaru as $item)
        @include('layouts.partials_user.modal-beli', ['item' => $item])
        @include('layouts.partials_user.modal-cart', ['item' => $item])
    @endforeach
    @include('layouts.partials_user.modals.login')
    @include('layouts.partials_user.modals.register')
    {{-- Tambahkan di bagian bawah layout utama --}}


    {{-- ====================================== --}}
    {{-- ============= JAVASCRIPT ============= --}}
    {{-- ====================================== --}}

    {{-- MODALS CONTAINER untuk produk dari search --}}
    <div id="dynamicModalsContainer"></div>



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
    <script>
        // ==========================
        // Load modal produk secara dinamis
        // ==========================
        async function loadProductModals(productId) {
            // Cek jika modal sudah ada
            if (document.getElementById(`productModal-${productId}`)) return;

            try {
                const response = await fetch(`/get-product-modals/${productId}`);
                const html = await response.text();
                document.getElementById('dynamicModalsContainer').innerHTML += html;

                // Refresh ikon Lucide jika ada
                if (typeof lucide !== 'undefined') lucide.createIcons();
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
    <script src="/assets/js/user/auth-modal.js"></script>
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
    {{-- SESSION LOGIN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(!empty($showLoginModal) && $showLoginModal)
                openLoginModal();
            @endif
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