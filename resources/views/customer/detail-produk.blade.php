@extends('layouts.user_app')

@section('title', 'Detail Produk')

@push('style')
    <link rel="stylesheet" href="/assets/css/user/detail-produk.css">
@endpush

@section('content')
    <main class="mx-auto px-0 py-4 lg:px-4">
        {{-- BREADCRUMB --}}
        <div class="text-sm text-gray-500 mb-4">
            <a href="{{ route('customer.dashboard') }}" class="hover:text-gray-700 transition-colors">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('customer.kategori-produk', $produk->kategori->id) }}"
                class="hover:text-gray-700 transition-colors">
                {{ $produk->kategori->nama_kategori }}
            </a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $produk->nama_produk }}</span>
        </div>

        {{-- PRODUCT SECTION: GALLERY + INFO --}}
        <div class="grid lg:grid-cols-2 gap-6 mb-4">
            {{-- PRODUCT GALLERY --}}
            <div class="top-[100px]">
                {{-- MAIN IMAGE --}}
                <div class="fade-in mt-1">
                    <div class="main-image overflow-hidden bg-black">
                        @if($produk->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}" id="mainImage"
                                alt="{{ $produk->nama_produk }}"
                                class="w-full h-80 object-contain cursor-zoom-in transition-transform duration-300 hover:scale-105"
                                onclick="openProductModal(0)" />

                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="No Image" id="mainImage"
                                class="w-full h-80 object-contain" />
                        @endif
                    </div>
                </div>

                {{-- THUMBNAILS --}}
                <div class="bg-white lg:rounded-b-lg p-4 fade-in">
                    <div class="thumbnail-list flex gap-3 overflow-x-auto">
                        @foreach($produk->fotos as $key => $foto)
                            <img src="{{ asset('storage/' . $foto->foto) }}"
                                class="thumb w-16 h-16 object-cover rounded cursor-pointer border-2 transition-all duration-200 {{ $key === 0 ? 'border-gray-700' : 'border-gray-200 hover:border-gray-400' }}"
                                data-index="{{ $key }}" onclick="changeMainImage('{{ asset('storage/' . $foto->foto) }}', this, {{ $key }})" />
                        @endforeach
                    </div>
                </div>
                {{-- PRODUCT DESCRIPTION --}}
                <div class="hidden lg:flex flex-col bg-white lg:rounded-lg p-4 fade-in mt-4">
                    <div class="border-b border-gray-300 pb-2">
                        <h3 class="text-center lg:text-left text-lg font-semibold text-gray-900">Deskripsi Produk</h3>
                    </div>
                    <div class="text-gray-700 text-sm leading-relaxed space-y-3">
                        @if($produk->deskripsi)
                            <div class="relative">
                                <div id="descriptionContent"
                                    class="whitespace-pre-line prose prose-sm max-w-none text-gray-700 overflow-hidden transition-all duration-300 max-h-32">
                                    {!! nl2br(e($produk->deskripsi)) !!}
                                </div>
                                <div id="descriptionOverlay"
                                    class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white to-transparent flex items-end justify-center pb-2">
                                    <button id="readMoreBtn"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm transition-colors duration-200">
                                        Lihat Selengkapnya
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm">Belum ada deskripsi produk</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- PRODUCT INFORMATION --}}
            <div class="space-y-2 lg:space-y-6">
                {{-- HEADER & STATUS --}}
                <div class="bg-white lg:rounded-lg px-2 py-3">
                    <div class="space-y-3 px-2 fade-in">
                        <h1 class="montserrat text-2xl font-bold text-gray-900 leading-tight">{{ $produk->nama_produk }}</h1>

                        <div class="flex items-center space-x-4">
                            @php
                                $ulasan = $produk->ulasan;
                                $totalUlasan = $ulasan->count();
                                $avgRating = $totalUlasan ? round($ulasan->avg('rating'), 1) : 0;
                            @endphp

                            <span class="flex items-center text-sm">
                                @for($s = 1; $s <= 5; $s++)
                                    @if($s <= floor($avgRating))
                                        <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 mr-1 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-1 text-gray-700 font-medium">{{ $avgRating }}</span>
                            </span>
                            <span class="text-gray-400">|</span>
                            <span class="text-gray-600 text-sm">{{ $totalUlasan }} ulasan</span>
                            <span class="text-gray-400">|</span>
                            <span class="text-gray-600 text-sm">{{ $terjual ?? 0 }} terjual</span>
                        </div>

                        <div class="{{ $produk->jumlah > 0 ? 'stock-badge' : 'out-of-stock-badge' }} inline-flex">
                            {{ $produk->jumlah > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                        </div>
                    </div>

                    {{-- PRICING --}}
                    <div class="pt-2 px-2 fade-in">
                        <div class="flex items-center gap-2">
                            @if ($produk->has_diskon)
                                <div class="flex items-baseline flex-wrap gap-0">
                                    <span class="text-sm font-medium text-gray-500">
                                        Rp
                                    </span>
                                    <span class="text-2xl font-bold text-red-900">
                                        {{ $produk->harga_diskon }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 line-through flex-shrink-0">
                                    Rp{{ $produk->harga_format }}
                                </p>
                                <span class="rounded-xl discount-badge pulse">
                                    {{ $produk->diskon }}%
                                </span>
                            @else
                                <div class="flex flex-wrap items-center gap-0">
                                    <span class="text-sm font-medium text-gray-500">
                                        Rp
                                    </span>
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ $produk->harga_format }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- PRODUCT OPTIONS (DESKTOP) --}}
                <div class="bg-white px-4 py-4 space-y-6 fade-in variation-section lg:rounded-lg">
                    {{-- VARIATION SELECTOR (MOBILE) --}}
                    <div class="lg:hidden">
                        <button type="button" class="w-full py-3 px-4 border border-gray-300 text-left rounded-xl cursor-pointer mt-2" onclick="openVariationModal()">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-500">Pilih Varian</p>
                                    <p id="selectedVariationText" class="text-sm font-medium">Warna: - | Ukuran: -</p>
                                </div>
                                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-500"></i>
                            </div>
                        </button>
                    </div>

                    {{-- OPTIONS SELECTION --}}
                    @if(!empty($produk->warna))
                        @php
                            $warnaList = is_array($produk->warna) ? $produk->warna : json_decode($produk->warna, true);
                            $colorMap = [
                                'hitam' => '#000000',
                                'putih' => '#FFFFFF',
                                'merah' => '#FF0000',
                                'biru' => '#0000FF',
                                'hijau' => '#00FF00',
                                'kuning' => '#FFFF00',
                                'ungu' => '#800080',
                                'abu-abu' => '#808080',
                                'coklat' => '#A52A2A',
                                'pink' => '#FFC0CB',
                                'orange' => '#FFA500',
                                'navy' => '#000080',
                                'maroon' => '#800000',
                                'teal' => '#008080',
                                'olive' => '#808000',
                                'silver' => '#C0C0C0',
                                'gold' => '#FFD700'
                            ];
                        @endphp

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Warna</label>
                                <span class="text-sm text-gray-500" id="selectedColorText-{{ $produk->id }}">Pilih warna</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($warnaList as $w)
                                    @php
                                        $warnaLower = strtolower($w);
                                        $colorCode = $colorMap[$warnaLower] ?? null;
                                    @endphp

                                    @if($colorCode)
                                        <button type="button"
                                            class="color-option px-4 py-2 rounded-xl border border-gray-300 bg-transparent hover:scale-110 transition-all duration-200"
                                            style="--color-hover: {{ $colorCode }}; --color-selected: {{ $colorCode }}"
                                            data-color="{{ $w }}" data-item="{{ $produk->id }}" data-color-lower="{{ $warnaLower }}"
                                            onclick="selectColor(this, '{{ $w }}', '{{ $produk->id }}')">
                                            {{ ucfirst($w) }}
                                        </button>
                                    @else
                                        <button type="button"
                                            class="option-chip px-4 py-2 rounded-lg border border-gray-300 bg-transparent text-gray-700 hover:bg-gray-100 hover:border-gray-400 transition-all duration-200"
                                            data-color="{{ $w }}" data-item="{{ $produk->id }}" data-color-lower="{{ $warnaLower }}"
                                            onclick="selectColor(this, '{{ $w }}', '{{ $produk->id }}')">
                                            {{ ucfirst($w) }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                            <input type="hidden" name="warna" id="selectedColor-{{ $produk->id }}" value="">
                        </div>
                    @endif

                    {{-- SIZE SELECTION --}}
                    @if(!empty($produk->ukuran))
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Ukuran</label>
                                <span class="text-sm text-gray-500" id="selectedSizeText-{{ $produk->id }}">Pilih ukuran</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($produk->ukuran as $u)
                                    <button type="button" class="option-chip" data-size="{{ $u }}" data-item="{{ $produk->id }}"
                                        onclick="selectSize(this, '{{ $u }}', '{{ $produk->id }}')">
                                        {{ $u }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="ukuran" id="selectedSize-{{ $produk->id }}" value="">
                        </div>
                    @endif

                    {{-- QUANTITY SELECTOR --}}
                    <div class="border-t border-gray-400/50 pt-4 items-center justify-center">
                        <label class="block text-center text-sm font-medium text-gray-700 mb-3">Jumlah</label>
                        <div class="flex items-center justify-center gap-2 w-full">
                            <button type="button" onclick="detailDecrementQty({{ $produk->id }})"
                                class="qty-btn flex w-10 h-10 items-center justify-center border border-gray-400 bg-white hover:text-gray-400 hover:border-gray-400 rounded-full cursor-pointer transition-all duration-200"
                                id="decrementBtn-{{ $produk->id }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>

                            <input type="number" id="desktopQty-{{ $produk->id }}" min="1" max="{{ $produk->jumlah }}"
                                value="1" class="w-12 h-8 text-center rounded-full text-sm font-medium text-gray-900"
                                onchange="detailValidateQty({{ $produk->id }})">
                            <button type="button" onclick="detailIncrementQty({{ $produk->id }})"
                                class="qty-btn flex w-10 h-10 items-center justify-center border text-white border-gray-400 bg-gray-400 hover:text-gray-400 hover:border-gray-400 rounded-full cursor-pointer transition-all duration-200"
                                id="incrementBtn-{{ $produk->id }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-center text-xs text-gray-500 mt-2">Stok tersedia: <span
                                class="font-medium">{{ $produk->jumlah }}</span></p>
                    </div>

                    {{-- ACTION BUTTONS (DESKTOP) --}}
                    <div class="desktop-actions hidden lg:flex gap-3 fade-in">
                        <button type="button" onclick="toggleWishlistDetail('{{ $produk->id }}')"
                            class="flex items-center justify-center bg-white border border-gray-500 hover:bg-gray-200 gap-2 font-medium py-3 px-4 rounded-xl transition-all duration-200">
                            <svg id="wishlistIcon-{{ $produk->id }}"
                                class="w-7 h-7 text-gray-500 {{ in_array($produk->id, $wishlistIds ?? []) ? 'text-red-500 fill-red-500' : 'text-gray-500 fill-none' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>

                        <button type="button" onclick="detailAddToCart('{{ $produk->id }}')" id="cartBtn-{{ $produk->id }}"
                            class="flex-1 flex items-center justify-center border border-gray-600 text-gray-700 hover:bg-gray-600 hover:text-white gap-2 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                            {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{ $produk->jumlah > 0 ? 'Keranjang' : 'Stok Habis' }}
                        </button>

                        <form method="POST" action="{{ route('customer.checkout.dashboard') }}" class="flex-1 flex"
                            onsubmit="return syncCheckout('{{ $produk->id }}')">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" id="checkoutQty-{{ $produk->id }}" value="1"
                                max="{{ $produk->jumlah }}">
                            <input type="hidden" name="warna" id="checkoutColor-{{ $produk->id }}">
                            <input type="hidden" name="ukuran" id="checkoutSize-{{ $produk->id }}">
                            <button type="submit" id="checkoutBtn-{{ $produk->id }}"
                                class="w-full flex text-white items-center justify-center bg-gray-600 border border-gray-600 hover:bg-gray-700 hover:border-gray-700 gap-2 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                                {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
                                <i data-lucide="handbag" class="w-5 h-5"></i>
                                {{ $produk->jumlah > 0 ? 'Beli Sekarang' : 'Stok Habis' }}
                            </button>
                        </form>
                    </div>
                </div>

                {{-- PRODUCT DESCRIPTION --}}
                <div class="lg:hidden bg-white lg:rounded-lg p-4 fade-in">
                    <div class="border-b border-gray-300 pb-2">
                        <h3 class="text-center lg:text-left text-lg font-semibold text-gray-900">Deskripsi Produk</h3>
                    </div>
                    <div class="text-gray-700 text-sm leading-relaxed space-y-3">
                        @if($produk->deskripsi)
                            <div class="relative">
                                <div id="descriptionContent"
                                    class="whitespace-pre-line prose prose-sm max-w-none text-gray-700 overflow-hidden transition-all duration-300 max-h-32">
                                    {!! nl2br(e($produk->deskripsi)) !!}
                                </div>
                                <div id="descriptionOverlay"
                                    class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white to-transparent flex items-end justify-center pb-2">
                                    <button id="readMoreBtn"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm transition-colors duration-200">
                                        Lihat Selengkapnya
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm">Belum ada deskripsi produk</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- CUSTOMER REVIEWS SECTION --}}
        <div class="bg-white py-4 px-4 sm:p-6 lg:rounded-lg">
            <div class="border-b border-gray-300 mb-2 lg:mb-4 fade-in">
                <div class="flex flex-row items-center justify-between w-full gap-3">
    
                    {{-- TITLE --}}
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">
                            Ulasan Pelanggan
                        </h2>
                        <p class="text-gray-600 text-[10px] sm:text-sm">
                            Pengalaman dari pembeli produk
                            <span class="font-semibold">{{ $produk->nama_produk }}</span>
                        </p>
                    </div>
    
                    {{-- RATING SUMMARY --}}
                    <div class="flex items-center justify-center gap-4">
                        <div class="text-center rounded-xl px-3 py-2 min-w-[70px] sm:min-w-[100px]">
                            <div class="text-lg sm:text-xl font-bold text-gray-900 mb-1">
                                {{ $avgRating }}
                            </div>
    
                            <div class="flex items-center justify-start gap-0.5 mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgRating))
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
    
                            <p class="text-[9px] sm:text-xs text-gray-500">
                                {{ $totalUlasan }} ulasan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- RATING FILTERS --}}
            <div class="flex flex-wrap gap-2 mb-2 lg:mb-4">
                <button
                    class="filter-star rounded-lg px-2 py-1 md:px-4 md:py-3 bg-white text-gray-600 text-sm font-semibold transition-all duration-300 hover:bg-gray-600 hover:text-white hover:scale-105 border border-gray-300 active:scale-95"
                    data-star="all">
                    <span class="flex items-center text-xs lg:text-sm">Semua Ulasan</span>
                </button>
                @for($i = 5; $i >= 1; $i--)
                    <button
                        class="filter-star rounded-lg px-2 py-1 md:px-4 md:py-3 bg-white text-gray-700 text-sm font-semibold transition-all duration-300 hover:bg-gray-300 hover:scale-105 active:scale-95 border border-gray-300"
                        data-star="{{ $i }}">
                        <span class="flex items-center gap-1">
                            @for($s = 1; $s <= $i; $s++)
                                <span class="text-amber-400 text-sm drop-shadow-sm">★</span>
                            @endfor
                        </span>
                    </button>
                @endfor
            </div>
            {{-- REVIEWS LIST --}}
            @if($produk->ulasan->isNotEmpty())
                <div id="ulasanContainer" class="space-y-2">
                    @foreach($produk->ulasan as $u)
                        <div class="fade-in bg-white p-6 border-b border-gray-200 transition-all duration-500 shadow-sm backdrop-blur-sm"
                            data-rating="{{ $u->rating }}">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center text-white text-base font-bold flex-shrink-0 shadow-md">
                                    {{ substr($u->user->name ?? 'A', 0, 1) }}
                                </div>
    
                                <div class="flex-1 min-w-0 gap-y-2">
                                    {{-- HEADER: Nama, varian, dan tanggal --}}
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-2">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                            <p class="font-semibold text-gray-900 text-sm">{{ $u->user->name ?? 'Anonymous' }}</p>
    
                                            {{-- VARIAN (seperti di Shopee) --}}
                                            @if($u->orderItem)
                                                <div class="flex items-center text-xs text-gray-500">
                                                    @if($u->orderItem->warna)
                                                        <span>Variasi:<strong
                                                                class="ml-1 mr-1 text-bold uppercase">{{ $u->orderItem->warna }},</strong></span>
                                                    @endif
                                                    @if($u->orderItem->ukuran)
                                                        <strong class="text-bold uppercase">{{ $u->orderItem->ukuran }}</strong>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
    
                                        <span
                                            class="hidden lg:flex text-xs text-gray-500 whitespace-nowrap">{{ $u->created_at->format('d M Y') }}</span>
                                    </div>
    
                                    {{-- RATING --}}
                                    <div class="flex items-center mb-1">
                                        <div class="flex mr-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $u->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
    
                                    {{-- KOMENTAR --}}
                                    <p class="text-gray-700 text-sm leading-relaxed mb-3">{{ $u->komentar }}</p>
    
    
                                    {{-- FOTO ULASAN --}}
                                    @if($u->fotos->isNotEmpty())
                                        <div class="flex gap-2 overflow-x-auto pb-1">
                                            @foreach($u->fotos as $index => $f)
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $f->foto) }}"
                                                        class="w-20 h-20 object-cover rounded-md cursor-pointer transition-transform duration-300 hover:scale-105"
                                                        onclick="openReviewModal('{{ $u->id }}', {{ $index }})" alt="Foto ulasan">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="text-center py-12 bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="w-20 h-20 mx-auto mb-4 bg-white rounded-2xl flex items-center justify-center shadow-md">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada ulasan</h3>
                    <p class="text-gray-600 text-sm max-w-sm mx-auto leading-relaxed">Jadilah yang pertama membagikan pengalaman
                        menggunakan produk ini dan bantu pembeli lainnya</p>
                </div>
            @endif
        </div>
        </div>
    </main>

    {{-- MODALS --}}
    @include('layouts.partials_user.modals.img-produk')
    @include('layouts.partials_user.modals.img-ulasan')
    @include('layouts.partials_user.modals.varian')

    {{-- MOBILE FIXED ACTION BUTTONS --}}
    <div class="fixed flex lg:hidden bottom-0 left-0 right-0 bg-white py-2 px-2 z-[150] gap-1 md:gap-3 fade-in">
        <button type="button" onclick="toggleWishlistDetail('{{ $produk->id }}')"
            class="flex items-center justify-center border border-gray-500 bg-transpatent hover:bg-gray-200 font-medium py-3 px-3 rounded-xl transition-all duration-200">
            <svg id="fixedIcon-{{ $produk->id }}"
                class="w-7 h-7 text-gray-500 {{ in_array($produk->id, $wishlistIds ?? []) ? 'text-red-500 fill-red-500' : 'text-gray-500 fill-none' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>

        <button type="button" onclick="detailAddToCart('{{ $produk->id }}')" id="cartBtn-{{ $produk->id }}"
            class="flex items-center justify-center border border-gray-700 text-gray-700 hover:bg-gray-600 hover:text-white gap-2 font-medium py-3 px-4 rounded-xl transition-all duration-200"
            {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-sm">{{ $produk->jumlah > 0 ? 'Keranjang' : 'Stok Habis' }}</span>
        </button>

        <form method="POST" action="{{ route('customer.checkout.dashboard') }}" class="flex-1 flex"
            onsubmit="return syncCheckout('{{ $produk->id }}')">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
            <input type="hidden" name="jumlah" id="mobileCheckoutQty-{{ $produk->id }}" value="1"
                max="{{ $produk->jumlah }}">
            <input type="hidden" name="warna" id="mobileCheckoutColor-{{ $produk->id }}">
            <input type="hidden" name="ukuran" id="mobileCheckoutSize-{{ $produk->id }}">
            <button type="submit" id="mobileCheckoutBtn-{{ $produk->id }}"
                class="w-full flex text-white items-center justify-center bg-gray-600 border border-gray-600 hover:bg-gray-700 hover:border-gray-700 gap-2 font-medium py-3 px-4 rounded-xl transition-all duration-200"
                {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
                <i data-lucide="handbag" class="w-5 h-5"></i>
                <span class="text-sm">{{ $produk->jumlah > 0 ? 'Beli Sekarang' : 'Stok Habis' }}</span>
            </button>
        </form>
    </div>

@endsection

@push('script')
    <script>
        window.productImages = [
            @foreach($produk->fotos as $foto)
                "{{ asset('storage/' . $foto->foto) }}",
            @endforeach
                    ];
    </script>
    <script src="/assets/js/detail-product/product-modal.js"></script>

    <script>
        window.productId = "{{ $produk->id }}";
        window.productQty = "{{ $produk->jumlah }}";
    </script>
    <script src="/assets/js/detail-product/variation-modal.js"></script>
    <script src="/assets/js/detail-product/optional-select.js"></script>
    <script src="/assets/js/detail-product/info-product.js"></script>
    <script>
        window.ProductDetail = {
            productId: "{{ $produk->id }}",
            stock: {{ $produk->jumlah }},
            csrf: "{{ csrf_token() }}",
            addToCartUrl: "{{ route('keranjang.store') }}",
            wishlistUrl: "{{ url('/wishlist/toggle') }}",
            cartCheckUrl: "{{ url('/keranjang/cek') }}",
        };
    </script>
    <script src="/assets/js/detail-product/addCart-wishlist.js"></script>
    <script src="/assets/js/detail-product/checkout.js"></script>
    <script>
        window.reviewData = {
            @foreach($produk->ulasan as $u)
                                                                                                                                                                                                                                                                    "{{ $u->id }}": {
                    userName: @json(optional($u->user)->name ?? 'Anonymous'),
                    userInitial: @json(substr(optional($u->user)->name ?? 'A', 0, 1)),
                    variant: @json(
                        $u->orderItem
                        ? ($u->orderItem->warna
                            . ($u->orderItem->ukuran ? ' • Size: ' . $u->orderItem->ukuran : '')
                        )
                        : ''
                    ),

                    date: @json($u->created_at->format('d M Y')),
                    comment: @json($u->komentar),
                    rating: {{ $u->rating }},
                    photos: [
                        @foreach($u->fotos as $f)
                            @json(asset('storage/' . $f->foto)),
                        @endforeach
                                                                                                                                                                                                                                                                        ]
                },
            @endforeach
        };
    </script>
    <script src="/assets/js/detail-product/ulasan-modal.js"></script>
@endpush