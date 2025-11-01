@extends('layouts.user_app')

@section('content')

    {{-- HERO SLIDER --}}
    <section class="hero" id="hero">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('{{ asset('assets/images/hero/1.jpeg') }}')"></div>
            <div class="slide" style="background-image: url('{{ asset('assets/images/hero/2.jpeg') }}')"></div>
            <div class="slide" style="background-image: url('{{ asset('assets/images/hero/3.jpeg') }}')"></div>
        </div>
    </section>

    {{-- MAIN PANEL / TABS --}}
    <div class="tabs">
        <button class="tab" data-category="kategori">Kategori</button>
        <button class="tab active" data-category="all">Semua Produk</button>
        <button class="tab" data-category="diskon">Diskon</button>
    </div>

    {{-- PANEL: CATEGORY --}}
    <style>
        /* --- Fix tampilan mobile --- */
        @media (max-width: 640px) {
            .kategori-item {
                height: 230px !important;
                position: relative;
            }

            .kategori-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .kategori-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 10px;
            }

            .kategori-overlay h3 {
                color: #fff;
                font-size: 1.6rem;
                font-weight: bold;
                line-height: 1.2;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            }
        }

        /* --- Fix tampilan desktop --- */
        @media (min-width: 641px) {
            .kategori-item {
                position: relative;
                height: 300px;
            }

            .kategori-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .kategori-overlay {
                position: absolute;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                transition: background-color 0.3s ease;
            }

            .kategori-overlay:hover {
                background-color: rgba(0, 0, 0, 0.55);
            }

            .kategori-overlay h3 {
                color: #fff;
                font-size: 2rem;
                font-weight: 700;
                letter-spacing: 1px;
                text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
            }
        }
    </style>
    <div id="panel-kategori" class="tab-panel hidden mt-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto px-4">
            {{-- T-SHIRT --}}
            <a href="{{ route('customer.kategori-tshirt') }}"
                class="group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="kategori-item">
                    <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=600&q=80"
                        alt="T-Shirt" />
                    <div class="kategori-overlay">
                        <h3>T-SHIRT</h3>
                    </div>
                </div>
            </a>

            {{-- HOODIE --}}
            <a href="{{ route('customer.kategori-hoodie') }}"
                class="group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="kategori-item">
                    <img src="{{ asset('assets/images/banner/hoodie-1.jpg') }}" alt="Hoodie" />
                    <div class="kategori-overlay">
                        <h3>HOODIE</h3>
                    </div>
                </div>
            </a>

            {{-- JERSEY --}}
            <a href="{{ route('customer.kategori-jersey') }}"
                class="group block overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="kategori-item">
                    <img src="{{ asset('assets/images/banner/jersey.jpg') }}" alt="Jersey" />
                    <div class="kategori-overlay">
                        <h3>JERSEY</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>



    {{-- PANEL: DISKON --}}
    <div id="panel-diskon" class="tab-panel hidden px-10 py-10">
        @if($produkDiskon->isEmpty())
            <p class="text-center text-gray-600 text-lg">Belum ada produk diskon saat ini.</p>
        @else
            <div class="product-grid grid md:grid-cols-3 gap-8">
                @foreach($produkDiskon as $item)
                    <div
                        class="group bg-white rounded-lg overflow-hidden border border-gray-300 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">

                        {{-- LABEL DISKON --}}
                        <div class="absolute top-3 left-3 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full z-10">
                            -{{ $item->diskon }}%
                        </div>

                        {{-- IMAGE --}}
                        <a href="{{ route('produk.detail', $item->id) }}" class="block overflow-hidden rounded-t-2xl bg-gray-50">
                            @if($item->fotos->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                            @else
                                <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                            @endif
                        </a>

                        {{-- INFO PRODUK --}}
                        <div class="p-6 flex flex-col gap-3">
                            <h3 class="text-xl font-bold text-gray-900 line-clamp-1 text-center">{{ $item->nama_produk }}</h3>

                            {{-- HARGA DISKON --}}
                            <div>
                                @php
                                    $hargaDiskon = $item->harga - ($item->harga * $item->diskon / 100);
                                @endphp
                                <div class="flex justify-center items-center gap-3">
                                    <p class="text-sm text-gray-500 line-through text-center">
                                        IDR {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                    <p class="text-lg text-red-800 font-bold text-center">
                                        IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- BUTTONS --}}
                            <div class="flex gap-2 mt-3">
                                <button onclick="openModal('productModal-{{ $item->id }}')"
                                    class="bg-gray-700 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </button>

                                <button onclick="openModal('productBeliModal-{{ $item->id }}')"
                                    class="bg-gray-700 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0">
                                    Beli
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- PANEL: ALL PRODUCT --}}
    <section id="panel-all" class="product-section py-10 bg-gradient-to-b from-white to-gray-50 tab-panel block">
        <div class="container mx-auto px-4 md:px-10 md:py-10">
            <div class="product-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-x-4 gap-y-4 md:px-10 md-gap-y-6 md:gap-y-6 justify-items-center">
                @forelse($produk as $item)
                    <div class="group product-cards w-[300px] bg-white rounded-lg overflow-hidden border border-gray-300 shadow-sm"
                        data-id="{{ $item->id }}" data-nama="{{ $item->nama_produk }}" data-harga="{{ $item->harga }}"
                        data-foto="{{ $item->fotos->isNotEmpty() ? asset('storage/' . $item->fotos->first()->foto) : asset('assets/images/no-image.png') }}"
                        data-category="{{ $item->kategori ?? 'umum' }}">

                        {{-- PRODUCT IMAGES --}}
                        <a href="{{ route('produk.detail', $item->id) }}"
                            class="block w-full overflow-hidden rounded-lg bg-gray-50">
                            @if($item->fotos->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-contain group-hover:scale-110 transition-transform duration-500">
                            @endif
                        </a>

                        <div class="flex flex-col gap-0 md:gap-2">
                            <h3 class="text-xl font-bold text-gray-900 line-clamp-1 text-center mt-1">{{ $item->nama_produk }}
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

    <div class="see-all">
        <a href="{{ route('customer.allProduk') }}" class="see-all-btn">
            LIHAT SEMUA PRODUK
        </a>
    </div>

    <div class="extra-icons">
        <div class="icon-box">
            <i data-lucide="info"></i>
            <span>Tentang Kami</span>
        </div>
        <div class="icon-box">
            <a href="{{ route('customer.allProduk') }}" class="icon-box">
                <i data-lucide="shopping-bag"></i>
                <span>Semua Produk</span>
            </a>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                document.querySelectorAll('.tab-panel').forEach(panel => {
                    panel.classList.add('hidden');
                    panel.classList.remove('block');
                });

                const filteredCategory = document.getElementById('filtered-category');
                if (filteredCategory) filteredCategory.classList.add('hidden');
                const target = tab.dataset.category;
                const targetPanel = document.getElementById(`panel-${target}`);
                if (targetPanel) {
                    targetPanel.classList.remove('hidden');
                    targetPanel.classList.add('block');
                }
            });
        });
    </script>

    {{-- JS: KATEGORI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allProducts = @json($produk);
            window.showCategory = function (jenis) {
                const kategoriPanel = document.getElementById('panel-kategori');
                const filteredPanel = document.getElementById('filtered-category');
                const grid = document.getElementById('filtered-products');
                const bannerTitle = document.getElementById('category-banner-title');
                const bannerImg = document.getElementById('category-banner-img');
                kategoriPanel.classList.add('hidden');
                filteredPanel.classList.remove('hidden');
                bannerTitle.textContent = jenis;
                const bannerMap = {
                    'T-Shirt': '/assets/images/banner/tshirt.jpeg',
                    'Hoodie': '/assets/images/banner/hoodie-1.jpg',
                    'Jersey': '/assets/images/banner/jersey.jpg',
                };
                bannerImg.src = bannerMap[jenis] || '/assets/images/default-banner.jpg';
                const filtered = allProducts.filter(p => p.jenis === jenis);
                grid.innerHTML = '';

                if (filtered.length === 0) {
                    grid.innerHTML = `<p class='col-span-3 text-center text-gray-500 text-lg py-12'>Belum ada produk untuk kategori ${jenis}</p>`;
                    return;
                }

                filtered.forEach(item => {
                    const foto = item.fotos?.length ? `/storage/${item.fotos[0].foto}` : `/assets/images/no-image.png`;

                    const card = `
                                                                        <div class="group bg-white rounded-2xl overflow-hidden border border-gray-300 shadow-sm hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
                                                                            data-id="${item.id}" data-nama="${item.nama_produk}" data-harga="${item.harga}"
                                                                            data-foto="${foto}" data-category="${item.kategori ?? 'umum'}">

                                                                            <a href="/produk/detail/${item.id}" class="block overflow-hidden rounded-t-2xl bg-gray-50">
                                                                                <img src="${foto}" alt="${item.nama_produk}" class="w-full h-72 object-contain group-hover:scale-105 transition-transform duration-500 p-4">
                                                                            </a>

                                                                            <div class="p-6 flex flex-col gap-3">
                                                                                <h3 class="text-center text-xl font-bold text-gray-900 line-clamp-1">${item.nama_produk}</h3>
                                                                                <p class="text-center text-lg text-black font-bold">
                                                                                    IDR ${new Intl.NumberFormat('id-ID').format(item.harga)}
                                                                                </p>

                                                                                <div class="flex gap-2 w-full mt-2">
                                                                                    <!-- CART -->
                                                                                    <button
                                                                                        class="bg-gray-600 text-white p-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md flex items-center justify-center flex-shrink-0"
                                                                                        onclick="openModal('productModal-${item.id}')" title="Tambah ke Keranjang">
                                                                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                                                                                            <path stroke-linecap='round' stroke-linejoin='round'
                                                                                                d='M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'/>
                                                                                        </svg>
                                                                                    </button>

                                                                                    <!-- BUY -->
                                                                                    <button
                                                                                        class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center gap-2"
                                                                                        onclick="openModal('productBeliModal-${item.id}')">
                                                                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
                                                                                            <path stroke-linecap='round' stroke-linejoin='round' d='M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'/>
                                                                                        </svg>
                                                                                        <span>Beli Sekarang</span>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>`;
                    grid.insertAdjacentHTML('beforeend', card);
                });
            };

            window.backToCategories = function () {
                document.getElementById('filtered-category').classList.add('hidden');
                document.getElementById('panel-kategori').classList.remove('hidden');
            };
        });
    </script>
@endpush