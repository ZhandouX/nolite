@extends('layouts.user_app')

@section('title', 'Detail Produk')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/user/produk-detail.css') }}">
@endpush

@section('content')
    <main class="container mx-auto px-4 py-8">
        {{-- PRODUCT SECTION: GALLERY + INFO --}}
        <div class="grid lg:grid-cols-2 gap-12 mb-16 mt-14">
            {{-- PRODUCT GALLERY --}}
            <div class="space-y-4">
                {{-- LARGE IMAGE --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="main-image relative overflow-hidden rounded-xl">
                        @if($produk->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}" alt="{{ $produk->nama_produk }}"
                                id="mainImage"
                                class="w-full h-96 object-contain transition-all duration-300 cursor-zoom-in"
                                onclick="openModal('{{ asset('storage/' . $produk->fotos->first()->foto) }}')" />
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="No Image" id="mainImage"
                                class="w-full h-96 object-contain transition-all duration-300" />
                        @endif
                    </div>
                </div>

                {{-- THUMBNAIL LIST --}}
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Gambar Produk</h3>
                    <div class="thumbnail-list flex gap-3 overflow-x-auto pb-2">
                        @if($produk->fotos->isNotEmpty())
                            @foreach($produk->fotos as $key => $foto)
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Thumbnail {{ $key + 1 }}" 
                                    class="thumb w-20 h-20 object-cover rounded-lg cursor-pointer border-2 transition-all duration-200
                                    {{ $key === 0 ? 'border-red-600' : 'border-gray-200 hover:border-gray-300' }}" 
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
            <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center hidden z-50 p-4">
                <div class="max-w-4xl max-h-full">
                    <div class="relative">
                        <button onclick="closeModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <img id="modalImage" src="" class="max-w-full max-h-screen object-contain rounded-lg">
                    </div>
                </div>
            </div>

            {{-- PRODUCT INFORMATION --}}
            <div class="space-y-6">
                {{-- HEADER & STATUS --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $produk->jumlah > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $produk->jumlah > 0 ? 'Tersedia' : 'Stok Habis' }}
                        </span>
                        <button class="p-2 text-gray-400 hover:text-red-500 transition-colors rounded-full hover:bg-gray-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $produk->nama_produk }}</h1>

                    @php
                        $ulasan = $produk->ulasan; // relasi ulasan produk
                        $totalUlasan = $ulasan->count();
                        $avgRating = $totalUlasan ? round($ulasan->avg('rating'), 1) : 0;
                    @endphp

                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <span class="flex items-center">
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
                            <span class="ml-1">{{ $avgRating }} ({{ $totalUlasan }} ulasan)</span>
                        </span>
                        <span>•</span>
                        <span>{{ $terjual ?? 0 }} terjual</span>
                    </div>
                </div>

                {{-- PRICING --}}
                <div class="py-4 border-y border-gray-200">
                    @php
                        $diskon = $produk->diskon ?? 0;
                        $hargaFinal = $diskon > 0
                            ? $produk->harga - ($produk->harga * $diskon / 100)
                            : $produk->harga;
                    @endphp

                    <div class="flex items-center flex-wrap gap-2">
                        @if($diskon > 0)
                            <span class="text-3xl font-bold text-red-900">
                                IDR {{ number_format($hargaFinal, 0, ',', '.') }}
                            </span>
                            <span class="text-lg text-gray-500 line-through">
                                IDR {{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                            <span class="bg-red-100 text-red-700 text-sm font-semibold px-2 py-1 rounded-md">
                                -{{ $diskon }}%
                            </span>
                        @else
                            <span class="text-3xl font-bold text-gray-900">
                                IDR {{ number_format($hargaFinal, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-600 mt-1">
                        Stok: <span class="font-medium">{{ $produk->jumlah ?? 0 }}</span>
                    </p>
                </div>

                {{-- PRODUCT OPTIONS --}}
                <div class="space-y-6">
                    {{-- COLOR SELECTION --}}
                    @if(!empty($produk->warna))
                        @php
                            $warnaList = is_array($produk->warna) ? $produk->warna : json_decode($produk->warna, true);
                            $mapWarna = [
                                'merah' => '#ef4444',
                                'biru' => '#3b82f6',
                                'hijau' => '#22c55e',
                                'kuning' => '#eab308',
                                'hitam' => '#000000',
                                'putih' => '#ffffff',
                                'abu-abu' => '#9ca3af',
                                'ungu' => '#8b5cf6',
                                'oranye' => '#f97316',
                                'pink' => '#ec4899'
                            ];
                        @endphp

                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Pilih Warna</label>
                                <span class="text-sm text-gray-500" id="selectedColorText-{{ $produk->id }}">Belum dipilih</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($warnaList as $w)
                                    @php 
                                        $warna = strtolower(trim($w));
                                        $hex = $mapWarna[$warna] ?? '#d1d5db';
                                        $isLight = in_array($warna, ['putih', 'kuning']);
                                    @endphp

                                    <span class="color-option relative px-3 py-1 rounded-lg cursor-pointer border border-gray-500 transition-all duration-200 text-gray-700" data-color="{{ $w }}" data-item="{{ $produk->id }}" style="--bg-color: {{ $hex }};" onclick="selectColor(this, '{{ $w }}', '{{ $produk->id }}')">
                                        {{ ucfirst($w) }}
                                        <span class="check absolute top-0 right-0 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-white text-xs hidden">✓</span>
                                    </span>
                                @endforeach
                            </div>
                            <input type="hidden" name="warna" id="selectedColor-{{ $produk->id }}">
                        </div>
                    @endif

                    {{-- SIZE SELECTION --}}
                    @if(!empty($produk->ukuran))
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Pilih Ukuran</label>
                                <span class="text-sm text-gray-500" id="selectedSizeText-{{ $produk->id }}">Belum dipilih</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($produk->ukuran as $u)
                                    <button type="button" class="size-option px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium transition-all duration-200 hover:border-gray-400 hover:bg-gray-50" data-size="{{ $u }}" data-item="{{ $produk->id }}" onclick="selectSize(this, '{{ $u }}', '{{ $produk->id }}')">
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
                        <div class="flex items-center gap-3 w-fit">
                            <button type="button" onclick="decrementQty({{ $produk->id }})"
                                class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 text-gray-600 bg-white hover:bg-gray-50 active:scale-95 transition-all duration-200 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" id="qty-{{ $produk->id }}" min="1" max="{{ $produk->jumlah }}" value="1"
                                class="w-16 text-center text-base font-semibold text-gray-900 border border-gray-300 rounded-lg bg-white py-2"
                                onchange="validateQty({{ $produk->id }})">
                            <button type="button" onclick="incrementQty({{ $produk->id }})"
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-800 text-white hover:bg-gray-700 active:scale-95 transition-all duration-200 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Maksimal: {{ $produk->jumlah }} </p>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="button" onclick="addToCart('{{ $produk->id }}')"
                        class="flex-1 flex items-center justify-center gap-2 bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Tambah ke Keranjang
                    </button>
                        
                    <form method="POST" action="{{ route('customer.checkout.dashboard') }}" class="flex-1"
                        onsubmit="return syncCheckout('{{ $produk->id }}')">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <input type="hidden" name="jumlah" id="checkoutQty-{{ $produk->id }}" value="1">
                        <input type="hidden" name="warna" id="checkoutColor-{{ $produk->id }}">
                        <input type="hidden" name="ukuran" id="checkoutSize-{{ $produk->id }}">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-500 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Beli Sekarang
                        </button>
                    </form>
                </div>

                {{-- PRODUCT DESCRIPTION --}}
                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                    <div class="prose prose-sm max-w-none text-gray-600">
                        <p class="leading-relaxed">{{ $produk->deskripsi ?? 'Belum ada deskripsi produk.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CUSTOMER REVIEWS SECTION --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Ulasan Pelanggan</h2>
                        
                {{-- RATING SUMMARY --}}
                <div class="flex items-center gap-4 mt-2 md:mt-0">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-900">{{ $averageRating }}</div>
                        <div class="flex items-center justify-center">
                            @for($i = 1; $i <= 5; $i++)
                                @php
                                    $fullStar = $i <= floor($averageRating);
                                    $halfStar = !$fullStar && $i - $averageRating < 1;
                                @endphp
                                @if($fullStar)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @elseif($halfStar)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="half">
                                                <stop offset="50%" stop-color="currentColor"/>
                                                <stop offset="50%" stop-color="gray"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#half)" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ $totalUlasan }} ulasan</p>
                    </div>
                </div>            
            </div>

            {{-- RATING FILTERS --}}
            <div class="flex flex-wrap gap-2 mb-8 pb-4 border-b border-gray-200">
                <button class="filter-star px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md"
                    data-star="all">Semua Ulasan</button>
                @for($i = 5; $i >= 1; $i--)
                    <button class="filter-star px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-gray-200"
                        data-star="{{ $i }}">
                        <span class="flex items-center">
                            @for($s = 1; $s <= $i; $s++)
                                <span class="text-yellow-400">★</span>
                            @endfor
                            <span class="ml-1">{{ $i }}</span>
                        </span>
                    </button>
                @endfor
            </div>

            {{-- REVIEWS GRID --}}
            @if($produk->ulasan->isNotEmpty())
                <div id="ulasanContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($produk->ulasan as $u)
                        <div class="ulasan-card bg-gray-50 p-5 rounded-xl border border-gray-200 transition-all duration-300 hover:shadow-sm"
                            data-rating="{{ $u->rating }}">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold">
                                        {{ substr($u->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $u->user->name ?? 'Anonymous' }}</p>
                                        <div class="flex items-center mt-1">
                                            <div class="flex mr-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $u->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $u->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-4">{{ $u->komentar }}</p>

                            @if($u->fotos->isNotEmpty())
                                <div class="flex gap-2 overflow-x-auto pb-2">
                                    @foreach($u->fotos as $f)
                                        <img src="{{ asset('storage/' . $f->foto) }}" 
                                            class="w-16 h-16 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
                                            onclick="openModal('{{ asset('storage/' . $f->foto) }}')" />
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada ulasan</h3>
                    <p class="text-gray-500">Jadilah yang pertama memberikan ulasan untuk produk ini.</p>
                </div>
            @endif
        </div>
    </main>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // IMAGE GALLERY FUNCTIONS
    function setMainImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumb').forEach(thumb => {
            thumb.classList.remove('border-red-600');
            thumb.classList.add('border-gray-200');
        });
        element.classList.remove('border-gray-200');
        element.classList.add('border-red-600');
    }

    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        img.src = src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // =============================
    // COLOR & SIZE SELECTION
    // =============================
    function selectColor(element, color, productId) {
    // Hapus centang dari semua warna produk ini
    document.querySelectorAll(`.color-option[data-item="${productId}"]`).forEach(opt => {
        opt.classList.remove('selected');
    });

    // Tandai yang dipilih
    element.classList.add('selected');

    // Update teks dan input tersembunyi
    document.getElementById(`selectedColor-${productId}`).value = color;
    document.getElementById(`selectedColorText-${productId}`).textContent = color;
    document.getElementById(`checkoutColor-${productId}`).value = color;
}


    function selectSize(element, size, productId) {
        document.querySelectorAll(`.size-option[data-item="${productId}"]`).forEach(opt => {
            opt.classList.remove('bg-gray-900', 'text-white', 'border-gray-900');
            opt.classList.add('border-gray-300', 'text-gray-700', 'bg-white');
        });
        element.classList.remove('border-gray-300', 'text-gray-700', 'bg-white');
        element.classList.add('bg-gray-900', 'text-white', 'border-gray-900');
        document.getElementById(`selectedSize-${productId}`).value = size;
        document.getElementById(`selectedSizeText-${productId}`).textContent = size;
        document.getElementById(`checkoutSize-${productId}`).value = size;
    }

    // =============================
    // QUANTITY FUNCTIONS
    // =============================
    function incrementQty(productId) {
        const input = document.getElementById(`qty-${productId}`);
        const max = parseInt(input.getAttribute('max')) || 999;
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
            document.getElementById(`checkoutQty-${productId}`).value = input.value;
        }
    }

    function decrementQty(productId) {
        const input = document.getElementById(`qty-${productId}`);
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            document.getElementById(`checkoutQty-${productId}`).value = input.value;
        }
    }

    function validateQty(productId) {
        const input = document.getElementById(`qty-${productId}`);
        const max = parseInt(input.getAttribute('max')) || 999;
        let value = parseInt(input.value);
        if (isNaN(value) || value < 1) value = 1;
        if (value > max) value = max;
        input.value = value;
        document.getElementById(`checkoutQty-${productId}`).value = value;
    }

    // =============================
    // ADD TO CART
    // =============================
    function addToCart(productId) {
        const color = document.getElementById(`selectedColor-${productId}`)?.value;
        const size = document.getElementById(`selectedSize-${productId}`)?.value;
        const quantity = parseInt(document.getElementById(`qty-${productId}`)?.value) || 1;

        if (document.querySelector(`.color-option[data-item="${productId}"]`) && !color) {
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Silakan pilih warna terlebih dahulu!', confirmButtonColor: '#d33' });
            return;
        }

        if (document.querySelector(`.size-option[data-item="${productId}"]`) && !size) {
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Silakan pilih ukuran terlebih dahulu!', confirmButtonColor: '#d33' });
            return;
        }

        fetch("{{ route('keranjang.store') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ produk_id: productId, warna: color, ukuran: size, jumlah: quantity })
        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message ?? 'Produk berhasil ditambahkan ke keranjang.',
                showConfirmButton: false,
                timer: 1500,
                toast: true,
                position: 'top-end'
            });

            // UPDATE BADGE REAL-TIME
            refreshCartPopup();
        })
        .catch(err => {
            console.error(err);
            Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan!', text: 'Gagal menambahkan produk ke keranjang.', confirmButtonColor: '#d33' });
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
            setTimeout(() => badge.classList.remove('animate-bounce'), 300);
        } else {
            badge.classList.add('hidden');
        }
    }

    // =============================
    // SYNC CHECKOUT
    // =============================
    function syncCheckout(productId) {
        const color = document.getElementById(`selectedColor-${productId}`)?.value;
        const size = document.getElementById(`selectedSize-${productId}`)?.value;
        const quantity = document.getElementById(`qty-${productId}`).value;

        if (document.querySelector(`.color-option[data-item="${productId}"]`) && !color) {
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Pilih warna terlebih dahulu!', confirmButtonColor: '#d33' });
            return false;
        }

        if (document.querySelector(`.size-option[data-item="${productId}"]`) && !size) {
            Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Pilih ukuran terlebih dahulu!', confirmButtonColor: '#d33' });
            return false;
        }

        document.getElementById(`checkoutColor-${productId}`).value = color;
        document.getElementById(`checkoutSize-${productId}`).value = size;
        document.getElementById(`checkoutQty-${productId}`).value = quantity;
        return true;
    }

    // =============================
    // REVIEW FILTERING
    // =============================
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-star');
        const ulasanCards = document.querySelectorAll('.ulasan-card');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const rating = this.getAttribute('data-star');
                document.querySelectorAll('.filter-star').forEach(b => {
                    b.classList.remove('bg-gray-900', 'text-white');
                    b.classList.add('bg-gray-100', 'text-gray-700');
                });
                this.classList.remove('bg-gray-100', 'text-gray-700');
                this.classList.add('bg-gray-900', 'text-white');

                ulasanCards.forEach(card => {
                    if (rating === 'all' || card.getAttribute('data-rating') === rating) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') closeModal();
        });
    });
</script>

@endpush