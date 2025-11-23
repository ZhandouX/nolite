@extends('layouts.user_app')

@section('content')
    <div class="container mx-auto px-4 lg:px-10 py-8 pt-[70px] lg:pt-9">

        <div class="flex flex-col md:flex-row gap-8">

            {{-- SIDEBAR FILTER DESKTOP --}}
            <aside class="hidden lg:block w-full lg:w-1/4 bg-white border border-gray-200 rounded-lg p-4">
                @include('layouts.partials_user._filter-form')
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="w-full llg:w-3/4 flex flex-col gap-6">

                {{-- JUDUL HALAMAN --}}
                <h1 class="text-2xl lg:text-4xl montserrat font-bold text-gray-900 text-center mt-3 lg:mt-0">
                    Semua Produk
                </h1>

                {{-- FILTER & SORT BUTTONS MOBILE (Bawah Judul) --}}
                <div class="flex gap-2 justify-between lg:hidden">
                    {{-- FILTER BUTTON MOBILE --}}
                    <button id="mobileOpenFilterBtn"
                        class="flex-1 flex items-center justify-center gap-2 border border-gray-700 text-gray-700 bg-transparent rounded-lg px-4 py-2 hover:bg-gray-600 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M4 8h16l-6 8v4l-4-2v-2l-6-8z" />
                        </svg>
                        Filter
                    </button>

                    {{-- SORT BUTTON MOBILE --}}
                    <button id="openSortBtn"
                        class="flex-1 flex items-center justify-center gap-2 border border-gray-700 text-gray-700 bg-transparent rounded-lg px-4 py-2 hover:bg-gray-600 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h12M3 18h6" />
                        </svg>
                        Urutkan
                    </button>
                </div>

                {{-- SORT DROPDOWN DESKTOP --}}
                <div class="hidden lg:flex justify-end mb-2">
                    <div class="relative">
                        <button id="sortDropdownBtn"
                            class="flex items-center justify-center gap-2 border border-gray-700 text-gray-700 bg-transparent rounded-lg px-6 py-2 hover:bg-gray-600 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M3 12h12M3 18h6" />
                            </svg>
                            Urutkan
                        </button>
                        <div id="sortDropdownMenu"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden z-50">
                            <form method="GET" action="{{ route('customer.allProduk') }}" class="flex flex-col">
                                <button type="submit" name="sort" value="harga_terendah"
                                    class="text-left px-4 py-2 hover:bg-gray-100 transition">Harga Terendah</button>
                                <button type="submit" name="sort" value="harga_tertinggi"
                                    class="text-left px-4 py-2 hover:bg-gray-100 transition">Harga Tertinggi</button>
                                <button type="submit" name="sort" value="nama_az"
                                    class="text-left px-4 py-2 hover:bg-gray-100 transition">Nama (A–Z)</button>
                                <button type="submit" name="sort" value="nama_za"
                                    class="text-left px-4 py-2 hover:bg-gray-100 transition">Nama (Z–A)</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- FILTER MODAL MOBILE --}}
                <div id="mobileFilterModal"
                    class="z-[9999] fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-sm relative">
                        <button id="closeMobileFilterBtn"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                        @include('layouts.partials_user._filter-form')
                    </div>
                </div>

                {{-- SORT MODAL MOBILE --}}
                <div id="sortModal"
                    class="z-[9999] fixed inset-0 bg-black/50 hidden flex items-center justify-center lg:hidden backdrop-blur-sm">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-sm relative">
                        <button id="closeSortModal"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                        <h2 class="text-xl font-bold mb-4">Urutkan Produk</h2>
                        <form method="GET" action="{{ route('customer.allProduk') }}" class="flex flex-col gap-3">
                            <button type="submit" name="sort" value="harga_terendah"
                                class="text-left px-4 py-2 rounded hover:bg-gray-100 transition">Harga Terendah</button>
                            <button type="submit" name="sort" value="harga_tertinggi"
                                class="text-left px-4 py-2 rounded hover:bg-gray-100 transition">Harga Tertinggi</button>
                            <button type="submit" name="sort" value="nama_az"
                                class="text-left px-4 py-2 rounded hover:bg-gray-100 transition">Nama (A–Z)</button>
                            <button type="submit" name="sort" value="nama_za"
                                class="text-left px-4 py-2 rounded hover:bg-gray-100 transition">Nama (Z–A)</button>
                        </form>
                    </div>
                </div>

                @if($produks->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 col-span-2 md:col-span-3">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v1M9 7h6">
                            </path>
                        </svg>
                        <p class="text-gray-500 text-lg text-center">Belum ada produk.</p>
                    </div>
                @else
                    {{-- PRODUK GRID --}}
                    <div
                        class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
                        @forelse($produks as $item)
                            <div class="group bg-white rounded-lg overflow-hidden border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all duration-300 flex flex-col h-full"
                                data-id="{{ $item->id }}">

                                {{-- GAMBAR PRODUK --}}
                                <div class="relative overflow-hidden bg-gray-50">
                                    <a href="{{ route('produk.detail', $item->id) }}" class="block aspect-square relative">
                                        @if($item->fotos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}"
                                                alt="{{ $item->nama_produk }}"
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

                                    {{-- BADGE DISKON --}}
                                    @if($item->diskon && $item->diskon > 0)
                                        <div
                                            class="absolute top-0 right-0 bg-red-500 text-white text-[10px] sm:text-xs font-bold px-1.5 py-0.5 rounded-bl-lg">
                                            {{ $item->diskon }}%
                                        </div>
                                    @endif
                                </div>

                                {{-- DETAIL PRODUK --}}
                                <div class="p-2 sm:p-2.5 flex flex-col gap-1 sm:gap-1.5 flex-grow">
                                    {{-- NAMA PRODUK --}}
                                    <a href="{{ route('produk.detail', $item->id) }}" class="block">
                                        <h3
                                            class="font-semibold montserrat text-left text-xs sm:text-sm md:text-sm lg:text-sm text-gray-800 group-hover:text-gray-900 line-clamp-2 leading-snug h-8 sm:h-10 overflow-hidden">
                                            {{ $item->nama_produk }}
                                        </h3>
                                    </a>

                                    {{-- HARGA PRODUK --}}
                                    <div class="h-5 sm:h-6 flex items-center gap-1.5">
                                        @if ($item->has_diskon)
                                            <div class="flex items-baseline gap-0">
                                                <span class="text-xs md:text-sm font-medium text-gray-500">
                                                    Rp
                                                </span>
                                                <span class="text-sm md:text-xl font-bold text-red-900 truncate">
                                                    {{ $item->harga_diskon }}
                                                </span>
                                            </div>
                                            <p class="text-[10px] sm:text-xs text-gray-400 line-through flex-shrink-0 truncate">
                                                Rp{{ $item->harga_format }}
                                            </p>
                                        @else
                                            <div class="flex items-baseline gap-0">
                                                <span class="text-xs md:text-sm font-medium text-gray-500">
                                                    Rp
                                                </span>
                                                <span class="text-sm md:text-xl font-bold text-gray-900 truncate">
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
                                                    <i class="mdi mdi-star text-sm md:text-lg text-amber-400 fill-current"></i>
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
                                            class="flex-1 border-2 border-gray-600 text-gray-600 hover:bg-gray-600 hover:text-white p-1.5 sm:p-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-1 text-[10px] md:text-xs lg:text-base font-medium"
                                            onclick="openModal('productModal-{{ $item->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="hidden md:inline">Keranjang</span>
                                        </button>

                                        <button
                                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white p-1.5 sm:p-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-1 text-[10px] md:text-xs lg:text-base font-medium"
                                            onclick="openModal('productBeliModal-{{ $item->id }}')">
                                            <i data-lucide="handbag" class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0"></i>
                                            <span>Beli</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-2 md:col-span-3 text-center">Produk tidak ditemukan.</p>
                        @endforelse
                    </div>
                @endif
            </main>
        </div>
    </div>
@endsection