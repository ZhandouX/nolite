<div class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300 z-[60]" id="variationOverlay"></div>
<div class="fixed bottom-0 left-0 right-0 bg-white max-h-[80vh] overflow-y-auto z-[120] translate-y-full transition-transform duration-300 ease-in-out"
    id="variationModal">
    <div
        class="sticky top-0 z-[10] max-h-6 overflow-y-hidden w-full bg-white border-b-2 border-gray-300 hover:border-white flex justify-center items-center transition-colors duration-200">
        <button type="button" onclick="closeVariationModal()"
            class="flex bg-gray-300 text-gray-500 hover:text-gray-700 hover:bg-white w-full py-2 items-center justify-center transition-colors duration-200">
            <i data-lucide="chevrons-down" class="w-5 h-5 text-gray-700 text-center"></i>
        </button>
    </div>

    <div class="p-6 space-y-6 ">
        {{-- PRODUCT PREVIEW SECTION --}}
        <div class="flex gap-4 pb-4 border-b border-gray-100">
            {{-- GAMBAR PRODUK --}}
            <div class="relative flex-shrink-0">
                @if($produk->fotos->isNotEmpty())
                    <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}" alt="{{ $produk->nama_produk }}"
                        class="w-[160px] h-[160px] object-cover rounded-lg border border-gray-200"
                        onclick="openProductModal(0)" />
                @else
                    <img src="{{ asset('assets/images/no-image.png') }}" alt="No Image"
                        class="w-28 h-28 object-cover rounded-lg border border-gray-200">
                @endif
                <button type="button" onclick="openProductModal(0)"
                    class="absolute flex top-1 right-1 bg-black/30 rounded-lg items-center justify-center w-7 h-7">
                    <i data-lucide="maximize-2" class="w-4 h-4 text-white"></i>
                </button>
            </div>

            {{-- INFORMASI PRODUK --}}
            <div class="flex-grow">
                <h4 class="montserrat font-semibold text-gray-900 text-sm line-clamp-2">{{ $produk->nama_produk }}</h4>

                {{-- HARGA --}}
                <div class="mt-1">
                    @if ($produk->has_diskon)
                        <div class="flex items-baseline gap-2">
                            <div class="flex items-baseline gap-0">
                                <span class="text-sm font-medium text-gray-500">Rp</span>
                                <span class="text-lg font-bold text-red-900">{{ $produk->harga_diskon }}</span>
                            </div>
                            <span class="text-sm text-gray-500 line-through">Rp{{ $produk->harga_format }}</span>
                            <span class="rounded-xl bg-red-500 text-white font-semibold text-xs py-1 px-2">
                                {{ $produk->diskon }}%
                            </span>
                        </div>
                    @else
                        <div class="flex items-baseline gap-0">
                            <span class="text-sm font-medium text-gray-500">Rp</span>
                            <span class="text-lg font-bold text-gray-900">{{ $produk->harga_format }}</span>
                        </div>
                    @endif
                </div>

                {{-- STOK --}}
                <p class="text-sm text-gray-500 mt-1">Stok: {{ $produk->jumlah }}</p>
            </div>
        </div>
        {{-- COLOR SELECTION --}}
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
                    <span class="text-sm text-gray-500" id="mobileSelectedColorText-{{ $produk->id }}">Pilih warna</span>
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
                                style="--color-hover: {{ $colorCode }}; --color-selected: {{ $colorCode }}" data-color="{{ $w }}"
                                data-item="{{ $produk->id }}" data-color-lower="{{ $warnaLower }}"
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
                    <span class="text-sm text-gray-500" id="mobileSelectedSizeText-{{ $produk->id }}">
                        {{ $produk->ukuran[0] ?? 'Pilih ukuran' }}
                    </span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($produk->ukuran as $u)
                        <button type="button" class="option-chip" data-size="{{ $u }}" data-item="{{ $produk->id }}"
                            onclick="selectSize(this, '{{ $u }}', '{{ $produk->id }}')">
                            {{ $u }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="ukuran" id="selectedSize-{{ $produk->id }}"
                    value="{{ $produk->ukuran[0] ?? '' }}">
            </div>
        @endif

        {{-- QUANTITY SELECTOR --}}
        <div class="border-t border-gray-400/50 pt-4 pb-20 items-center justify-center">
            <label class="block text-center text-sm font-medium text-gray-700 mb-3">Jumlah</label>
            <div class="flex items-center justify-center gap-2 w-full">
                <button type="button" onclick="detailDecrementQty({{ $produk->id }})"
                    class="qty-btn flex w-10 h-10 items-center justify-center border border-gray-400 bg-white hover:text-gray-400 hover:border-gray-400 rounded-full cursor-pointer transition-all duration-200"
                    id="decrementBtn-{{ $produk->id }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </button>

                <input type="number" id="mobileQty-{{ $produk->id }}" min="1" max="{{ $produk->jumlah }}" value="1"
                    class="w-12 h-8 text-center rounded-full text-sm font-medium text-gray-900"
                    onchange="detailValidateQty({{ $produk->id }})">

                <button type="button" onclick="detailIncrementQty({{ $produk->id }})"
                    class="qty-btn flex w-10 h-10 items-center justify-center border text-white border-gray-400 bg-gray-400 hover:text-gray-400 hover:border-gray-400 rounded-full cursor-pointer transition-all duration-200"
                    id="incrementBtn-{{ $produk->id }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>