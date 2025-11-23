<div id="productBeliModal-{{ $item->id }}"
    class="z-[9999] fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-[340px] md:max-w-md p-6 relative">

       {{-- CLOSE --}}
        <button type="button" onclick="closeModal('productBeliModal-{{ $item->id }}')"
            class="absolute w-8 h-8 md:w-10 md:h-10 rounded-full -top-2 -right-2 md:-top-4 md:-right-4 bg-red-900 text-gray-50 hover:bg-red-700 hover:text-gray-50">
                <i class="fa-solid fa-xmark text-[16px] md:text-xl"></i>
        </button>

        {{-- CARD PRODUK --}}
        <div class="flex items-start gap-4 mt-5 mb-5 rounded-xl bg-gray-100 p-2">
            <div class="relative w-20 h-20">
                @if($item->fotos->isNotEmpty())
                    <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}"
                        alt="{{ $item->nama_produk }}"
                        class="w-full h-full object-contain rounded-xl">
                @else
                    <img src="{{ asset('assets/images/no-image.png') }}"
                        alt="No Image"
                        class="w-full h-full object-contain rounded-xl">
                @endif

                @if($item->diskon && $item->diskon > 0)
                    <span class="absolute top-0 right-0 px-1 text-xs bg-red-500 text-white rounded-lg">
                        {{ $item->diskon }}%
                    </span>
                @endif
            </div>

            <div>
                <p class="montserrat text-left text-[14px] md:text-lg font-semibold text-black line-clamp-2">
                    {{ $item->nama_produk }}
                </p>

                <div class="py-0">
                    @if($item->diskon && $item->diskon > 0)
                        @php
                            $hargaDiskon = $item->harga - ($item->harga * $item->diskon / 100);
                        @endphp
                        <div class="flex flex-col items-start gap-0">
                            <p class="flex items-baseline gap-0">
                                <span class="text-xs font-medium text-gray-500">
                                    Rp
                                </span>
                                <span class="text-lg md:text-base font-bold text-red-900">
                                    {{ number_format($hargaDiskon, 0, ',', '.') }}
                                </span>
                                <span class="ml-2 px-1 text-xs text-gray-500 line-through">
                                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                                </span>
                            </p>
                        </div>
                    @else
                        <p class="flex items-baseline gap-0 text-left text-black font-bold">
                            <span class="text-xs font-medium text-gray-500">
                                Rp
                            </span>
                            <span class="text-lg font-bold text-gray-900">
                                {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </p>
                    @endif
                </div>
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
                    <p class="font-semibold mb-2">Warna</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach ($item->warna as $w)
                        <button type="button"
                            class="color-btn px-3 py-1 rounded border border-gray-300 text-sm hover:border-blue-600 transition"
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
                    <p class="font-semibold mb-2">Ukuran</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach ($item->ukuran as $u)
                        <button type="button"
                            class="size-btn px-3 py-1 rounded border border-gray-300 text-sm hover:border-blue-600 transition"
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
                <label class="text-sm font-semibold text-gray-800 text-center">Jumlah</label>

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

                <p class="text-xs text-gray-500 text-center">Stok: <span class="font-bold">{{ $item->jumlah }}</span></p>
            </div>

            {{-- TOMBOL BELI --}}
            @auth
                <button type="submit"
                    class="w-full bg-gray-600 hover:bg-gray-400 text-white font-semibold py-2 rounded-lg transition">
                    Beli Sekarang
                </button>
            @else
                <button type="button" onclick="openLoginModal()"
                    class="w-full bg-gray-600 hover:bg-gray-400 text-white font-semibold py-2 rounded-lg transition">
                    Beli Sekarang
                </button>
            @endauth
        </form>
    </div>
</div>

<script src="/assets/js/user/modals/checkout.js"></script>