@extends('layouts.user_app')

@section('content')
    <div class="container mx-auto px-0 py-8 pt-24">
        <div class="flex flex-col md:flex-row gap-8">

            {{-- SIDEBAR FILTER --}}
            <aside class="w-full md:w-1/4 bg-white border border-gray-200 rounded-lg p-4">
                <form method="GET" action="{{ route('customer.kategori-tshirt') }}">
                    {{-- SEARCH --}}
                    <div class="mb-6">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                                class="w-full border border-gray-300 rounded-md pl-10 pr-4 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                            <i class="fa fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- PRODUCT CATEGORY --}}
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Kategori</h2>

                        @php
                            $routeMap = [
                                'T-shirt' => 'customer.kategori-tshirt',
                                'Hoodie' => 'customer.kategori-hoodie',
                                'Jersey' => 'customer.kategori-jersey',
                            ];

                            $currentRoute = Route::currentRouteName();
                        @endphp

                        @foreach($routeMap as $cat => $routeName)
                            @php
                                $isChecked = strtolower($currentRoute) === strtolower($routeName);
                            @endphp

                            <label class="block text-sm text-gray-700 cursor-pointer">
                                <input type="radio" name="kategori" value="{{ $cat }}" {{ $isChecked ? 'checked' : '' }}
                                    onclick="handleCategoryClick(this, '{{ route($routeName) }}', '{{ route('customer.allProduk') }}')"
                                    class="mr-2 accent-gray-600">
                                {{ $cat }}
                            </label>
                        @endforeach
                    </div>

                    {{-- PRODUCT TYPE --}}
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Tipe Produk</h2>

                        <label class="block text-sm text-gray-700 cursor-pointer">
                            <input type="radio" name="tipe" value="" {{ request('tipe') == '' ? 'checked' : '' }}
                                onchange="this.form.submit()" class="mr-2 accent-gray-600">
                            Semua
                        </label>

                        <label class="block text-sm text-gray-700 cursor-pointer">
                            <input type="radio" name="tipe" value="unggulan" {{ request('tipe') == 'unggulan' ? 'checked' : '' }} onchange="this.form.submit()" class="mr-2 accent-gray-600">
                            Unggulan
                        </label>

                        <label class="block text-sm text-gray-700 cursor-pointer">
                            <input type="radio" name="tipe" value="diskon" {{ request('tipe') == 'diskon' ? 'checked' : '' }}
                                onchange="this.form.submit()" class="mr-2 accent-gray-600">
                            Diskon
                        </label>
                    </div>

                    {{-- MIN & MAX PRICES --}}
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Harga</h2>
                        <input type="number" name="harga_min" placeholder="Min" value="{{ request('harga_min') }}"
                            class="w-full mb-2 border rounded-md p-2">
                        <input type="number" name="harga_max" placeholder="Max" value="{{ request('harga_max') }}"
                            class="w-full border rounded-md p-2">
                    </div>

                    {{-- SIZES SELECTED --}}
                    <div class="mb-6">
                        <h2 class="font-semibold mb-2">Ukuran</h2>
                        @foreach(['S', 'M', 'L', 'XL'] as $size)
                            <button type="submit" name="ukuran" value="{{ $size }}"
                                class="px-3 py-1 border rounded-md hover:bg-gray-100 {{ request('ukuran') == $size ? 'bg-gray-200 border-blue-500' : '' }}">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>

                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-500 text-white py-2 rounded-md">
                        Terapkan Filter
                    </button>
                </form>
            </aside>

            {{-- PRODUCT LIST --}}
            <main class="w-full md:w-3/4">

                {{-- === BANNER T-SHIRT === --}}
                <div class="relative h-56 mb-8 rounded-lg overflow-hidden shadow-lg w-[115%] ml-0 -mr-8 group">
                    <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=1400&q=80"
                        alt="Banner T-Shirt"
                        class="absolute inset-0 w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-black/40 flex items-center justify-center transition-all duration-500 group-hover:bg-black/50">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white">T-Shirt</h1>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">Produk T-Shirt</h1>
                    <form method="GET" action="{{ route('customer.kategori-tshirt') }}">
                        <select name="sort" onchange="this.form.submit()"
                            class="border border-gray-300 rounded-md px-4 py-2">
                            <option value="">Urutkan</option>
                            <option value="harga_terendah" {{ request('sort') == 'harga_terendah' ? 'selected' : '' }}>Harga
                                Terendah</option>
                            <option value="harga_tertinggi" {{ request('sort') == 'harga_tertinggi' ? 'selected' : '' }}>Harga
                                Tertinggi</option>
                            <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A–Z)</option>
                            <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z–A)</option>
                        </select>
                    </form>
                </div>

                {{-- === GRID PRODUK === --}}
                <div class="grid md:grid-cols-3 gap-8">
                    @forelse($produk as $item)
                        <div class="group bg-white rounded-2xl overflow-hidden border border-gray-300 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                            data-id="{{ $item->id }}" data-nama="{{ $item->nama_produk }}" data-harga="{{ $item->harga }}"
                            data-foto="{{ $item->fotos->isNotEmpty() ? asset('storage/' . $item->fotos->first()->foto) : asset('assets/images/no-image.png') }}"
                            data-category="{{ $item->kategori ?? 'umum' }}">

                            {{-- PRODUCT IMAGE --}}
                            <a href="{{ route('produk.detail', $item->id) }}"
                                class="block overflow-hidden rounded-t-2xl bg-gray-50">
                                @if($item->fotos->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                        class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                        class="w-full h-50 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                                @endif
                            </a>

                            <div class="pb-4 pl-4 pr-4 pt-0 flex flex-col gap-3">
                                <h3 class="text-xl text-center font-bold text-gray-900 line-clamp-1 pt-2">
                                    {{ $item->nama_produk }}
                                </h3>
                                <p class="text-lg text-center text-black font-bold">
                                    IDR {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                                <div class="flex gap-2 w-full mt-2 pb-4">
                                    <button
                                        class="bg-gray-600 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0"
                                        onclick="openModal('productModal-{{ $item->id }}')" title="Tambah ke Keranjang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <button
                                        class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center gap-2"
                                        onclick="openModal('productBeliModal-{{ $item->id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <span>Beli</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL BELI --}}
                        @include('layouts.partials_user.modal-beli', ['item' => $item])

                        {{-- MODAL KERANJANG --}}
                        @include('layouts.partials_user.modal-cart', ['item' => $item])
                    @empty
                        <p class="text-gray-500 col-span-3 text-center">Produk tidak ditemukan.</p>
                    @endforelse
                </div>

            </main>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function handleCategoryClick(radio, categoryUrl, allUrl) {
            if (radio.dataset.waschecked === "true") {
                radio.checked = false;
                radio.dataset.waschecked = "false";
                window.location.href = allUrl;
            } else {
                document.querySelectorAll('input[name="kategori"]').forEach(el => el.dataset.waschecked = "false");
                radio.dataset.waschecked = "true";
                window.location.href = categoryUrl;
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('input[name="kategori"]').forEach(el => {
                if (el.checked) el.dataset.waschecked = "true";
            });
        });
    </script>

@endpush