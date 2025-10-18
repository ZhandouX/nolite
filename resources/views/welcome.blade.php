<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nolite Aspiciens</title>
    <link rel="stylesheet" href="{{ asset('assets/css/user/style.css') }}" />
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/logonolite.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/register.css') }}">
</head>

<body>
    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite" class="logo-img" />
            <h2>Nolite Aspiciens</h2>
            <span class="close-btn" id="closeSidebar">&times;</span>
        </div>
        <ul class="sidebar-links">
            <li><a href="{{ route('customer.allProduk') }}">Produk</a></li>
            <!-- Dropdown Men -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Men</a>
                <ul class="dropdown-menu">
                    <li><a href="#men-tshirt">T-Shirt</a></li>
                    <li><a href="#men-shoes">Hoodie</a></li>
                    <li><a href="#men-jacket">Jersey</a></li>
                </ul>
            </li>
        </ul>
    </div>

    {{-- OVERLAY --}}
    <div id="overlay"></div>

    {{-- HEADER --}}
    <header>
        <div class="left-header">
            <span id="menuBtn">&#9776;</span>
        </div>
        <div class="logo">
            <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite" class="logo-img" />
            Nolite Aspiciens
        </div>
        <nav class="nav-icons flex items-center gap-5 relative">
            {{-- SEARCH --}}
            <button type="button" class="text-white-700 hover:text-gray-300 transition">
                <i data-lucide="search" class="w-6 h-6"></i>
            </button>

            {{-- CART --}}
            <a href="{{ route('keranjang.index') }}" class="text-white-700 hover:text-gray-300 transition relative">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>

                @php
                    if (Auth::check()) {
                        $jumlahKeranjang = \App\Models\Keranjang::where('user_id', Auth::id())->count();
                    } else {
                        $jumlahKeranjang = count(session('keranjang', []));
                    }
                @endphp

                <span id="cartBadge" class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5 
                    {{ $jumlahKeranjang > 0 ? '' : 'hidden' }}">
                    {{ $jumlahKeranjang }}
                </span>

            </a>

            {{-- USER MENU --}}
            <div class="relative">
                @auth
                    {{-- Jika SUDAH login --}}
                    @php $user = Auth::user(); @endphp

                    {{-- Tombol User (langsung ke Dashboard sesuai role) --}}
                    <a href="{{ $user->hasRole('admin') ? route('admin.dashboard') : route('customer.dashboard') }}"
                        class="text-white-700 hover:text-gray-300 transition flex items-center justify-center w-8 h-8 rounded-full hover:border-blue-500">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </a>

                @else
                    {{-- Jika BELUM login → Klik membuka modal login --}}
                    <button type="button" onclick="openLoginModal()"
                        class="text-white-700 hover:text-gray-300 transition flex items-center justify-center w-8 h-8 rounded-full hover:border-blue-500">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </button>
                @endauth
            </div>
        </nav>
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

    {{-- PRODUCT SECTION --}}
    <section class="product-section py-16 bg-gradient-to-b from-white to-gray-50" id="produk">
        <div class="container mx-auto px-4">
            <div class="section-header text-center mb-12">
                <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Katalog Produk</span>
                <h2 class="text-4xl font-bold mt-2 mb-4 text-gray-900">Produk Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Temukan produk pilihan terbaik dengan kualitas unggul dan desain elegan
                </p>
            </div>

            {{-- GRID PRODUCT --}}
            <div class="product-grid grid md:grid-cols-3 gap-8">
                @forelse($produk as $item)
                    <div class="group bg-white rounded-lg overflow-hidden border border-gray-300 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                        data-id="{{ $item->id }}" data-nama="{{ $item->nama_produk }}" data-harga="{{ $item->harga }}"
                        data-category="{{ $item->kategori ?? 'umum' }}">

                        {{-- PRODUCT IMAGE --}}
                        <a href="{{ route('produk.detail', $item->id) }}"
                            class="block overflow-hidden rounded-t-2xl bg-gray-50">
                            @if($item->fotos->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                            @else
                                <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                            @endif
                        </a>

                        <div class="p-6 flex flex-col gap-3">
                            <h3 class="text-xl font-bold text-gray-900 line-clamp-1">{{ $item->nama_produk }}</h3>

                            {{-- BUTTON GROUP --}}
                            <div class="flex gap-2 w-full mt-2">
                                {{-- CART BUTTON --}}
                                <button
                                    class="bg-gray-700 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0"
                                    onclick="openModal('productModal-{{ $item->id }}')" title="Tambah ke Keranjang">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>

                                {{-- BUY BUTTON (Selalu buka modal) --}}
                                <button
                                    class="bg-gray-700 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center gap-2"
                                    onclick="openModal('productBeliModal-{{ $item->id }}')">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg> -->
                                    <span> Beli</span>
                                </button>
                            </div>

                            <p class="text-lg text-black font-bold">
                                IDR {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- MODAL CART --}}
                    <div id="productModal-{{ $item->id }}" class="z-[9999] fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">

                            {{-- CLOSE --}}
                            <button type="button" onclick="closeModal('productModal-{{ $item->id }}')"
                                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

                            {{-- CARD PRODUK --}}
                            <div class="flex items-center gap-4 mb-5 mt-5 bg-gray-100 rounded-lg p-2">
                                @if($item->fotos->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                        class="w-20 h-20 object-contain rounded-xl">
                                @else
                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="No Image"
                                        class="w-20 h-20 object-contain rounded-lg">
                                @endif
                                <div>
                                    <p class="text-left text-lg font-bold text-black">{{ $item->nama_produk }}</p>
                                    <p class="text-left text-black font-bold">IDR {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- COLOR --}}
                            <div class="mb-4">
                                <p class="text-left font-semibold mb-2">Warna:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($item->warna as $w)
                                        <button type="button"
                                            class="color-btn px-3 py-1 rounded border border-gray-300 text-sm hover:border-blue-600 transition"
                                            data-color="{{ $w }}" data-item="{{ $item->id }}">
                                            {{ $w }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="warna" id="selectedColor-{{ $item->id }}">
                            </div>

                            {{-- SIZE --}}
                            <div class="mb-4">
                                <p class="text-left font-semibold mb-2">Ukuran:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($item->ukuran as $u)
                                        <button type="button"
                                            class="size-btn px-3 py-1 rounded border border-gray-300 text-sm hover:border-blue-600 transition"
                                            data-size="{{ $u }}" data-item="{{ $item->id }}">
                                            {{ $u }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="ukuran" id="selectedSize-{{ $item->id }}">
                            </div>

                            {{-- QTY --}}
                            <div class="flex flex-col items-center space-y-3 py-4 border-t border-gray-200">
                                <label class="text-sm font-semibold text-gray-800 text-left w-full">Jumlah</label>

                                <div class="flex items-center justify-center space-x-4">
                                    {{-- BUTTON ( - ) --}}
                                    <button type="button" onclick="decrementQty({{ $item->id }})"
                                        class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-500  bg-white hover:bg-gray-100 active:scale-95 transition-all duration-200 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg>
                                    </button>

                                    {{-- INPUT QTY --}}
                                    <input type="number" id="qty-{{ $item->id }}" min="1" max="{{ $item->jumlah }}"
                                        value="1" onchange="validateQty({{ $item->id }})"
                                        class="w-10 text-center text-lg font-bold text-gray-900 focus:outline-none border-none bg-transparent select-none"
                                        readonly>

                                    {{-- BUTTON ( + ) --}}
                                    <button type="button" onclick="incrementQty({{ $item->id }})" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-400 text-white hover:bg-gray-600 active:scale-95 transition-all duration-200 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- STOK PRODUK --}}
                                <p class="text-xs text-gray-500 text-center">
                                    Stok tersedia: {{ $item->jumlah }}
                                </p>
                            </div>

                            {{-- BUTTON SUBMIT --}}
                            <button type="button" onclick="addToCart('{{ $item->id }}')"
                                class="w-full mt-5 bg-gray-600 hover:bg-gray-400 text-white font-semibold py-2 rounded-lg transition">
                                Tambahkan ke Keranjang
                            </button>
                        </div>
                    </div>

                    {{-- BUY MODAL --}}
                    <div id="productBeliModal-{{ $item->id }}" class="z-[9999] fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">

                            {{-- CLOSE --}}
                            <button type="button" onclick="closeModal('productBeliModal-{{ $item->id }}')"
                                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

                            {{-- CARD PRODUK --}}
                            <div class="flex items-center gap-4 mb-5 mt-5 bg-gray-100 rounded-lg p-2">
                                @if($item->fotos->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                        class="w-20 h-20 object-contain rounded-lg bg-gray-100">
                                @else
                                    <img src="{{ asset('storage/default.png') }}" alt="No Image"
                                        class="w-20 h-20 object-contain rounded-lg bg-gray-100">
                                @endif
                                <div>
                                    <p class="text-left text-lg font-bold text-black">{{ $item->nama_produk }}</p>
                                    <hr class="w-full">
                                    <p class="text-left text-black font-bold">IDR {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- FORM PEMBELIAN --}}
                            <form action="{{ route('customer.checkout.dashboard') }}" method="GET" class="space-y-4">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $item->id }}">

                                {{-- PILIHAN WARNA --}}
                                <div class="mb-4 color-section">
                                    <div class="text-left">
                                        <p class="font-semibold mb-2">Warna:</p>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($item->warna as $w)
                                            <button type="button"
                                                class="color-btn px-3 py-1 rounded border border-gray-300 text-sm hover:border-blue-600 transition {{ $loop->first ? 'border-blue-600 bg-blue-50' : '' }}"
                                                data-color="{{ $w }}" data-item="{{ $item->id }}">
                                                {{ $w }}
                                            </button>
                                        @endforeach
                                    </div>

                                    <input type="hidden" name="warna" id="selectedColor-{{ $item->id }}"
                                        value="{{ $item->warna[0] ?? '' }}">
                                </div>

                                {{-- PILIHAN UKURAN --}}
                                <div class="mb-4 size-section">
                                    <div class="text-left">
                                        <p class="font-semibold mb-2">Ukuran:</p>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($item->ukuran as $u)
                                            <button type="button"
                                                class="size-btn px-3 py-1 rounded border border-gray-300 text-sm hover:border-blue-600 transition {{ $loop->first ? 'border-blue-600 bg-blue-50' : '' }}"
                                                data-size="{{ $u }}" data-item="{{ $item->id }}">
                                                {{ $u }}
                                            </button>
                                        @endforeach
                                    </div>

                                    <input type="hidden" name="ukuran" id="selectedSize-{{ $item->id }}"
                                        value="{{ $item->ukuran[0] ?? '' }}">
                                </div>

                                {{-- QTY PRODUK --}}
                                <div class="flex flex-col space-y-3 border-t border-gray-200 pt-4">
                                    <label class="text-sm font-semibold text-gray-800 text-left">Jumlah</label>

                                    <div class="flex items-center justify-center gap-6">
                                        {{-- BUTTON ( - ) --}}
                                        <button type="button" onclick="updateQty(this, -1)"
                                            class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 bg-white hover:bg-gray-100 active:scale-95 transition-all duration-200 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                                            </svg>
                                        </button>

                                        {{-- INPUT QTY --}}
                                        <input type="number" name="jumlah" id="buyQty-{{ $item->id }}" value="1" min="1"
                                            max="{{ $item->jumlah }}" onchange="validateQty(this)"
                                            class="w-10 text-center text-lg font-bold text-gray-900 focus:outline-none border-none bg-transparent select-none"
                                            readonly>

                                        {{-- BUTTON ( + ) --}}
                                        <button type="button" onclick="updateQty(this, 1)"
                                            class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-400 text-white hover:bg-gray-600 active:scale-95 transition-all duration-200 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 text-center sm:text-center">
                                        Stok tersedia: {{ $item->jumlah }}
                                    </p>
                                </div>

                                {{-- TOMBOL BELI / LOGIN --}}
                                @auth
                                    <button type="submit"
                                        class="w-full bg-gray-600 hover:bg-gray-500 text-white font-semibold py-2 rounded-lg transition">
                                        Beli Sekarang
                                    </button>
                                @else
                                    <button type="button" onclick="openLoginModal()"
                                        class="w-full bg-gray-600 hover:bg-gray-500 text-white font-semibold py-2 rounded-lg transition">
                                        Beli Sekarang
                                    </button>
                                @endauth
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16">
                        <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <div class="see-all">
        <a href="{{ route('customer.allProduk') }}">
            <button class="see-all-btn">SEE ALL PRODUCT</button>
        </a>
    </div>

    <div class="extra-icons">
        <div class="icon-box">
            <i data-lucide="info"></i>
            <span>About Us</span>
        </div>
        <div class="icon-box">
            <a href="{{ route('customer.allProduk') }}" class="icon-box">
                <i data-lucide="shopping-bag"></i>
                <span>All Products</span>
            </a>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="text-white font-sans px-6 py-10 md:py-14" style="background-color: #000;">
        <div
            class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center md:items-start gap-10 text-center md:text-left">
            {{-- LEFT FOOTER --}}
            <div class="flex-1 min-w-[220px] flex flex-col items-center md:items-start ml-0 md:-ml-10">
                <p class="italic text-sm leading-relaxed text-white max-w-[260px] text-center md:text-left">
                    “Created for souls who find comfort<br />
                    in darkness, reject the norms,<br />
                    and dare to stand out.”
                </p>
                <div class="flex gap-4 mt-4 justify-center md:justify-start">
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/wa.png') }}" alt="WhatsApp"
                            class="w-full h-full object-cover" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/ig.png') }}" alt="Instagram"
                            class="w-full h-full object-cover" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/tt.png') }}" alt="TikTok"
                            class="w-full h-full object-cover" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/shopee.png') }}" alt="Shopee"
                            class="w-full h-full object-cover" />
                    </a>
                </div>
            </div>

            {{-- CENTER FOOTER --}}
            <div class="text-center flex flex-col items-center md:relative md:-top-8">
                <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite"
                    class="w-16 md:w-24 mb-3" />
                <h2 class="text-lg md:text-3xl font-bold">Nolite Aspiciens</h2>
            </div>

            {{-- RIGHT FOOTER --}}
            <div class="flex-1 min-w-[250px] flex flex-col items-center text-center">

                {{-- HIDDEN BUTTON (MOBILE) --}}
                <button id="footerToggle"
                    class="w-full bg-black text-white font-semibold flex justify-between items-center py-3 px-4 text-[16px] cursor-pointer md:hidden"
                    onclick="toggleFooterPayment()">
                    Payment Method
                    <i class="fa-solid fa-chevron-down transition-transform duration-300" id="footerIcon"></i>
                </button>

                <div id="footerLogosMobile" class="grid grid-cols-5 gap-2 mt-2 px-4 md:hidden">
                    <img src="{{ asset('assets/images/icon/qris.png') }}" alt="QRIS"
                        class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/ovo.png') }}" alt="OVO"
                        class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/dana.png') }}" alt="DANA"
                        class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/gopay.png') }}"
                        class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/alfamart.png') }}"
                        class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/indomaret.png') }}"
                        class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/mandiri.png') }}"
                        class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/bri.png') }}" class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/bni.png') }}" class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/bsi.png') }}" class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/bca.png') }}" class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/visa.png') }}" class="footer-pay w-10 h-10 object-contain" />
                    <img src="{{ asset('assets/images/icon/mastercard.png') }}"
                        class="footer-pay w-10 h-10 object-contain" />
                </div>

                <div class="hidden md:flex md:flex-col w-full">
                    <h3 class="text-[16px] font-bold mb-3 ml-4">
                        Payment Method
                    </h3>

                    <div id="footerLogosDesktop" class="grid grid-cols-5 gap-5 justify-items-start items-center pl-20">
                        <img src="{{ asset('assets/images/icon/qris.png') }}" alt="QRIS" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/ovo.png') }}" alt="OVO" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/dana.png') }}" alt="DANA" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/gopay.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/alfamart.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/indomaret.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/mandiri.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/bri.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/bni.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/bsi.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/bca.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/visa.png') }}" class="footer-pay" />
                        <img src="{{ asset('assets/images/icon/mastercard.png') }}" class="footer-pay" />
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTTOM --}}
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Nolite Aspiciens. All Rights Reserved.</p>
        </div>
    </footer>

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

            <!-- Tombol Close -->
            <button type="button" onclick="closeRegisterModal()"
                class="absolute -top-4 -right-4 bg-white text-gray-700 hover:bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center shadow-lg text-xl z-[10000]">
                &times;
            </button>

            <!-- ===== Konten Register ===== -->
            <div class="form-container w-full max-w-md">
                <div class="form-header">
                    <h1 class="text-2xl font-bold mb-2">Register</h1>
                </div>

                <div class="form-content">
                    <form id="registerForm" method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
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

    {{-- JS: CART MODAL --}}
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeModal(id);
                    }
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
                    alert(data.message);
                    closeModal(`productModal-${id}`);
                    updateCartBadge();
                })
                .catch(err => console.error(err));
        }

        // 🔹 Fungsi untuk update badge jumlah keranjang


        // COLOR & SIZE SELECTED
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
    </script>

    {{-- JS: INCREMENT & DECREMENT QTY --}}
    <script>
        function incrementQty(itemId) {
            const input = document.getElementById(`qty-${itemId}`);
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;

            // Animasi feedback
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

                // Animasi feedback
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


    {{-- JS: BUY MODAL --}}
    <script>
        // Fungsi update jumlah produk
        function updateQty(button, change) {
            const input = button.parentElement.querySelector('input[type="number"]');
            let value = parseInt(input.value) + change;
            const min = parseInt(input.min);
            const max = parseInt(input.max);

            if (value < min) value = min;
            if (value > max) value = max;

            input.value = value;
        }

        // Fungsi redirect ke halaman login
        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";
        }

        // Fungsi pilih warna
        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const itemId = this.dataset.item;
                const color = this.dataset.color;
                const buttons = document.querySelectorAll(`[data-item="${itemId}"].color-btn`);

                buttons.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50'));
                this.classList.add('border-blue-600', 'bg-blue-50');

                document.getElementById(`selectedColor-${itemId}`).value = color;
            });
        });

        // Fungsi pilih ukuran
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const itemId = this.dataset.item;
                const size = this.dataset.size;
                const buttons = document.querySelectorAll(`[data-item="${itemId}"].size-btn`);

                buttons.forEach(b => b.classList.remove('border-blue-600', 'bg-blue-50'));
                this.classList.add('border-blue-600', 'bg-blue-50');

                document.getElementById(`selectedSize-${itemId}`).value = size;
            });
        });
    </script>

    {{-- JS: USER DROPDOWN --}}
    <script>
        lucide.createIcons();
        const userBtn = document.getElementById('userBtn');
        const userDropdown = document.getElementById('userDropdown');

        if (userBtn && userDropdown) {
            userBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!userDropdown.contains(e.target) && !userBtn.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    </script>

    {{-- SESSION LOGIN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(!empty($showLoginModal) && $showLoginModal)
                openLoginModal();
            @endif
    });
    </script>

    <script src="{{ asset('assets/js/user/landing-page.js') }}"></script>

</body>

</html>