<section id="panel-all" class="product-section py-10 bg-gradient-to-b from-white to-gray-50 tab-panel block">
    <div class="container mx-auto px-4 md:px-10 md:py-10">
        <div
            class="product-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-x-4 gap-y-4 md:px-10 md-gap-y-6 md:gap-y-6 justify-items-center">
            @forelse($produk as $item)
                <div class="group product-cards w-[300px] bg-white rounded-lg overflow-hidden border border-gray-300 shadow-sm"
                    data-id="{{ $item->id }}" data-nama="{{ $item->nama_produk }}" data-harga="{{ $item->harga }}"
                    data-foto="{{ $item->fotos->isNotEmpty() ? asset('storage/' . $item->fotos->first()->foto) : asset('assets/images/no-image.png') }}"
                    data-category="{{ $item->kategori ?? 'umum' }}">

                    {{-- PRODUCT IMAGES --}}
                    <a href="{{ route('produk.detail', $item->id) }}"
                        class="block w-full overflow-hidden bg-gray-50">
                        @if($item->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                class="w-full h-72 object-contain group-hover:scale-110 transition-transform duration-500">
                        @endif
                    </a>

                    <div class="flex flex-col gap-0 md:gap-2">
                        <h3 class="text-xl font-bold text-gray-900 line-clamp-1 text-center mt-1 pl-2 pr-2">{{ $item->nama_produk }}
                        </h3>

                        {{-- HARGA --}}
                        @if($item->diskon && $item->diskon > 0)
                            @php
                                $hargaDiskon = $item->harga - ($item->harga * $item->diskon / 100);
                            @endphp
                            <div class="flex justify-center items-center gap-0">
                                <p class="text-lg text-gray-400 line-through">
                                    IDR {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                                <p class="text-lg text-red-800 font-bold">
                                    IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                </p>
                            </div>
                        @else
                            <p class="text-lg text-black font-bold text-center">
                                IDR {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        @endif

                        <div class="flex gap-1 md:gap-2 w-full -mt-[5px] md:mt-[1px] p-4 justify-center">
                            {{-- CART --}}
                            <button
                                class="bg-gray-600 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0"
                                onclick="openModal('productModal-{{ $item->id }}')" title="Tambah ke Keranjang">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </button>

                            {{-- BUY --}}
                            <button
                                class="bg-gray-700 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center"
                                onclick="openModal('productBeliModal-{{ $item->id }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span> Beli</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- MODAL BELI --}}
                @include('layouts.partials_user.modal-beli', ['item' => $item])

                {{-- CART MODAL --}}
                @include('layouts.partials_user.modal-cart', ['item' => $item])

            @empty
                <div class="col-span-3 text-center py-16">
                    <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
                </div>
            @endforelse
        </div>
    </div>
</section>