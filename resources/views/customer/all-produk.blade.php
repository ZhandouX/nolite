@extends('layouts.user_app')

@section('content')
    <div class="container mx-auto px-4 md:px-10 py-8 pt-24">

        <div class="flex flex-col md:flex-row gap-8">

            {{-- SIDEBAR FILTER DESKTOP --}}
            <aside class="hidden md:block w-full md:w-1/4 bg-white border border-gray-200 rounded-lg p-4">
                @include('layouts.partials_user._filter-form')
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="w-full md:w-3/4 flex flex-col gap-6">

                {{-- JUDUL HALAMAN --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 text-center mb-4">Semua Produk</h1>

                {{-- FILTER & SORT BUTTONS MOBILE (Bawah Judul) --}}
                <div class="flex gap-2 mb-4 justify-between md:hidden">
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
                <div class="hidden md:flex justify-end mb-2">
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
                    class="z-[9999] fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 w-11/12 max-w-sm relative">
                        <button id="closeMobileFilterBtn"
                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>
                        @include('layouts.partials_user._filter-form')
                    </div>
                </div>

                {{-- SORT MODAL MOBILE --}}
                <div id="sortModal"
                    class="z-[9999] fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center md:hidden">
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

                {{-- PRODUK GRID --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8">
                    @forelse($produks as $item)
                        <div class="group bg-white rounded-2xl overflow-hidden border border-gray-300 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                            data-id="{{ $item->id }}">
                            <a href="{{ route('produk.detail', $item->id) }}"
                                class="block overflow-hidden rounded-t-2xl bg-gray-50 relative">
                                @if($item->fotos->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                        class="w-full h-40 md:h-60 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                        class="w-full h-40 md:h-50 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                                @endif

                                @auth
                                    @php
                                        $isFavorited = \App\Models\Wishlist::where('user_id', Auth::id())
                                            ->where('produk_id', $item->id)
                                            ->exists();
                                    @endphp
                                    <button type="button"
                                        class="absolute bottom-3 right-3 w-10 h-10 flex items-center justify-center rounded-full 
                                                    bg-white/70 backdrop-blur-sm shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 text-gray-400 hover:text-red-500"
                                        onclick="event.preventDefault(); toggleWishlist({{ $item->id }})">
                                        <i id="heart-icon-{{ $item->id }}"
                                            class="fa-solid fa-heart {{ $isFavorited ? 'text-red-500 scale-110' : 'text-gray-400' }} transition-all duration-300 text-lg"></i>
                                    </button>
                                @endauth
                            </a>

                            <div class="pb-4 pl-4 pr-4 pt-0 flex flex-col gap-3">
                                <h3 class="text-sm md:text-xl text-center font-bold text-gray-900 line-clamp-1 pt-2">
                                    {{ $item->nama_produk }}
                                </h3>

                                @if($item->diskon && $item->diskon > 0)
                                    @php
                                        $hargaDiskon = $item->harga - ($item->harga * $item->diskon / 100);
                                    @endphp
                                    <div class="flex justify-center items-center gap-2">
                                        <p class="text-gray-400 text-[12px] md:text-[16px] font-bold line-through">
                                            IDR {{ number_format($item->harga, 0, ',', '.') }}
                                        </p>
                                        <p class="text-red-600 text-[12px] md:text-[16px] font-bold">
                                            IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @else
                                    <p class="text-sm md:text-lg text-center text-black font-bold">
                                        IDR {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                @endif

                                <div class="flex gap-1 md:gap-2 w-full pb-2">
                                    <button
                                        class="bg-gray-600 text-white p-2 md:p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0"
                                        onclick="openModal('productModal-{{ $item->id }}')" title="Tambah ke Keranjang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <button
                                        class="bg-gray-600 text-white px-3 md:px-6 py-2 md:py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center gap-1"
                                        onclick="openModal('productBeliModal-{{ $item->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <span class="text-xs md:text-sm">Beli</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @include('layouts.partials_user.modal-beli', ['item' => $item])
                        @include('layouts.partials_user.modal-cart', ['item' => $item])
                    @empty
                        <p class="text-gray-500 col-span-2 md:col-span-3 text-center">Produk tidak ditemukan.</p>
                    @endforelse
                </div>
            </main>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sortDropdownBtn = document.getElementById('sortDropdownBtn');
            const sortDropdownMenu = document.getElementById('sortDropdownMenu');
            if (sortDropdownBtn) {
                sortDropdownBtn.addEventListener('click', e => {
                    e.stopPropagation();
                    sortDropdownMenu.classList.toggle('hidden');
                });
                document.addEventListener('click', e => {
                    if (!sortDropdownMenu.contains(e.target) && !sortDropdownBtn.contains(e.target))
                        sortDropdownMenu.classList.add('hidden');
                });
            }

            const mobileOpenFilterBtn = document.getElementById('mobileOpenFilterBtn');
            const mobileFilterModal = document.getElementById('mobileFilterModal');
            const closeMobileFilterBtn = document.getElementById('closeMobileFilterBtn');
            mobileOpenFilterBtn.addEventListener('click', () => mobileFilterModal.classList.remove('hidden'));
            closeMobileFilterBtn.addEventListener('click', () => mobileFilterModal.classList.add('hidden'));
            mobileFilterModal.addEventListener('click', e => {
                if (e.target === mobileFilterModal) mobileFilterModal.classList.add('hidden');
            });

            const openSortBtn = document.getElementById('openSortBtn');
            const sortModal = document.getElementById('sortModal');
            const closeSortModal = document.getElementById('closeSortModal');
            openSortBtn.addEventListener('click', () => sortModal.classList.remove('hidden'));
            closeSortModal.addEventListener('click', () => sortModal.classList.add('hidden'));
            sortModal.addEventListener('click', e => {
                if (e.target === sortModal) sortModal.classList.add('hidden');
            });

            window.toggleWishlist = function (produkId) {
                fetch(`/wishlist/toggle/${produkId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                    .then(res => res.json())
                    .then(data => {
                        const icon = document.getElementById(`heart-icon-${produkId}`);
                        if (data.status === 'added') {
                            icon.classList.remove('text-gray-300');
                            icon.classList.add('text-red-500');
                        } else {
                            icon.classList.remove('text-red-500');
                            icon.classList.add('text-gray-300');
                        }
                    })
                    .catch(err => console.error(err));
            };

            window.handleCategoryClick = function (radio, categoryUrl, allUrl) {
                if (radio.dataset.waschecked === "true") {
                    radio.checked = false;
                    radio.dataset.waschecked = "false";
                    window.location.href = allUrl;
                } else {
                    document.querySelectorAll('input[name="kategori"]').forEach(el => el.dataset.waschecked = "false");
                    radio.dataset.waschecked = "true";
                    window.location.href = categoryUrl;
                }
            };
        });
    </script>

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