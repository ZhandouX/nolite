<!-- Wishlist Content -->
<div id="wishlist" class="tab-content hidden text-gray-700">
    @if($wishlists->isEmpty())
        <div class="text-center text-gray-500 py-10">
            <i class="fa-solid fa-heart mb-3 opacity-70 text-red-500 text-5xl"></i>
            <p class="text-base">Tidak ada produk dalam Wishlist</p>
            <small class="block text-sm mb-3">
                Tambahkan produk ke wishlist Anda untuk melihatnya di sini.
            </small>
            <a href="{{ route('customer.allProduk') }}"
                class="inline-block px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-700 transition font-medium">
                Telusuri Produk
            </a>
        </div>
    @else
        <!-- Scrollable Wishlist Grid -->
        <div class="max-h-[480px] overflow-y-auto pr-2">
            <div id="wishlist-grid"
                class="product-grid grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5 md:gap-6 justify-items-center px-2 sm:px-4">

                @foreach($wishlists as $item)
                    <div id="wishlist-item-{{ $item->id }}"
                        class="w-full max-w-[180px] sm:max-w-[200px] md:max-w-[220px] bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative">

                        {{-- Gambar produk --}}
                        <div class="relative">
                            <a href="{{ route('produk.detail', $item->produk->id) }}" class="block">
                                @if($item->produk->fotos->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->produk->fotos->first()->foto) }}"
                                        alt="{{ $item->produk->nama_produk }}"
                                        class="w-full h-40 sm:h-44 md:h-48 object-cover group-hover:scale-105 transition-transform duration-300 rounded-t-2xl">
                                @else
                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                        class="w-full h-40 sm:h-44 md:h-48 object-contain p-4 rounded-t-2xl">
                                @endif
                            </a>

                            {{-- Tombol hapus wishlist --}}
                            <button type="button" data-id="{{ $item->id }}"
                                class="remove-wishlist absolute bottom-2 right-2 w-8 h-8 flex items-center justify-center bg-white/80 backdrop-blur-sm rounded-full shadow hover:scale-110 transition duration-200">
                                <i class="fa-solid fa-heart text-red-500 text-lg"></i>
                            </button>
                        </div>

                        {{-- Info produk --}}
                        <div class="p-2 sm:p-3 text-center">
                            <h3
                                class="font-semibold montserrat text-gray-800 text-xs sm:text-sm truncate leading-tight group-hover:text-red-800 transition-colors">
                                {{ $item->produk->nama_produk }}
                            </h3>
                            
                            {{-- HARGA --}}
                            <div class="h-5 sm:h-6 flex items-center gap-1.5">
                                @if ($item->produk->has_diskon)
                                    <div class="flex items-baseline gap-0 md:gap-1">
                                        <span class="text-xs md:text-sm font-medium text-gray-500">
                                            Rp
                                        </span>
                                        <span class="text-sm md:text-xl font-bold text-red-900 truncate">
                                            {{ $item->produk->harga_diskon }}
                                        </span>
                                    </div>
                                    <p class="flex-shrink-0 text-[10px] sm:text-xs text-gray-400 line-through truncate">
                                        {{ $item->produk->harga_format }}
                                    </p>
                                @else
                                    <div class="flex items-baseline gap-0 md:gap-1">
                                        <span class="text-xs md:text-sm font-medium text-gray-500">
                                            Rp
                                        </span>
                                        <span class="text-sm md:text-xl font-bold text-gray-900 truncate">
                                            {{ $item->produk->harga_format }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endif
</div>