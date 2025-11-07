<div class="left-header">
    <span id="menuBtn" class="cursor-pointer text-2xl">
        <i class="fa-solid fa-bars text-[14px] md:text-xl"></i>
    </span>
</div>

<div id="headerLogo" class="logo flex items-center gap-2">
    <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite"
        class="logo-img w-8 h-8 object-contain" />
    <span class="text-white text-[14px] md:text-[20px] font-semibold">Nolite Aspiciens</span>
</div>

<nav class="nav-icons flex items-center gap-2 md:gap-5 relative">
    <div class="relative flex items-center h-10">
        <!-- ICON SEARCH -->
        <button type="button" id="searchButton">
            <i data-lucide="search"
                class="lucide-nav absolute left-0 top-1/2 transform -translate-y-1/2 text-white pointer-events-none"></i>
        </button>

        <!-- INPUT SEARCH -->
        <input id="searchInput" type="text" placeholder="Cari produk..."
            class="bg-transparent border-none cursor-pointer w-0 h-6 pl-5 text-[12px] md:text-sm transition-all duration-400 ease-in-out
               focus:w-36 focus:border-b focus:border-gray-800 focus:pl-8 focus:outline-none focus:cursor-text rounded-none text-white">
    </div>

    <div id="searchResults"
        class="fixed top-20 right-6 w-[450px] max-w-[450px] md:w-[800px] md:max-w-[800px] bg-white shadow-2xl rounded-2xl p-4 z-[140] hidden overflow-y-auto max-h-[70vh]">

        <!-- CLOSE BUTTON -->
        <button id="closeSearch" type="button" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-circle-xmark text-2xl"></i>
        </button>

        <!-- RESULTS HEADER -->
        <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Hasil Pencarian</h3>

        <!-- LOADING STATE -->
        <div id="loadingState" class="hidden text-center py-6">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-gray-900 mx-auto"></div>
            <p class="mt-2 text-gray-600 text-sm">Mencari produk...</p>
        </div>

        <!-- NO RESULTS STATE -->
        <div id="noResults" class="hidden text-center py-6">
            <i class="fa-solid fa-search text-5xl text-gray-300 mb-2"></i>
            <p class="text-gray-600 text-sm">Produk tidak ditemukan</p>
        </div>

        <!-- RESULTS GRID -->
        <div id="resultsGrid" class="grid grid-cols-3 sm:grid-cols-4 gap-4 justify-items-center">
            <!-- Results akan muncul di sini -->
        </div>
    </div>

    <!-- OVERLAY -->
    <div id="searchOverlay" class="fixed inset-0 bg-transparent z-[130] hidden"></div>

    @php
        if (Auth::check()) {
            $jumlahKeranjang = \App\Models\Keranjang::where('user_id', Auth::id())->count();
        } else {
            $jumlahKeranjang = count(session('keranjang', []));
        }
    @endphp

    <!-- KERANJANG -->
    <a href="{{ route('keranjang.index') }}" class="text-white hover:text-gray-400 transition relative">
        <i data-lucide="shopping-cart" class="lucide-nav"></i>
        <span id="cartBadge" class="absolute -top-2 -right-3 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5
        @if ($jumlahKeranjang == 0) hidden @endif">
            {{ $jumlahKeranjang }}
        </span>
    </a>

    <!-- USER -->
    <div class="relative">
        @auth
            <a href="{{ route('profile.edit') }}"
                class="text-white hover:text-gray-400 transition flex items-center justify-center w-8 h-8 rounded-full">
                <i data-lucide="user" class="lucide-nav"></i>
            </a>
        @else
            <button type="button" onclick="openLoginModal()"
                class="text-white hover:text-gray-400 transition flex items-center justify-center w-8 h-8 rounded-full">
                <i data-lucide="user" class="lucide-nav"></i>
            </button>
        @endauth
    </div>
</nav>

