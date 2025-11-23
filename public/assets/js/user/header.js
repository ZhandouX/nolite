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
            const response = await fetch(`${window.Navbar.routes.searchProduk}?q=${encodeURIComponent(query)}`);
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
                            <div class="flex items-baseline gap-0">
                                <span class="text-xs font-medium text-gray-500">
                                    Rp
                                </span>
                                <span class="text-sm font-bold text-red-900">
                                    ${formatRupiah(hargaDiskon)}
                                </span>
                                <span class="ml-1 text-[10px] text-gray-400 line-through">
                                    Rp${formatRupiah(harga)}
                                </span>
                            </div>
                        </div>
                    `;
            } else {
                hargaHTML = `
                        <p class="flex items-baseline gap-0 mb-1">
                            <span class="text-xs font-medium text-gray-500">
                                Rp
                            </span>
                            <span class="text-sm font-bold text-gray-900">
                                ${formatRupiah(harga)}
                            </span>    
                        </p>`;
            }

            const modalCartId = `productModal-${prod.id}`;
            const modalBeliId = `productBeliModal-${prod.id}`;

            const card = `
                    <div class="product-cards bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 w-full text-center">
                        <div class="relative overflow-hidden">
                            <img src="${foto}" alt="${nama}" 
                                class="w-full h-40 max-h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                            ${diskon > 0 ? `
                                <div class="absolute top-3 right-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg">
                                    -${diskon}%
                                </div>
                            ` : ''}
                        </div>
                        <div class="p-2 space-y-1">
                            <h4 class="font-bold text-gray-800 text-xs truncate">${nama}</h4>
                                ${hargaHTML}
                            <div class="flex justify-center pt-0 md:pt-1 text-[10px] md:text-xs">
                                ${stokStatus}
                            </div>
                            ${jumlah > 0 ? `
                                <div class="flex gap-1 mt-2 justify-center">
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

document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("menuBtn");
    const closeSidebar = document.getElementById("closeSidebar");
    const sidebar = document.getElementById("sidebar");
    const headerLogo = document.getElementById("headerLogo");

    // Saat tombol menu diklik → buka sidebar dan sembunyikan logo
    if (menuBtn) {
        menuBtn.addEventListener("click", function () {
            sidebar.classList.remove("-translate-x-full");
            sidebar.classList.add("translate-x-0");

            // Sembunyikan logo
            headerLogo.classList.add("opacity-0", "pointer-events-none");
        });
    }

    // Saat tombol closeSidebar diklik → tutup sidebar dan tampilkan logo
    if (closeSidebar) {
        closeSidebar.addEventListener("click", function () {
            sidebar.classList.add("-translate-x-full");
            sidebar.classList.remove("translate-x-0");

            // Tampilkan lagi logo
            headerLogo.classList.remove("opacity-0", "pointer-events-none");
        });
    }
});