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
        @php
            $adaDiskon = $item->diskon && $item->diskon > 0;
            $hargaDiskon = $adaDiskon ? $item->harga - ($item->harga * $item->diskon / 100) : null;
        @endphp

        <div class="h-5 sm:h-6 flex items-center gap-1.5">
            @if($adaDiskon)
                <p class="text-xs sm:text-sm lg:text-base font-bold text-red-900 truncate">
                    Rp{{ number_format($hargaDiskon, 0, ',', '.') }}
                </p>
                <p class="text-[10px] sm:text-xs text-gray-400 line-through truncate flex-shrink-0">
                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                </p>
            @else
                <p class="text-xs sm:text-sm lg:text-base font-bold text-gray-900 truncate">
                    Rp{{ number_format($item->harga, 0, ',', '.') }}
                </p>
            @endif
        </div>

        {{-- RATING & TERJUAL --}}
        <div class="flex items-center gap-2 text-[10px] sm:text-xs text-gray-500">
            <div class="flex items-center gap-1">
                @if($item->total_ulasan > 0)
                    <div class="flex items-center gap-0.5">
                        <svg class="w-3.5 h-3.5 text-amber-400 fill-current" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <span class="text-gray-700 text-xs md:text-sm">
                            {{ number_format($item->average_rating, 1) }}
                        </span>
                        <span class="text-gray-400 text-xs md:text-sm">
                            ({{ $item->total_ulasan }})
                        </span>
                    </div>
                @else
                    <span class="text-gray-400 text-xs italic">Belum ada penilaian</span>
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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Beli</span>
            </button>
        </div>
    </div>
</div>

{{-- MODAL BELI & KERANJANG --}}
@include('layouts.partials_user.modal-beli', ['item' => $item])
@include('layouts.partials_user.modal-cart', ['item' => $item])