@extends('layouts.user_app')

@section('title', 'Detail Produk')

@push('style')
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/user/produk-detail.css') }}"> -->
    <style>
        /* Custom styles for the Tokopedia-inspired gray theme */
        .product-gallery {
            top: 100px;
        }
        
        .mobile-fixed-actions {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 12px 16px;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
            z-index: 40;
            display: none;
        }
        
        @media (max-width: 1023px) {
            .mobile-fixed-actions {
                display: flex;
            }
            .desktop-actions {
                display: none;
            }
            main {
                padding-bottom: 90px;
            }
        }
        
        .btn-gray {
            background-color: #4b5563;
            color: white;
            transition: all 0.2s;
        }
        
        .btn-gray:hover {
            background-color: #374151;
            transform: translateY(-1px);
        }
        
        .btn-outline-gray {
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
            transition: all 0.2s;
        }
        
        .btn-outline-gray:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
            transform: translateY(-1px);
        }
        
        .section-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }
        
        .price-tag {
            color: #dc2626;
        }
        
        .discount-badge {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .stock-badge {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .out-of-stock-badge {
            background-color: #fef2f2;
            color: #dc2626;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .option-btn {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 12px;
            background: white;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .option-btn:hover {
            border-color: #9ca3af;
        }
        
        .option-btn.selected {
            border-color: #4b5563;
            background-color: #4b5563;
            color: white;
        }
        
        .option-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .option-btn:disabled:hover {
            border-color: #d1d5db;
        }
        
        .qty-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .qty-btn:hover:not(:disabled) {
            background-color: #f9fafb;
        }
        
        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .qty-input {
            width: 48px;
            height: 32px;
            text-align: center;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            margin: 0 8px;
            font-weight: 500;
        }
        
        .qty-input:focus {
            outline: none;
            border-color: #4b5563;
        }
        
        .review-card {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }
        
        .review-card:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .thumbnail-list {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
        
        .thumbnail-list::-webkit-scrollbar {
            height: 6px;
        }
        
        .thumbnail-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        
        .thumbnail-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .thumbnail-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .image-modal {
            transition: opacity 0.3s ease;
        }
        
        .image-modal.hidden {
            opacity: 0;
            pointer-events: none;
        }
        
        .image-modal:not(.hidden) {
            opacity: 1;
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .shake {
            animation: shake 0.5s;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
@endpush

@section('content')
    <main class="container mx-auto px-4 py-6">
        {{-- BREADCRUMB --}}
        <div class="text-sm text-gray-500 mb-6">
            <a href="{{ route('customer.dashboard') }}" class="hover:text-gray-700 transition-colors">Beranda</a> 
            <span class="mx-2">/</span>
            <a href="#" class="hover:text-gray-700 transition-colors">Kategori</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $produk->nama_produk }}</span>
        </div>
        
        {{-- PRODUCT SECTION: GALLERY + INFO --}}
        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            {{-- PRODUCT GALLERY --}}
            <div class="product-gallery">
                {{-- LARGE IMAGE --}}
                <div class="section-card p-4 mb-4 fade-in">
                    <div class="main-image rounded-lg overflow-hidden bg-gray-50">
                        @if($produk->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}" alt="{{ $produk->nama_produk }}"
                                id="mainImage"
                                class="w-full h-80 object-contain cursor-zoom-in transition-transform duration-300 hover:scale-105"
                                onclick="openModal('{{ asset('storage/' . $produk->fotos->first()->foto) }}')" />
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="No Image" id="mainImage"
                                class="w-full h-80 object-contain" />
                        @endif
                    </div>
                </div>

                {{-- THUMBNAIL LIST --}}
                <div class="section-card p-4 fade-in">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Gambar Produk</h3>
                    <div class="thumbnail-list flex gap-3 overflow-x-auto pb-2">
                        @if($produk->fotos->isNotEmpty())
                            @foreach($produk->fotos as $key => $foto)
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Thumbnail {{ $key + 1 }}" 
                                    class="thumb w-16 h-16 object-cover rounded cursor-pointer border-2 transition-all duration-200
                                    {{ $key === 0 ? 'border-gray-700' : 'border-gray-200 hover:border-gray-400' }}" 
                                    onclick="setMainImage(this.src, this)" />
                            @endforeach
                        @else
                            <div class="flex items-center justify-center w-full py-4">
                                <span class="text-gray-400 text-sm">Tidak ada gambar produk</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- IMAGE MODAL -->
            <div id="imageModal" class="image-modal fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center hidden z-50 p-4">
                <div class="max-w-4xl max-h-full">
                    <div class="relative">
                        <button onclick="closeModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors p-2 rounded-full hover:bg-white hover:bg-opacity-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <img id="modalImage" src="" class="max-w-full max-h-screen object-contain rounded-lg shadow-2xl">
                    </div>
                </div>
            </div>

            {{-- PRODUCT INFORMATION --}}
            <div class="space-y-6">
                {{-- HEADER & STATUS --}}
                <div class="space-y-3 fade-in">
                    <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $produk->nama_produk }}</h1>

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
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 mr-1 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
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
                <div class="section-card p-4 fade-in">
                    @php
                        $diskon = $produk->diskon ?? 0;
                        $hargaFinal = $diskon > 0
                            ? $produk->harga - ($produk->harga * $diskon / 100)
                            : $produk->harga;
                    @endphp

                    <div class="flex items-center flex-wrap gap-2">
                        <span class="price-tag text-2xl font-bold">
                            Rp {{ number_format($hargaFinal, 0, ',', '.') }}
                        </span>
                        @if($diskon > 0)
                            <span class="text-gray-500 line-through text-lg">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                            <span class="discount-badge pulse">
                                {{ $diskon }}%
                            </span>
                        @endif
                    </div>
                </div>

                {{-- PRODUCT OPTIONS --}}
                <div class="section-card p-4 space-y-6 fade-in">
                    {{-- COLOR SELECTION --}}
                    @if(!empty($produk->warna))
                        @php
                            $warnaList = is_array($produk->warna) ? $produk->warna : json_decode($produk->warna, true);
                        @endphp

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Warna</label>
                                <span class="text-sm text-gray-500" id="selectedColorText-{{ $produk->id }}">Pilih warna</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($warnaList as $w)
                                    <button type="button" class="option-btn" data-color="{{ $w }}" data-item="{{ $produk->id }}" onclick="selectColor(this, '{{ $w }}', '{{ $produk->id }}')">
                                        {{ ucfirst($w) }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="warna" id="selectedColor-{{ $produk->id }}">
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
                                    <button type="button" class="option-btn" data-size="{{ $u }}" data-item="{{ $produk->id }}" onclick="selectSize(this, '{{ $u }}', '{{ $produk->id }}')">
                                        {{ $u }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="ukuran" id="selectedSize-{{ $produk->id }}">
                        </div>
                    @endif

                    {{-- QUANTITY SELECTOR --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Jumlah</label>
                        <div class="flex items-center gap-2 w-fit">
                            <button type="button" onclick="decrementQty({{ $produk->id }})" class="qty-btn" id="decrementBtn-{{ $produk->id }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" id="qty-{{ $produk->id }}" min="1" max="{{ $produk->jumlah }}" value="1"
                                class="qty-input text-sm font-medium text-gray-900"
                                onchange="validateQty({{ $produk->id }})">
                            <button type="button" onclick="incrementQty({{ $produk->id }})" class="qty-btn" id="incrementBtn-{{ $produk->id }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Stok tersedia: <span class="font-medium">{{ $produk->jumlah }}</span></p>
                    </div>
                </div>

                {{-- ACTION BUTTONS (DESKTOP) --}}
                <div class="desktop-actions flex gap-3 pt-2 fade-in">
                    <button type="button" onclick="addToCart('{{ $produk->id }}')" id="cartBtn-{{ $produk->id }}"
                        class="flex-1 flex items-center justify-center gap-2 btn-outline-gray font-medium py-3 px-4 rounded-lg transition-all duration-200"
                        {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ $produk->jumlah > 0 ? 'Keranjang' : 'Stok Habis' }}
                    </button>
                        
                    <form method="POST" action="{{ route('customer.checkout.dashboard') }}" class="flex-1"
                        onsubmit="return syncCheckout('{{ $produk->id }}')">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <input type="hidden" name="jumlah" id="checkoutQty-{{ $produk->id }}" value="1">
                        <input type="hidden" name="warna" id="checkoutColor-{{ $produk->id }}">
                        <input type="hidden" name="ukuran" id="checkoutSize-{{ $produk->id }}">
                        <button type="submit" id="checkoutBtn-{{ $produk->id }}"
                            class="w-full flex items-center justify-center gap-2 btn-gray font-medium py-3 px-4 rounded-lg transition-all duration-200"
                            {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            {{ $produk->jumlah > 0 ? 'Beli Sekarang' : 'Stok Habis' }}
                        </button>
                    </form>
                </div>

                {{-- PRODUCT DESCRIPTION --}}
                <div class="section-card p-4 fade-in">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                    <div class="text-gray-700 text-sm leading-relaxed">
                        <p>{{ $produk->deskripsi ?? 'Belum ada deskripsi produk.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CUSTOMER REVIEWS SECTION --}}
        <div class="section-card p-6 mb-8 fade-in">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Ulasan Pelanggan</h2>
                        
                {{-- RATING SUMMARY --}}
                <div class="flex items-center gap-4 mt-2 md:mt-0">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $avgRating }}</div>
                        <div class="flex items-center justify-center mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($avgRating))
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $totalUlasan }} ulasan</p>
                    </div>
                </div>            
            </div>

            {{-- RATING FILTERS --}}
            <div class="flex flex-wrap gap-2 mb-6 pb-4 border-b border-gray-200">
                <button class="filter-star px-3 py-2 bg-gray-800 text-white rounded text-xs font-medium transition-all duration-200"
                    data-star="all">Semua Ulasan</button>
                @for($i = 5; $i >= 1; $i--)
                    <button class="filter-star px-3 py-2 bg-gray-100 text-gray-700 rounded text-xs font-medium transition-all duration-200 hover:bg-gray-200"
                        data-star="{{ $i }}">
                        <span class="flex items-center">
                            @for($s = 1; $s <= $i; $s++)
                                <span class="text-yellow-400 text-xs">★</span>
                            @endfor
                            <span class="ml-1">{{ $i }}</span>
                        </span>
                    </button>
                @endfor
            </div>

            {{-- REVIEWS LIST --}}
            @if($produk->ulasan->isNotEmpty())
                <div id="ulasanContainer" class="space-y-0">
                    @foreach($produk->ulasan as $u)
                        <div class="review-card fade-in"
                            data-rating="{{ $u->rating }}">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-xs font-semibold">
                                        {{ substr($u->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $u->user->name ?? 'Anonymous' }}</p>
                                        <div class="flex items-center mt-1">
                                            <div class="flex mr-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $u->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $u->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 text-sm mb-3">{{ $u->komentar }}</p>

                            @if($u->fotos->isNotEmpty())
                                <div class="flex gap-2 overflow-x-auto pb-2">
                                    @foreach($u->fotos as $f)
                                        <img src="{{ asset('storage/' . $f->foto) }}" 
                                            class="w-12 h-12 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                            onclick="openModal('{{ asset('storage/' . $f->foto) }}')" />
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h3 class="text-base font-medium text-gray-900 mb-1">Belum ada ulasan</h3>
                    <p class="text-gray-500 text-sm">Jadilah yang pertama memberikan ulasan untuk produk ini.</p>
                </div>
            @endif
        </div>
    </main>
    
    {{-- MOBILE FIXED ACTION BUTTONS --}}
    <div class="mobile-fixed-actions">
        <button type="button" onclick="addToCart('{{ $produk->id }}')" id="mobileCartBtn-{{ $produk->id }}"
            class="flex-1 flex items-center justify-center gap-2 btn-outline-gray font-medium py-3 px-4 rounded-lg transition-all duration-200 mr-2"
            {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            {{ $produk->jumlah > 0 ? 'Keranjang' : 'Stok Habis' }}
        </button>
            
        <form method="POST" action="{{ route('customer.checkout.dashboard') }}" class="flex-1"
            onsubmit="return syncCheckout('{{ $produk->id }}')">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
            <input type="hidden" name="jumlah" id="checkoutQty-mobile-{{ $produk->id }}" value="1">
            <input type="hidden" name="warna" id="checkoutColor-mobile-{{ $produk->id }}">
            <input type="hidden" name="ukuran" id="checkoutSize-mobile-{{ $produk->id }}">
            <button type="submit" id="mobileCheckoutBtn-{{ $produk->id }}"
                class="w-full flex items-center justify-center gap-2 btn-gray font-medium py-3 px-4 rounded-lg transition-all duration-200"
                {{ $produk->jumlah <= 0 ? 'disabled' : '' }}>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                {{ $produk->jumlah > 0 ? 'Beli' : 'Stok Habis' }}
            </button>
        </form>
    </div>
@endsection

@push('script')
<script>
    // IMAGE GALLERY FUNCTIONS
    function setMainImage(src, element) {
        const mainImage = document.getElementById('mainImage');
        
        // Add fade out effect
        mainImage.style.opacity = '0';
        
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
            
            // Update thumbnails
            document.querySelectorAll('.thumb').forEach(thumb => {
                thumb.classList.remove('border-gray-700');
                thumb.classList.add('border-gray-200');
            });
            element.classList.remove('border-gray-200');
            element.classList.add('border-gray-700');
        }, 150);
    }

    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        img.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Add fade in effect
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // =============================
    // COLOR & SIZE SELECTION
    // =============================
    function selectColor(element, color, productId) {
        // Remove selected class from all color options for this product
        document.querySelectorAll(`.option-btn[data-item="${productId}"]`).forEach(opt => {
            if (opt.dataset.color) {
                opt.classList.remove('selected');
            }
        });
        
        // Add selected class to clicked element
        element.classList.add('selected');
        
        // Update hidden input and display text
        document.getElementById(`selectedColor-${productId}`).value = color;
        document.getElementById(`selectedColorText-${productId}`).textContent = color;
        document.getElementById(`checkoutColor-${productId}`).value = color;
        document.getElementById(`checkoutColor-mobile-${productId}`).value = color;
    }

    function selectSize(element, size, productId) {
        // Remove selected class from all size options for this product
        document.querySelectorAll(`.option-btn[data-item="${productId}"]`).forEach(opt => {
            if (opt.dataset.size) {
                opt.classList.remove('selected');
            }
        });
        
        // Add selected class to clicked element
        element.classList.add('selected');
        
        // Update hidden input and display text
        document.getElementById(`selectedSize-${productId}`).value = size;
        document.getElementById(`selectedSizeText-${productId}`).textContent = size;
        document.getElementById(`checkoutSize-${productId}`).value = size;
        document.getElementById(`checkoutSize-mobile-${productId}`).value = size;
    }

    // =============================
    // QUANTITY FUNCTIONS
    // =============================
    function incrementQty(productId) {
        const input = document.getElementById(`qty-${productId}`);
        const max = parseInt(input.getAttribute('max')) || 999;
        const currentValue = parseInt(input.value);
        
        if (currentValue < max) {
            input.value = currentValue + 1;
            updateQtyButtons(productId);
            document.getElementById(`checkoutQty-${productId}`).value = input.value;
            document.getElementById(`checkoutQty-mobile-${productId}`).value = input.value;
        } else {
            // Shake animation when reaching max
            input.classList.add('shake');
            setTimeout(() => input.classList.remove('shake'), 500);
        }
    }

    function decrementQty(productId) {
        const input = document.getElementById(`qty-${productId}`);
        const currentValue = parseInt(input.value);
        
        if (currentValue > 1) {
            input.value = currentValue - 1;
            updateQtyButtons(productId);
            document.getElementById(`checkoutQty-${productId}`).value = input.value;
            document.getElementById(`checkoutQty-mobile-${productId}`).value = input.value;
        } else {
            // Shake animation when reaching min
            input.classList.add('shake');
            setTimeout(() => input.classList.remove('shake'), 500);
        }
    }

    function validateQty(productId) {
        const input = document.getElementById(`qty-${productId}`);
        const max = parseInt(input.getAttribute('max')) || 999;
        let value = parseInt(input.value);
        
        if (isNaN(value) || value < 1) value = 1;
        if (value > max) value = max;
        
        input.value = value;
        updateQtyButtons(productId);
        document.getElementById(`checkoutQty-${productId}`).value = value;
        document.getElementById(`checkoutQty-mobile-${productId}`).value = value;
    }

    function updateQtyButtons(productId) {
        const input = document.getElementById(`qty-${productId}`);
        const currentValue = parseInt(input.value);
        const max = parseInt(input.getAttribute('max')) || 999;
        
        // Update decrement button
        const decrementBtn = document.getElementById(`decrementBtn-${productId}`);
        if (currentValue <= 1) {
            decrementBtn.disabled = true;
        } else {
            decrementBtn.disabled = false;
        }
        
        // Update increment button
        const incrementBtn = document.getElementById(`incrementBtn-${productId}`);
        if (currentValue >= max) {
            incrementBtn.disabled = true;
        } else {
            incrementBtn.disabled = false;
        }
    }

    // =============================
    // ADD TO CART
    // =============================
    function addToCart(productId) {
        // Check if product is out of stock
        if ({{ $produk->jumlah }} <= 0) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Stok Habis', 
                text: 'Maaf, produk ini sedang tidak tersedia.',
                confirmButtonColor: '#4b5563' 
            });
            return;
        }

        const color = document.getElementById(`selectedColor-${productId}`)?.value;
        const size = document.getElementById(`selectedSize-${productId}`)?.value;
        const quantity = parseInt(document.getElementById(`qty-${productId}`)?.value) || 1;

        // Validate color selection if required
        if (document.querySelector(`.option-btn[data-item="${productId}"][data-color]`) && !color) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Pilih Warna', 
                text: 'Silakan pilih warna terlebih dahulu!', 
                confirmButtonColor: '#4b5563' 
            });
            
            // Highlight color options
            document.querySelectorAll(`.option-btn[data-item="${productId}"][data-color]`).forEach(btn => {
                btn.classList.add('shake');
                setTimeout(() => btn.classList.remove('shake'), 1000);
            });
            return;
        }

        // Validate size selection if required
        if (document.querySelector(`.option-btn[data-item="${productId}"][data-size]`) && !size) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Pilih Ukuran', 
                text: 'Silakan pilih ukuran terlebih dahulu!', 
                confirmButtonColor: '#4b5563' 
            });
            
            // Highlight size options
            document.querySelectorAll(`.option-btn[data-item="${productId}"][data-size]`).forEach(btn => {
                btn.classList.add('shake');
                setTimeout(() => btn.classList.remove('shake'), 1000);
            });
            return;
        }

        // Show loading state
        const cartBtn = document.getElementById(`cartBtn-${productId}`);
        const mobileCartBtn = document.getElementById(`mobileCartBtn-${productId}`);
        const originalText = cartBtn.innerHTML;
        const loadingText = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menambahkan...';
        
        cartBtn.innerHTML = loadingText;
        cartBtn.disabled = true;
        if (mobileCartBtn) {
            mobileCartBtn.innerHTML = loadingText;
            mobileCartBtn.disabled = true;
        }

        fetch("{{ route('keranjang.store') }}", {
            method: "POST",
            headers: { 
                "Content-Type": "application/json", 
                "X-CSRF-TOKEN": "{{ csrf_token() }}" 
            },
            body: JSON.stringify({ 
                produk_id: productId, 
                warna: color, 
                ukuran: size, 
                jumlah: quantity 
            })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(data => {
            // Reset button state
            cartBtn.innerHTML = originalText;
            cartBtn.disabled = false;
            if (mobileCartBtn) {
                mobileCartBtn.innerHTML = 'Keranjang';
                mobileCartBtn.disabled = false;
            }
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message ?? 'Produk berhasil ditambahkan ke keranjang.',
                showConfirmButton: false,
                timer: 1500,
                toast: true,
                position: 'top-end',
                background: '#10b981',
                color: 'white',
                iconColor: 'white'
            });

            // UPDATE BADGE REAL-TIME
            refreshCartPopup();
        })
        .catch(err => {
            console.error(err);
            
            // Reset button state
            cartBtn.innerHTML = originalText;
            cartBtn.disabled = false;
            if (mobileCartBtn) {
                mobileCartBtn.innerHTML = 'Keranjang';
                mobileCartBtn.disabled = false;
            }
            
            Swal.fire({ 
                icon: 'error', 
                title: 'Terjadi Kesalahan!', 
                text: 'Gagal menambahkan produk ke keranjang.', 
                confirmButtonColor: '#4b5563' 
            });
        });
    }

    // =============================
    // REFRESH CART BADGE
    // =============================
    function refreshCartPopup() {
        fetch("{{ url('/keranjang/cek') }}", {
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(data => {
            const total = data.items?.length || 0;
            animateCartBadge(total);
        })
        .catch(err => console.error(err));
    }

    function animateCartBadge(total) {
        const badge = document.getElementById('cartBadge');
        if (!badge) return;
        if (total > 0) {
            badge.textContent = total;
            badge.classList.remove('hidden');
            badge.classList.add('animate-bounce');
            setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
        } else {
            badge.classList.add('hidden');
        }
    }

    // =============================
    // SYNC CHECKOUT
    // =============================
    function syncCheckout(productId) {
        // Check if product is out of stock
        if ({{ $produk->jumlah }} <= 0) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Stok Habis', 
                text: 'Maaf, produk ini sedang tidak tersedia.',
                confirmButtonColor: '#4b5563' 
            });
            return false;
        }

        const color = document.getElementById(`selectedColor-${productId}`)?.value;
        const size = document.getElementById(`selectedSize-${productId}`)?.value;
        const quantity = document.getElementById(`qty-${productId}`).value;

        if (document.querySelector(`.option-btn[data-item="${productId}"][data-color]`) && !color) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Pilih Warna', 
                text: 'Pilih warna terlebih dahulu!', 
                confirmButtonColor: '#4b5563' 
            });
            return false;
        }

        if (document.querySelector(`.option-btn[data-item="${productId}"][data-size]`) && !size) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Pilih Ukuran', 
                text: 'Pilih ukuran terlebih dahulu!', 
                confirmButtonColor: '#4b5563' 
            });
            return false;
        }

        document.getElementById(`checkoutColor-${productId}`).value = color;
        document.getElementById(`checkoutSize-${productId}`).value = size;
        document.getElementById(`checkoutQty-${productId}`).value = quantity;
        
        // Also sync mobile form
        document.getElementById(`checkoutColor-mobile-${productId}`).value = color;
        document.getElementById(`checkoutSize-mobile-${productId}`).value = size;
        document.getElementById(`checkoutQty-mobile-${productId}`).value = quantity;
        
        return true;
    }

    // =============================
    // REVIEW FILTERING
    // =============================
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-star');
        const ulasanCards = document.querySelectorAll('.review-card');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const rating = this.getAttribute('data-star');
                
                // Update active filter button
                document.querySelectorAll('.filter-star').forEach(b => {
                    b.classList.remove('bg-gray-800', 'text-white');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });
                this.classList.remove('bg-gray-100', 'text-gray-700');
                this.classList.add('bg-gray-800', 'text-white');

                // Filter reviews
                ulasanCards.forEach(card => {
                    if (rating === 'all' || card.getAttribute('data-rating') === rating) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });

        // Initialize quantity buttons
        updateQtyButtons('{{ $produk->id }}');

        // Close modal with escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') closeModal();
        });

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    });
</script>
@endpush