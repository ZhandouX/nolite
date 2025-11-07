<section id="panel-all" class="product-section bg-gradient-to-b from-white to-gray-50 tab-panel block">
    <div class="container mx-auto px-0 py-0 md:px-10 md:py-10">
        <div class="product-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-x-6 gap-y-4 md:px-10 md:gap-x-6 md:gap-y-6 justify-items-center">
            @forelse($produk as $item)
                <div class="group product-cards w-[300px] bg-white rounded-xl overflow-hidden border border-gray-300 shadow-sm relative">

                    {{-- BADGE DISKON --}}
                    @if($item->diskon && $item->diskon > 0)
                        <div class="absolute top-1 right-1 bg-red-500 text-white text-[10px] md:text-sm font-bold px-3 py-1 rounded-full z-10">
                            DISKON -{{ $item->diskon }}%
                        </div>
                    @endif

                    {{-- IMAGE --}}
                    <a href="{{ route('produk.detail', $item->id) }}" class="block overflow-hidden rounded-t-2xl bg-gray-50">
                        @if($item->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </a>

                    {{-- INFO PRODUK --}}
                    <div class="flex flex-col gap-0 md:gap-2">
                        <h3 class="text-sm md:text-xl font-bold text-gray-900 line-clamp-1 text-center">{{ $item->nama_produk }}</h3>

                        {{-- HARGA --}}
                        <div class="flex justify-center items-center gap-1 md:gap-2 mt-1">
                            @php
                                $hargaDiskon = ($item->diskon && $item->diskon > 0) ? $item->harga - ($item->harga * $item->diskon / 100) : $item->harga;
                            @endphp

                            @if($item->diskon && $item->diskon > 0)
                                <p class="text-[12px] md:text-sm text-gray-500 line-through text-center truncate">
                                    IDR {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-[12px] md:text-lg text-red-800 font-bold text-center truncate">
                                    IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="text-[12px] md:text-lg text-black font-bold text-center truncate">
                                    IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>

                        {{-- BUTTONS --}}
                        <div class="flex gap-1 md:gap-2 p-3 md:p-4">
                            <button onclick="openModal('productModal-{{ $item->id }}')"
                                class="bg-gray-700 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </button>

                            <button onclick="openModal('productBeliModal-{{ $item->id }}')"
                                class="bg-gray-700 text-white px-6 py-2 md:px-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0">
                                Beli
                            </button>
                        </div>
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
