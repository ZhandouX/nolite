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
    <div id="panel-kategori" class="tab-panel hidden mt-10">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 max-w-4xl mx-auto">

            {{-- T-SHIRT --}}
            <a href="{{ route('customer.kategori-tshirt') }}"
                class="group block relative overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                <div class="h-80 bg-cover bg-center transform transition-transform duration-500 group-hover:scale-105"
                    style="background-image: url('https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=500&q=80')">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h3 class="text-3xl font-bold text-white text-center">T-Shirt</h3>
                    </div>
                </div>
            </a>

            {{-- HOODIE --}}
            <a href="{{ route('customer.kategori-hoodie') }}"
                class="group block relative overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                <div class="h-80 bg-cover bg-center transform transition-transform duration-500 group-hover:scale-105"
                    style="background-image: url('/assets/images/banner/hoodie-1.jpg')">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h3 class="text-3xl font-bold text-white text-center">Hoodie</h3>
                    </div>
                </div>
            </a>

            {{-- JERSEY --}}
            <a href="{{ route('customer.kategori-jersey') }}"
                class="group block relative overflow-hidden rounded-lg shadow-lg hover:shadow-2xl transition-all cursor-pointer">
                <div class="h-80 bg-cover bg-center transform transition-transform duration-500 group-hover:scale-105"
                    style="background-image: url('https://images.unsplash.com/photo-1574180045827-681f8a1a9622?auto=format&fit=crop&w=500&q=80')">
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
                        <h3 class="text-3xl font-bold text-white text-center">Jersey</h3>
                    </div>
                </div>
            </a>

        </div>
    </div>

    <section id="filtered-category" class="hidden bg-white">
        {{-- BANNER CATEGORY --}}
        <div id="category-banner" class="relative w-full overflow-hidden">
            <img id="category-banner-img" src="/assets/images/default-banner.jpg" alt="Category Banner"
                class="w-full h-[400px] object-cover">
            <h2 id="category-banner-title" class="absolute bottom-6 left-8 text-5xl font-bold text-white drop-shadow-lg">
                Kategori
            </h2>
        </div>

        {{-- FILTER & SORT --}}
        <div class="container mx-auto px-4 py-6 grid grid-cols-2 gap-4">
            <button
                class="flex items-center justify-center border-2 border-red-700 text-red-700 rounded-xl py-3 text-lg font-medium hover:bg-red-700 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10m-6 6h6" />
                </svg>
                Filter
            </button>
            <button
                class="flex items-center justify-center border-2 border-red-700 text-red-700 rounded-xl py-3 text-lg font-medium hover:bg-red-700 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4h18M6 8h12M9 12h6M12 16h3" />
                </svg>
                Sort
            </button>
        </div>

        {{-- PRODUCT --}}
        <div class="container mx-auto px-4 pb-12">
            <div id="filtered-products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
            </div>
        </div>
    </section>

    {{-- PANEL: PRODUCT: FILTERED --}}
    <div id="filtered-category" class="hidden">
        <div id="category-banner" class="relative h-96 bg-cover bg-center rounded-3xl shadow-lg mb-12"></div>
        <h2 class="text-3xl font-bold text-center mb-8 text-gray-800" id="category-title"></h2>
        <div id="filtered-products" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
    </div>

    {{-- PANEL: DISKON --}}
    <div id="panel-diskon" class="tab-panel hidden mt-10">
        <p class="text-center text-gray-600 text-lg">Belum ada produk diskon saat ini.</p>
    </div>

    {{-- PANEL: ALL PRODUCT --}}
    <section id="panel-all" class="product-section py-16 bg-gradient-to-b from-white to-gray-50 tab-panel block">

        <div class="container mx-auto px-4">

            {{-- GRID PRODUCT --}}
            <div class="product-grid grid md:grid-cols-3 gap-8">
                @forelse($produk as $item)
                    <div class="group bg-white rounded-2xl overflow-hidden border border-gray-300 shadow-sm"
                        data-id="{{ $item->id }}" data-nama="{{ $item->nama_produk }}" data-harga="{{ $item->harga }}"
                        data-foto="{{ $item->fotos->isNotEmpty() ? asset('storage/' . $item->fotos->first()->foto) : asset('assets/images/no-image.png') }}"
                        data-category="{{ $item->kategori ?? 'umum' }}">

                        {{-- PRODUCT IMAGES --}}
                        <a href="{{ route('produk.detail', $item->id) }}"
                            class="block overflow-hidden rounded-t-2xl bg-gray-50">
                            @if($item->fotos->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->fotos->first()->foto) }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-contain group-hover:scale-110 transition-transform duration-500 p-4">
                            @else
                                <img src="{{ asset('assets/images/no-image.png') }}" alt="{{ $item->nama_produk }}"
                                    class="w-full h-72 object-contain group-hover:scale-110 transition-transform duration-500 p-4">
                            @endif
                        </a>

                        <div class="p-6 flex flex-col gap-3">
                            <h3 class="text-xl font-bold text-gray-900 line-clamp-1">{{ $item->nama_produk }}</h3>
                            <p class="text-lg text-black font-bold">
                                IDR {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                            <div class="flex gap-2 w-full mt-2">
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
                                    class="bg-gray-600 text-white px-6 py-3 rounded-xl hover:bg-gray-400 transform hover:scale-105 transition-all duration-200 shadow-md font-semibold flex-1 min-w-0 flex items-center justify-center gap-2"
                                    onclick="openModal('productBeliModal-{{ $item->id }}')">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                    </svg> -->
                                    <span>Beli</span>
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
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

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