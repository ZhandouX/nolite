@extends('layouts.user_app')

@section('content')
    <div class="container mx-auto px-4 lg:px-10 py-8 pt-[70px] lg:pt-9">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- SIDEBAR FILTER (DESKTOP) --}}
            <aside class="hidden lg:block w-full md:w-1/4 bg-white border border-gray-200 rounded-lg p-4">
                @include('layouts.partials_user._filter-form')
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="w-full lg:w-3/4 flex flex-col gap-6">
                {{-- BANNER --}}
                <div class="banner-container">
                    <img src="{{ asset('assets/images/banner/tshirt.jpeg') }}" alt="">
                    <div class="banner-overlay">
                        <h1>Produk Terlaris</h1>
                    </div>
                </div>

                {{-- FILTER & SORT --}}
                <div class="flex gap-2 mb-0 justify-between lg:hidden">
                    {{-- FILTER (MOBILE) --}}
                    <button id="mobileOpenFilterBtn"
                        class="flex flex-1 items-center justify-center gap-2 border border-gray-700 bg-transparent rounded-lg px-4 py-2 hover:bg-gray-600 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M4 8h16l-6 8v4l-4-2v-2l-6-8z" />
                        </svg>
                        Filter
                    </button>

                    {{-- SORT (MOBILE) --}}
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
                            <form method="GET" action="{{ route('customer.unggulan') }}" class="flex flex-col">
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

                {{-- FILTER MODAL (MOBILE) --}}
                <div id="mobileFilterModal"
                    class="z-[9999] fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-sm relative">
                        <button id="closeMobileFilterBtn"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                        @include('layouts.partials_user._filter-form')
                    </div>
                </div>

                {{-- SORT MODAL (MOBILE) --}}
                <div id="sortModal"
                    class="z-[9999] fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center lg:hidden backdrop-blur-sm">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-sm relative">
                        <button id="closeSortModal"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                        <h2 class="text-xl font-bold mb-4">Urutkan Produk</h2>
                        <form method="GET" action="{{ route('customer.unggulan') }}" class="flex flex-col gap-3">
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
                        <p class="text-gray-500 text-lg text-center">Belum ada produk terlaris.</p>
                    </div>
                @else
                    {{-- PRODUK GRID --}}
                    <div
                        class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
                        @foreach($produks as $item)
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
                                            class="text-xs font-semibold montserrat sm:text-sm text-gray-800 group-hover:text-gray-900 line-clamp-2 leading-snug h-8 sm:h-10 overflow-hidden">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="hidden sm:inline">Keranjang</span>
                                        </button>

                                        <button
                                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white p-1.5 sm:p-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-1 text-[10px] sm:text-xs font-medium"
                                            onclick="openModal('productBeliModal-{{ $item->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <span>Beli</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal untuk Beli & Cart --}}
                            @include('layouts.partials_user.modal-beli', ['item' => $item])
                            @include('layouts.partials_user.modal-cart', ['item' => $item])
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-center">
                        {{ $produks->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('#filterTipeForm input[name="tipe"]');
            radios.forEach(radio => {
                radio.addEventListener('change', () => {
                    switch (radio.value) {
                        case 'all':
                            window.location.href = "{{ route('customer.allProduk') }}";
                            break;
                        case 'unggulan':
                            window.location.href = "{{ route('customer.unggulan') }}";
                            break;
                        case 'diskon':
                            window.location.href = "{{ route('customer.diskon') }}";
                            break;
                    }
                });
            });
        });
    </script>
@endpush