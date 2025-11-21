<div class="group bg-white rounded-lg overflow-hidden border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all duration-300 flex flex-col h-full"
    data-id="{{ $item->id }}" data-nama="{{ $item->nama_produk }}" data-harga="{{ $item->harga }}"
    data-foto="{{ $item->fotos->isNotEmpty() ? asset('storage/' . $item->fotos->first()->foto) : asset('assets/images/no-image.png') }}">

    {{-- GAMBAR PRODUK --}}
    <div class="relative overflow-hidden bg-gray-50">
        <a href="{{ route('produk.detail', $item->id) }}" class="block aspect-square relative">
            @if($item->fotos->isNotEmpty())
                <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            @endif
        </a>

        {{-- BUTTON WISHLIST --}}
        @auth
            <button type="button" onclick="toggleWishlist('{{ $item->id }}')"
                class="absolute bottom-2 right-2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-black/40 backdrop-blur-sm rounded-full shadow hover:scale-110 transition duration-200">
                <svg id="heart-icon-{{ $item->id }}"
                    class="w-5 h-5 md:w-7 md:h-7 text-gray-300 transition-colors duration-300 {{ in_array($item->id, $wishlistIds ?? []) ? 'text-red-500 fill-red-500' : 'text-gray-300 fill-none' }}"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </button>
        @else
            <button type="button" onclick="openLoginModal()"
                class="absolute bottom-2 right-2 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-black/40 backdrop-blur-sm rounded-full shadow hover:scale-110 transition duration-200">
                <svg class="w-5 h-5 md:w-7 md:h-7 transition-colors duration-300 text-gray-300 fill-none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </button>
        @endauth

        {{-- BADGE DISKON - Pojok Kanan Atas --}}
        @if($item->diskon && $item->diskon > 0)
            <div
                class="absolute top-0 right-0 bg-red-500 text-white text-[10px] sm:text-xs font-bold px-1.5 py-0.5 rounded-bl-lg">
                {{ $item->diskon }}%
            </div>
        @endif
    </div>

    {{-- DETAIL PRODUK --}}
    <div class="p-2 sm:p-2.5 flex flex-col gap-1 sm:gap-1.5 flex-grow">
        {{-- NAMA PRODUK - Fixed Height --}}
        <a href="{{ route('produk.detail', $item->id) }}" class="block">
            <h3
                class="font-semibold montserrat text-xs sm:text-sm text-gray-800 group-hover:text-gray-900 line-clamp-2 leading-snug h-8 sm:h-10 overflow-hidden">
                {{ $item->nama_produk }}
            </h3>
        </a>

        {{-- HARGA PRODUK - Fixed Height --}}
        <div class="flex h-5 sm:h-6 items-center gap-1.5">
            @if ($item->has_diskon)
                <div class="flex items-baseline gap-1">
                    <span class="text-xs md:text-sm font-medium text-gray-500">
                        Rp
                    </span>
                    <span class="text-sm md:text-xl font-bold text-red-900 truncate">
                        {{ $item->harga_diskon }}
                    </span>
                </div>
                <p class="text-[10px] sm:text-xs text-gray-400 flex-shrink-0 truncate">
                    Rp{{ $item->harga_format }}
                </p>
            @else
                <div class="flex items-baseline gap-1">
                    <span class="text-xs md:text-sm font-medium text-gray-500">
                        Rp
                    </span>
                    <span class="text-sm md:text-xl font-bold text-black truncate">
                        {{ $item->harga_format }}
                    </span>
                </div>
            @endif
        </div>

        {{-- RATING & TERJUAL --}}
        <div class="flex items-center gap-2 text-[10px] sm:text-xs text-gray-500">
            <div class="flex items-center gap-1">
                @if($item->total_ulasan > 0)
                    <div class="flex items-center gap-0.5">
                        <i class="fa-solid fa-star text-sm text-amber-400 fill-current"></i>
                        <span class="text-gray-700 text-xs md:text-sm">
                            {{ number_format($item->average_rating, 1) }}
                        </span>
                        <span class="text-gray-400 text-xs md:text-sm">
                            ({{ $item->total_ulasan }})
                        </span>
                    </div>
                @else
                    <span class="text-gray-400 text-[9px] md:text-xs italic">Belum ada penilaian</span>
                @endif
            </div>

            <span class="text-gray-300">•</span>
            <span class="text-gray-600 text-right">Terjual
                {{ number_format($item->total_terjual ?? 0) }}</span>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="flex gap-1.5 mt-auto pt-1.5">
            <button
                class="flex-1 border-2 border-gray-600 text-gray-600 hover:bg-gray-600 hover:text-white p-1.5 sm:p-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-1 text-[10px] sm:text-xs font-medium"
                onclick="openModal('productModal-{{ $item->id }}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="hidden sm:inline">Keranjang</span>
            </button>

            <button
                class="flex-1 bg-gray-600 hover:bg-gray-700 text-white p-1.5 sm:p-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-1 text-[10px] sm:text-xs font-medium"
                onclick="openModal('productBeliModal-{{ $item->id }}')">
                <i data-lucide="handbag" class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0"></i>
                <span>Beli</span>
            </button>
        </div>
    </div>
</div>