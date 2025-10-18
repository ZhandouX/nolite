{{-- CART MODAL --}}
<div id="productModal-{{ $item->id }}"
    class="z-[9999] fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">

        {{-- CLOSE --}}
        <button type="button" onclick="closeModal('productModal-{{ $item->id }}')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

        {{-- CARD PRODUK --}}
        <div class="flex items-center gap-4 mt-5 mb-5 rounded-xl bg-gray-100 p-2">
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

        {{-- FORM KERANJANG --}}
        <div class="space-y-4">
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

                <input type="hidden" name="warna" id="selectedColor-cart-{{ $item->id }}"
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

                <input type="hidden" name="ukuran" id="selectedSize-cart-{{ $item->id }}"
                    value="{{ $item->ukuran[0] ?? '' }}">
            </div>

            {{-- SUBTOTAL PRODUCT --}}
            <div class="flex flex-col items-center space-y-3 py-4 border-t border-gray-200">
                <label class="text-sm font-semibold text-gray-800 text-left w-full">Jumlah</label>

                <div class="flex items-center justify-center space-x-4">
                    {{-- BUTTON ( - ) --}}
                    <button type="button" onclick="decrementQty({{ $item->id }})"
                        class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-500 bg-white hover:bg-gray-100 active:scale-95 transition-all duration-200 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </button>

                    {{-- INPUT SUBTOTAL --}}
                    <input type="number" id="qty-{{ $item->id }}" min="1" max="{{ $item->jumlah }}" value="1"
                        onchange="validateQty({{ $item->id }})"
                        class="w-10 text-center text-lg font-bold text-gray-900 focus:outline-none border-none bg-transparent select-none"
                        readonly>

                    {{-- BUTTON ( + ) --}}
                    <button type="button" onclick="incrementQty({{ $item->id }})"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-400 text-white hover:bg-gray-500 active:scale-95 transition-all duration-200 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>

                {{-- STOK --}}
                <p class="text-xs text-gray-500 text-center">
                    Stok tersedia: {{ $item->jumlah }}
                </p>
            </div>

            {{-- BUTTON TAMBAH KE KERANJANG --}}
            <button type="button" onclick="addToCart('{{ $item->id }}')"
                class="w-full bg-gray-600 hover:bg-gray-400 text-white font-semibold py-2 rounded-lg transition">
                Tambahkan ke Keranjang
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
