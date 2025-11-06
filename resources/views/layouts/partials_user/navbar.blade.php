<div class="left-header">
    <span id="menuBtn" class="cursor-pointer text-2xl">&#9776;</span>
</div>

<div id="headerLogo" class="logo flex items-center gap-2">
    <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite"
        class="logo-img w-8 h-8 object-contain" />
    <span class="text-white font-semibold">Nolite Aspiciens</span>
</div>

<nav class="nav-icons flex items-center gap-5 relative">
    <!-- SEARCH SECTION -->
    <div class="relative flex items-center">
        <!-- INPUT SEARCH (Initially Hidden) -->
        <input id="searchInput" type="text" placeholder="Cari produk..."
            class="absolute right-0 w-0 opacity-0 transition-all duration-300 ease-in-out px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400 bg-white text-gray-800 z-[150]">

        <!-- SEARCH BUTTON -->
        <button id="searchButton" type="button"
            class="text-white hover:text-gray-400 transition relative z-[160] ml-auto">
            <i data-lucide="search" class="w-6 h-6"></i>
        </button>
    </div>

    <!-- SEARCH RESULTS CONTAINER -->
    <div id="searchResults"
        class="fixed top-20 left-0 right-0 mx-auto max-w-6xl bg-white shadow-2xl rounded-2xl p-6 z-[140] hidden overflow-y-auto max-h-[80vh]">
        <!-- CLOSE BUTTON -->
        <button id="closeSearch" type="button" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-circle-xmark text-2xl"></i>
        </button>

        <!-- RESULTS HEADER -->
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Hasil Pencarian</h3>

        <!-- LOADING STATE -->
        <div id="loadingState" class="hidden text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-gray-900 mx-auto"></div>
            <p class="mt-4 text-gray-600">Mencari produk...</p>
        </div>

        <!-- NO RESULTS STATE -->
        <div id="noResults" class="hidden text-center py-8">
            <i class="fa-solid fa-search text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg">Produk tidak ditemukan</p>
        </div>

        <!-- RESULTS GRID -->
        <div id="resultsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Results will be inserted here dynamically -->
        </div>
    </div>

    <!-- OVERLAY -->
    <div id="searchOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-[130] hidden"></div>



    @php
        if (Auth::check()) {
            $jumlahKeranjang = \App\Models\Keranjang::where('user_id', Auth::id())->count();
        } else {
            $jumlahKeranjang = count(session('keranjang', []));
        }
    @endphp

    <!-- KERANJANG -->
    <a href="{{ route('keranjang.index') }}" class="text-white hover:text-gray-400 transition relative">
        <i data-lucide="shopping-cart" class="w-6 h-6"></i>
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
                <i data-lucide="user" class="w-5 h-5"></i>
            </a>
        @else
            <button type="button" onclick="openLoginModal()"
                class="text-white hover:text-gray-400 transition flex items-center justify-center w-8 h-8 rounded-full">
                <i data-lucide="user" class="w-5 h-5"></i>
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
                searchInput.classList.remove('w-0', 'opacity-0');
                searchInput.classList.add('w-64', 'opacity-100');
                searchInput.focus();
                isSearchOpen = true;
            } else if (searchInput.value.trim().length >= 2) {
                // Jika sedang terbuka dan ada teks, tampilkan hasil
                searchResults.classList.remove('hidden');
                searchOverlay.classList.remove('hidden');
            } else {
                closeSearchResults();
            }
        });

        // ==========================
        // Ketika mengetik
        // ==========================
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length >= 2) {
                // tampilkan UI pencarian
                loadingState.classList.remove('hidden');
                resultsGrid.classList.add('hidden');
                noResults.classList.add('hidden');
                searchResults.classList.remove('hidden');
                searchOverlay.classList.remove('hidden');

                searchTimeout = setTimeout(() => fetchSearchResults(query), 500);
            } else {
                // Jangan tutup input, cukup sembunyikan hasil
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

        // ==========================
        // Tampilkan hasil pencarian
        // ==========================
        function displayResults(products) {
            resultsGrid.innerHTML = '';

            products.forEach(prod => {
                // Antisipasi null/undefined
                const foto = prod.foto ? prod.foto : '/assets/images/no-image.png';
                const nama = prod.nama_produk || 'Produk Tanpa Nama';
                const harga = parseFloat(prod.harga) || 0;
                const diskon = parseFloat(prod.diskon) || 0;
                const jumlah = parseInt(prod.jumlah) || 0;

                const hargaDiskon = diskon > 0
                    ? harga - (harga * diskon / 100)
                    : harga;

                const stokStatus = jumlah > 0
                    ? '<span class="text-green-600 text-sm font-semibold">Tersedia</span>'
                    : '<span class="text-red-600 text-sm font-semibold">Stok Habis</span>';

                const hargaHTML = diskon > 0
                    ? `<div class="space-y-1">
                <p class="text-gray-400 text-sm line-through">IDR ${formatRupiah(harga)}</p>
                <div class="flex items-center gap-2">
                    <p class="text-red-600 font-bold text-lg">IDR ${formatRupiah(hargaDiskon)}</p>
                    <span class="bg-red-100 text-red-600 text-xs font-semibold px-2 py-0.5 rounded">${diskon}%</span>
                </div>
            </div>`
                    : `<p class="text-gray-800 font-bold text-lg">IDR ${formatRupiah(harga)}</p>`;

                const card = `
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative">
                <img src="${foto}" 
                     alt="${nama}"
                     class="w-full h-48 object-contain bg-gray-50 p-4">
                ${diskon > 0 ? `<div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">DISKON ${diskon}%</div>` : ''}
            </div>
            <div class="p-4 space-y-3">
                <h4 class="font-bold text-gray-800 text-base line-clamp-2 h-12">${nama}</h4>
                ${hargaHTML}
                <div class="flex items-center justify-between pt-2 border-t">
                    ${stokStatus}
                </div>
                ${jumlah > 0 ? `
                <div class="flex gap-2 mt-4">
                    <button 
                        onclick="openModal('productModal-${prod.id}')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 rounded-lg transition flex items-center justify-center gap-2"
                        title="Tambah ke Keranjang">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button 
                        onclick="openModal('productBeliModal-${prod.id}')"
                        class="flex-[2] bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 rounded-lg transition">
                        Beli Sekarang
                    </button>
                </div>` : `
                <button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-2 rounded-lg cursor-not-allowed">
                    Stok Habis
                </button>`}
            </div>
        </div>`;

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

        // ==========================
        // Tutup Search
        // ==========================
        function closeSearchResults() {
            searchResults.classList.add('hidden');
            searchOverlay.classList.add('hidden');
            searchInput.classList.remove('w-64', 'opacity-100');
            searchInput.classList.add('w-0', 'opacity-0');
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
    });
</script>