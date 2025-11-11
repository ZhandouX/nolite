<div id="productModal-{{ $item->id }}"
    class="z-[9999] fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-[340px] md:max-w-md p-6 relative">

        {{-- CLOSE --}}
        <button type="button" onclick="closeModal('productModal-{{ $item->id }}')"
            class="absolute w-8 h-8 md:w-10 md:h-10 rounded-full -top-2 -right-2 md:-top-4 md:-right-4 bg-red-900 text-gray-50 hover:bg-red-700 hover:text-gray-50">
                <i class="fa-solid fa-xmark text-[16px] md:text-xl"></i>
        </button>

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
                <p class="montserrat text-left text-[14px] md:text-lg font-semibold text-black line-clamp-2">
                    {{ $item->nama_produk }}
                </p>

                <div class="py-2">
                    @if($item->diskon && $item->diskon > 0)
                        @php
                            $hargaDiskon = $item->harga - ($item->harga * $item->diskon / 100);
                        @endphp
                        <div class="flex flex-col items-start gap-1">
                            <p class="text-[12px] md:text-sm text-gray-400 font-bold line-through">
                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-[13px] md:text-base text-red-600 font-bold">
                                Rp{{ number_format($hargaDiskon, 0, ',', '.') }}
                                <span class="text-sm text-red-500">({{ $item->diskon }}%)</span>
                            </p>
                        </div>
                    @else
                        <p class="text-left text-black font-bold">
                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                        </p>
                    @endif
                </div>
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
            <div class="flex flex-col items-center space-y-3 pt-4 border-t border-gray-200">
                <label class="text-sm font-semibold text-gray-800 text-center w-full">Jumlah:</label>

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
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeModal(id);
            });
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
    }

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

    function updateQty(btn, change) {
        const parent = btn.closest('div');
        const input = parent.querySelector('input[type="number"]');
        const max = parseInt(input.max);
        const min = parseInt(input.min);
        let value = parseInt(input.value) || 1;

        value += change;
        if (value < min) value = min;
        if (value > max) value = max;

        input.value = value;
    }

    function validateQty(input) {
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        let val = parseInt(input.value);
        if (isNaN(val) || val < min) input.value = min;
        if (val > max) input.value = max;
    }
</script>