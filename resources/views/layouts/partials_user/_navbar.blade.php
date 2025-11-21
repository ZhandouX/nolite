<div class="left-header">
    <button id="menuBtn"
        class="flex items-center justify-center w-8 h-8 cursor-pointer rounded-lg hover:bg-white/10 transition-all duration-300">
        <i class="fa-solid fa-bars text-sm md:text-xl"></i>
    </button>
</div>

<div id="headerLogo" class="logo flex items-center gap-1">
    <div class="logo-container relative">
        <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite"
            class="logo-img w-8 h-8 md:w-10 md:h-10 object-contain transform hover:scale-110 transition-transform duration-300" />
        <div class="absolute inset-0 bg-white/5 rounded-full scale-0 hover:scale-100 transition-transform duration-300">
        </div>
    </div>
    <span id="brandText"
        class="text-white text-xl md:text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
        Nolite Aspiciens
    </span>
</div>

<nav class="nav-icons flex items-center gap-1 relative">
    <!-- SEARCH CONTAINER -->
    <div class="search-container relative group">
        <div
            class="relative flex items-center h-10 bg-transparent backdrop-blur-sm rounded-2xl -mr-4 px-3 transition-all duration-300">
            <!-- SEARCH ICON -->
            <button type="button" id="searchButton"
                class="flex items-center justify-center w-8 h-8 md:w-9 md:h-9 cursor-pointer rounded-xl hover:bg-white/10 transition-all duration-300">
                <i data-lucide="search"
                    class="w-4 h-4 md:w-6 md:h-6 stroke-[2] text-white/80 group-hover:text-white transition-colors"></i>
            </button>

            <!-- SEARCH INPUT -->
            <input id="searchInput" type="text" placeholder="Cari produk..." class="bg-transparent border-none w-0 h-full pl-2 text-sm transition-all duration-500 ease-out
                       focus:w-48 md:focus:w-64 focus:outline-none text-white placeholder-white/60
                       focus:placeholder-white/40 rounded-none">
        </div>
    </div>

    <!-- SEARCH RESULTS -->
    <div id="searchResults"
        class="fixed top-20 md:top-24 left-4 right-4 md:left-1/2 md:-translate-x-1/2 
           w-[calc(100%-2rem)] md:w-[800px] md:max-w-[800px]
           bg-white/95 backdrop-blur-xl shadow-2xl rounded-2xl p-0 z-[140] hidden overflow-hidden border border-white/20">

        <!-- RESULTS WRAPPER -->
        <div class="relative">
            <!-- HEADER -->
            <div
                class="sticky top-0 bg-white/80 backdrop-blur-md z-50 px-6 pt-5 pb-4 border-b border-gray-100 flex items-center">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-gray-600"></i>
                    Hasil Pencarian
                </h3>
                <button id="closeSearch" type="button"
                    class="ml-auto text-gray-400 hover:text-gray-600 transition-all duration-200 hover:scale-110">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- LOADING STATE -->
            <div id="loadingState" class="hidden flex-col items-center justify-center py-12">
                <div class="relative">
                    <div class="animate-spin rounded-full h-12 w-12 border-2 border-gray-300 border-t-gray-600 mx-auto">
                    </div>
                    <i
                        class="fa-solid fa-magnifying-glass absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-gray-600 text-sm"></i>
                </div>
                <p class="mt-4 text-gray-500 text-sm font-medium">Mencari produk...</p>
            </div>

            <!-- NO RESULTS -->
            <div id="noResults" class="hidden flex-col items-center justify-center py-12 px-6">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-search text-3xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium mb-2">Produk tidak ditemukan</p>
                <p class="text-gray-400 text-sm text-center">Coba kata kunci lain atau periksa ejaan</p>
            </div>

            <!-- RESULTS GRID -->
            <div id="resultsGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 p-6">
                <!-- Results akan muncul di sini -->
            </div>
        </div>
    </div>

    <!-- OVERLAY -->
    <div id="searchOverlay" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-[130] hidden"></div>

    @php
        $jumlahKeranjang = \App\Models\Keranjang::jumlahKeranjang();
    @endphp

    <!-- CART -->
    <button type="button" onclick="window.location='{{ route('keranjang.index') }}'"
        class="relative flex items-center justify-center w-8 h-8 md:w-9 md:h-9 rounded-xl transition-all duration-300 group hover:bg-white/10">
        <svg class="w-4 h-4 md:w-6 md:h-6 text-white/80 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span id="cartBadge" class="absolute top-0 right-0 bg-gradient-to-r from-red-500 to-red-600 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-lg
        @if ($jumlahKeranjang == 0) 
            hidden 
        @endif 
        transform group-hover:scale-110 transition-transform">
            {{ $jumlahKeranjang }}
        </span>
    </button>

    <!-- USER -->
    <div class="relative">
        @auth
            <button type="button" onclick="window.location='{{ route('profile.edit') }}'"
                class="flex items-center justify-center w-8 h-8 md:w-9 md:h-9 rounded-xl transition-all hover:bg-white/10 duration-300 group">
                <i data-lucide="user"
                    class="w-4 h-4 md:w-6 md:h-6 stroke-[2] text-white/80 group-hover:text-white transition-colors"></i>
            </button>
        @else
            <button type="button" onclick="openLoginModal()"
                class="flex items-center justify-center w-8 h-8 md:w-9 md:h-9 rounded-xl transition-all duration-300 group hover:bg-white/10">
                <i data-lucide="user"
                    class="w-4 h-4 md:w-6 md:h-6 stroke-[2] text-white/80 group-hover:text-white transition-colors"></i>
            </button>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchButton = document.getElementById('searchButton');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchOverlay = document.getElementById('searchOverlay');
        const closeSearch = document.getElementById('closeSearch');
        const resultsGrid = document.getElementById('resultsGrid');
        const loadingState = document.getElementById('loadingState');
        const noResults = document.getElementById('noResults');
        const brandText = document.getElementById('brandText');

        let searchTimeout;
        let isSearchOpen = false;

        // Toggle Search
        searchButton.addEventListener('click', () => {
            if (!isSearchOpen) {
                searchInput.classList.remove('w-0');
                searchInput.classList.add('w-48', 'md:w-64');
                brandText.classList.add('hidden', 'md:flex');
                searchInput.focus();
                isSearchOpen = true;
                return;
            }

            if (searchInput.value.trim().length >= 2) {
                searchResults.classList.remove('hidden');
                searchOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });

        // Close Search
        function closeSearchResults() {
            searchResults.classList.add('hidden');
            searchOverlay.classList.add('hidden');
            document.body.style.overflow = '';
            resultsGrid.innerHTML = '';
            loadingState.classList.add('hidden');
            noResults.classList.add('hidden');
        }

        closeSearch.addEventListener('click', closeSearchResults);
        searchOverlay.addEventListener('click', closeSearchResults);

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && isSearchOpen) {
                closeSearchResults();
                if (searchInput.value === '') {
                    closeSearchInput();
                }
            }
        });

        function closeSearchInput() {
            searchInput.classList.remove('w-48', 'md:w-64');
            searchInput.classList.add('w-0');
            searchInput.value = '';
            brandText.classList.remove('hidden', 'md:flex');
            isSearchOpen = false;
        }

        // Search Input Handler
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length >= 2) {
                loadingState.classList.remove('hidden');
                resultsGrid.classList.add('hidden');
                noResults.classList.add('hidden');
                searchResults.classList.remove('hidden');
                searchOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                searchTimeout = setTimeout(() => fetchSearchResults(query), 400);
            } else {
                closeSearchResults();
            }
        });

        let autoCloseTimeout;

        searchInput.addEventListener('focus', () => {
            clearTimeout(autoCloseTimeout);
        });

        searchInput.addEventListener('blur', () => {
            if (searchInput.value === '') {
                autoCloseTimeout = setTimeout(() => closeSearchInput(), 10000);
            }
        });

        // Fetch Search Results
        async function fetchSearchResults(query) {
            try {
                const response = await fetch(`/search-produk?q=${encodeURIComponent(query)}`);
                if (!response.ok) throw new Error('Gagal mengambil data');
                const data = await response.json();

                loadingState.classList.add('hidden');

                if (!Array.isArray(data) || data.length === 0) {
                    noResults.classList.remove('hidden');
                    resultsGrid.classList.add('hidden');
                } else {
                    noResults.classList.add('hidden');
                    resultsGrid.classList.remove('hidden');
                    displayResults(data);
                }
            } catch (error) {
                console.error('Error:', error);
                loadingState.classList.add('hidden');
                noResults.classList.remove('hidden');
            }
        }

        // Display Results
        function displayResults(products) {
            resultsGrid.innerHTML = '';

            products.forEach(prod => {
                const foto = prod.foto || '/assets/images/no-image.png';
                const nama = (prod.nama_produk || 'Produk Tanpa Nama').replace(/"/g, '&quot;');
                const harga = Number(prod.harga) || 0;
                const hargaDiskon = Number(prod.harga_diskon) || harga;
                const diskon = Number(prod.diskon) || 0;
                const jumlah = Number(prod.jumlah) || 0;

                const stokStatus = jumlah > 0
                    ? '<span class="text-green-600 text-xs font-semibold bg-green-50 px-2 py-1 rounded-full">Tersedia</span>'
                    : '<span class="text-red-600 text-xs font-semibold bg-red-50 px-2 py-1 rounded-full">Stok Habis</span>';

                let hargaHTML = '';
                if (diskon > 0 && hargaDiskon < harga) {
                    hargaHTML = `
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <span class="text-gray-400 line-through text-xs">${formatRupiah(harga)}</span>
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-sm font-bold">
                                ${formatRupiah(hargaDiskon)}
                            </span>
                        </div>
                    `;
                } else {
                    hargaHTML = `<p class="text-gray-800 font-bold text-sm mb-2">${formatRupiah(harga)}</p>`;
                }

                const modalCartId = `productModal-${prod.id}`;
                const modalBeliId = `productBeliModal-${prod.id}`;

                const card = `
                    <div class="group cursor-pointer bg-white rounded-2xl border border-gray-100 hover:border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="relative overflow-hidden">
                            <img src="${foto}" alt="${nama}" 
                                class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300">
                            ${diskon > 0 ? `
                                <div class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                                    -${diskon}%
                                </div>
                            ` : ''}
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800 text-sm mb-2 line-clamp-2 leading-tight">${nama}</h4>
                            ${hargaHTML}
                            <div class="flex items-center justify-between mb-3">
                                ${stokStatus}
                            </div>
                            ${jumlah > 0 ? `
                                <div class="flex gap-2">
                                    <button onclick="openModal('${modalCartId}')" 
                                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-3 rounded-lg text-xs transition-all duration-200 flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-cart-plus text-xs"></i>
                                        Keranjang
                                    </button>
                                    <button onclick="openModal('${modalBeliId}')" 
                                        class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-3 rounded-lg text-xs transition-all duration-200">
                                        Beli
                                    </button>
                                </div>
                            ` : `
                                <button disabled class="w-full bg-gray-100 text-gray-400 font-medium py-2 rounded-lg text-xs">
                                    Stok Habis
                                </button>
                            `}
                        </div>
                    </div>
                `;

                resultsGrid.insertAdjacentHTML('beforeend', card);
            });

            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

        function formatRupiah(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        window.displayResults = displayResults;
    });
</script>