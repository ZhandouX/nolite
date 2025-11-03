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
    <link rel="stylesheet" href="{{ asset('assets/css/user/kategori.css') }}">
    @include('layouts.partials_user.panels.kategori')

    {{-- PANEL: DISKON --}}
    @include('layouts.partials_user.panels.diskon')

    {{-- PANEL: ALL PRODUCT --}}
    @include('layouts.partials_user.panels.all-produk')

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