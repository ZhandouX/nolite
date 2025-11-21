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
    <div class="section-card p-4 fade-in">
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

    {{-- VARIATION SELECTOR (MOBILE) --}}
    <div class="lg:hidden">
        <button type="button" class="variation-selector" onclick="openVariationModal()">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Pilih Varian</p>
                    <p id="selectedVariationText" class="text-sm font-medium">Warna: - | Ukuran: -</p>
                </div>
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </button>
    </div>

    {{-- PRODUCT OPTIONS (DESKTOP) --}}
    <div class="section-card p-4 space-y-6 fade-in variation-section">
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
    <div class="section-card p-4 fade-in">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Produk</h3>
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