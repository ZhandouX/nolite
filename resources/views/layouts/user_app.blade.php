<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/user/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/user/keranjang.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
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
            bottom-2 right-8 scale-75 transition-all duration-300">
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

    {{-- MODALS --}}
    @foreach($produkTerbaru as $item)
        @include('layouts.partials_user.modal-beli', ['item' => $item])
        @include('layouts.partials_user.modal-cart', ['item' => $item])
    @endforeach
    @include('layouts.partials_user.modals.login')
    @include('layouts.partials_user.modals.register')
    {{-- Tambahkan di bagian bawah layout utama --}}

    {{-- MODALS CONTAINER untuk produk dari search --}}
    <div id="dynamicModalsContainer"></div>

    <script>
        // Function untuk load modal secara dinamis
        async function loadProductModals(productId) {
            try {
                // Check jika modal sudah ada
                if (document.getElementById(`productModal-${productId}`)) {
                    return; // Modal sudah ada
                }

                // Fetch modal HTML dari server
                const response = await fetch(`/get-product-modals/${productId}`);
                const html = await response.text();

                // Inject ke container
                document.getElementById('dynamicModalsContainer').innerHTML += html;

                // Re-initialize Lucide icons jika ada
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
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

    {{-- ====================================== --}}
    {{-- ============= JAVASCRIPT ============= --}}
    {{-- ====================================== --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets/js/user/landing-page.js') }}"></script>
    <script src="{{ asset('assets/js/user/auth-modal.js') }}"></script>
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

    {{-- SIDEBAR HIDDEN --}}
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