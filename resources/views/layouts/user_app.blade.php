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

    {{-- MODALS --}}
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
    <!-- <script src="{{ asset('assets/js/user/kategori.js') }}"></script> -->
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