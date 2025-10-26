<div id="productBeliModal-{{ $item->id }}"
    class="z-[9999] fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
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

                @php
                    $diskon = $item->diskon ?? 0;
                    $hargaFinal = $diskon > 0 ? $item->harga - ($item->harga * $diskon / 100) : $item->harga;
                @endphp

                @if($diskon > 0)
                    <div class="flex items-center gap-2">
                        <p class="line-through text-gray-400 font-semibold">
                            IDR {{ number_format($item->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-red-800 font-bold">
                            IDR {{ number_format($hargaFinal, 0, ',', '.') }}
                        </p>
                    </div>
                @else
                    <p class="text-black font-bold">IDR {{ number_format($hargaFinal, 0, ',', '.') }}</p>
                @endif
            </div>
        </div>

        {{-- FORM PEMBELIAN --}}
        <form id="formBeli-{{ $item->id }}" action="{{ route('customer.checkout.dashboard') }}" method="POST"
            class="space-y-4">
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

            {{-- JUMLAH PRODUK --}}
            <div class="flex flex-col space-y-3 border-t border-gray-200 pt-4">
                <label class="text-sm font-semibold text-gray-800 text-left">Jumlah</label>

                <div class="flex items-center justify-center gap-6">
                    <button type="button" onclick="updateQty(this, -1)"
                        class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 bg-white hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                        </svg>
                    </button>

                    <input type="number" name="jumlah" id="buyQty-{{ $item->id }}" value="1" min="1"
                        max="{{ $item->jumlah }}" onchange="validateQty(this)"
                        class="w-10 text-center text-lg font-bold text-gray-900 focus:outline-none border-none bg-transparent select-none"
                        readonly>

                    <button type="button" onclick="updateQty(this, 1)"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-400 text-white hover:bg-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>

                <p class="text-xs text-gray-500 text-center">Stok tersedia: {{ $item->jumlah }}</p>
            </div>

            {{-- TOMBOL BELI --}}
            <button type="submit"
                class="w-full bg-gray-600 hover:bg-gray-400 text-white font-semibold py-2 rounded-lg transition">
                Beli Sekarang
            </button>
        </form>
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