<!-- ======================== JAVASCRIPT ======================== -->
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

        let searchTimeout;
        let isSearchOpen = false;

        // ==========================
        // Toggle Search Input
        // ==========================
        searchButton.addEventListener('click', () => {
            if (!isSearchOpen) {
                searchInput.classList.remove('w-0', 'opacity-0', 'pointer-events-none');
                searchInput.classList.add('w-64', 'opacity-100');
                searchInput.focus();
                isSearchOpen = true;
            } else if (searchInput.value.trim().length >= 2) {
                searchResults.classList.remove('hidden');
                searchOverlay.classList.remove('hidden');
            } else {
                closeSearchResults();
            }
        });

        // ==========================
        // Tutup Search
        // ==========================
        function closeSearchResults() {
            searchResults.classList.add('hidden');
            searchOverlay.classList.add('hidden');
            searchInput.classList.remove('w-64', 'opacity-100');
            searchInput.classList.add('w-0', 'opacity-0', 'pointer-events-none');
            searchInput.value = '';
            isSearchOpen = false;
            resultsGrid.innerHTML = '';
            loadingState.classList.add('hidden');
            noResults.classList.add('hidden');
        }

        closeSearch.addEventListener('click', closeSearchResults);
        searchOverlay.addEventListener('click', closeSearchResults);
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && isSearchOpen) closeSearchResults();
        });

        // ==========================
        // Ketika mengetik
        // ==========================
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length >= 2) {
                loadingState.classList.remove('hidden');
                resultsGrid.classList.add('hidden');
                noResults.classList.add('hidden');
                searchResults.classList.remove('hidden');
                searchOverlay.classList.remove('hidden');

                searchTimeout = setTimeout(() => fetchSearchResults(query), 500);
            } else {
                searchResults.classList.add('hidden');
                searchOverlay.classList.add('hidden');
                loadingState.classList.add('hidden');
                noResults.classList.add('hidden');
                resultsGrid.innerHTML = '';
            }
        });

        // ==========================
        // Fetch dari server
        // ==========================
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

        // Override openModal untuk dynamic modal
        const originalOpenModal = window.openModal;
        window.openModal = async function (modalId) {
            // Load modal jika belum ada
            if (!document.getElementById(modalId)) {
                // Ambil productId dari akhir string ID (asumsi format: productModal-{id})
                const parts = modalId.split('-');
                const productId = parts[parts.length - 1];
                await loadProductModals(productId);
            }

            // Tunggu sebentar supaya modal sudah di-inject
            setTimeout(() => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    if (originalOpenModal) {
                        originalOpenModal(modalId);
                    } else {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    }
                } else {
                    console.warn('Modal tidak ditemukan:', modalId);
                }
            }, 50);
        };

        // ==========================
        // Fungsi untuk menampilkan badge diskon
        // ==========================
        function renderDiskonBadge(diskon) {
            if (!diskon || diskon <= 0) return '';
            const persen = Number(diskon);
            return `<div class="absolute top-0 right-0 bg-red-500 text-white text-[8px] md:text-[12px] font-semibold md:font-bold px-2 py-1 rounded">
                DISKON ${persen}%
            </div>`;
        }

        function displayResults(products) {
            const resultsGrid = document.getElementById('resultsGrid');
            resultsGrid.innerHTML = '';

            products.forEach(prod => {
                const foto = prod.foto || '/assets/images/no-image.png';
                const nama = (prod.nama_produk || 'Produk Tanpa Nama').replace(/"/g, '&quot;');
                const harga = Number(prod.harga) || 0;
                const hargaDiskon = Number(prod.harga_diskon) || harga;
                const diskon = Number(prod.diskon) || 0;
                const jumlah = Number(prod.jumlah) || 0;

                const stokStatus = jumlah > 0
                    ? '<span class="text-green-600 text-xs font-semibold">Tersedia</span>'
                    : '<span class="text-red-600 text-xs font-semibold">Stok Habis</span>';

                // Harga dan diskon berdampingan
                let hargaHTML = '';
                if (diskon > 0 && hargaDiskon < harga) {
                    hargaHTML = `
                        <div class="flex justify-center items-center gap-1 md:gap-2 truncate">
                            <p class="text-gray-400 line-through text-[10px] md:text-xs">${formatRupiah(harga)}</p>
                            <p class="text-red-600 font-bold text-[10px] md:text-sm">${formatRupiah(hargaDiskon)} 
                                <span class="text-[10px] md:text-xs text-red-500">(${diskon}%)</span>
                            </p>
                        </div>
                        `;
                } else {
                    hargaHTML = `<p class="text-black font-bold text-[10px] md:text-sm">${formatRupiah(harga)}</p>`;
                }

                const modalCartId = `productModal-${prod.id}`;
                const modalBeliId = `productBeliModal-${prod.id}`;

                const card = `
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 w-full text-center">
                        <div class="relative">
                            <img src="${foto}" alt="${nama}" class="w-full h-40 max-h-40 object-cover bg-gray-50">
                            ${renderDiskonBadge(diskon)}
                        </div>
                        <div class="p-2 space-y-1">
                            <h4 class="font-bold text-gray-800 text-[12px] md:text-sm truncate">${nama}</h4>
                            ${hargaHTML}
                            <div class="pt-0 md:pt-1 border-t flex justify-center text-[10px] md:text-xs">
                                ${stokStatus}
                            </div>
                            ${jumlah > 0
                        ? `<div class="flex gap-1 mt-2 justify-center">
                                       <button onclick="openModal('${modalCartId}')" class="bg-gray-600 hover:bg-gray-200 text-white font-semibold py-2 px-2 rounded-lg text-xs flex items-center gap-1">
                                           <i class="fa-solid fa-cart-shopping text-xs"></i>
                                       </button>
                                       <button onclick="openModal('${modalBeliId}')" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 w-full rounded-lg text-xs">
                                           Beli
                                       </button>
                                   </div>`
                        : `<button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-1 rounded text-xs mt-2">
                                       Stok Habis
                                   </button>`}
                        </div>
                    </div>
                    `;

                resultsGrid.insertAdjacentHTML('beforeend', card);
            });

            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

        // ==========================
        // Format Rupiah
        // ==========================
        function formatRupiah(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }

        // Export displayResults supaya bisa dipanggil di fetchSearchResults
        window.displayResults = displayResults;
    });
</script>