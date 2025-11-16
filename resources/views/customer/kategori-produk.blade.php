@extends('layouts.user_app')

@section('content')
    <div class="container mx-auto px-4 lg:px-10 py-8 pt-[70px] lg:pt-9">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- SIDEBAR FILTER DESKTOP --}}
            <aside class="hidden lg:block w-full lg:w-1/4 bg-white border border-gray-200 rounded-lg p-4">
                @include('layouts.partials_user._filter-form')
            </aside>

            {{-- CONTENT --}}
            <main class="w-full lg:w-3/4 flex flex-col gap-6">

                {{-- BANNER --}}
                <div class="banner-container relative">
                    <img src="{{ $kategori->foto_sampul
                        ? asset('storage/' . $kategori->foto_sampul)
                        : asset('assets/images/banner/default.jpg') }}" alt="Banner {{ $kategori->nama_kategori }}">
                    <div class="banner-overlay absolute inset-0 flex items-center justify-center bg-black/25">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $kategori->nama_kategori }}</h1>
                    </div>
                </div>

                {{-- FILTER & SORT BUTTONS MOBILE --}}
                <div class="flex gap-2 mb-0 lg:mb-4 justify-between lg:hidden">
                    <button id="mobileOpenFilterBtn"
                        class="flex-1 flex items-center justify-center gap-2 border border-gray-700 text-gray-700 bg-transparent rounded-lg px-4 py-2 hover:bg-gray-600 hover:text-white transition">
                        <i data-lucide="funnel" class="w-5 h-5"></i>
                        Filter
                    </button>

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
                            <form method="GET" action="{{ route('customer.kategori-produk', $kategori->id) }}"
                                class="flex flex-col">
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
                    class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-[9999] backdrop-blur-sm">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-sm relative">
                        <button id="closeMobileFilterBtn"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                        @include('layouts.partials_user._filter-form')
                    </div>
                </div>

                {{-- SORT MODAL MOBILE --}}
                <div id="sortModal"
                    class="fixed inset-0 bg-black/50 hidden flex items-center justify-center lg:hidden z-[9999] backdrop-blur-sm">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-sm relative">
                        <button id="closeSortModal"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                        <h2 class="text-xl font-bold mb-4">Urutkan Produk</h2>
                        <form method="GET" action="{{ route('customer.kategori-produk', $kategori->id) }}"
                            class="flex flex-col gap-3">
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

                {{-- PRODUK GRID --}}
                @if($produks->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-8V4a1 1 0 00-1-1h-2a1 1 0 00-1 1v1M9 7h6">
                            </path>
                        </svg>
                        <p class="text-gray-500 text-lg text-center">Belum ada produk untuk kategori ini.</p>
                    </div>
                @else
                    <div
                        class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
                        @foreach($produks as $item)
                            @include('layouts.partials_user.cards._product', ['item' => $item])
                        @endforeach
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