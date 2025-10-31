<div class="left-header">
    <span id="menuBtn" class="cursor-pointer text-2xl">&#9776;</span>
</div>

<div class="logo flex items-center gap-2">
    <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite"
        class="logo-img w-8 h-8 object-contain" />
    <span class="text-white font-semibold">Nolite Aspiciens</span>
</div>

<nav class="nav-icons flex items-center gap-5 relative">
    <!-- SEARCH BUTTON -->
    <button id="searchButton" type="button" class="text-white hover:text-gray-400 transition relative z-[160]">
        <i data-lucide="search" class="w-6 h-6"></i>
    </button>

    <!-- SEARCH CONTAINER -->
    <div id="searchContainer" class="hidden bg-white shadow-xl absolute top-full right-0 mt-3 z-[150] border border-gray-200 rounded-xl 
           w-full sm:w-[600px] max-w-[95vw] overflow-hidden transform origin-top 
           transition-all duration-300 ease-out opacity-0 scale-y-0">

        <div class="p-3 sm:p-4 border-b border-gray-100">
            <input type="text" id="searchInput" placeholder="Cari produk..." class="w-full text-black border border-gray-300 rounded-lg px-3 py-2 text-sm sm:text-base
                   focus:ring-2 focus:ring-blue-400 outline-none" />
        </div>

        <!-- HASIL PENCARIAN -->
        <div id="searchResults"
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4 max-h-[60vh] overflow-y-auto w-full">
        </div>
    </div>

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
        <span id="cartBadge" class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5
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
        const searchContainer = document.getElementById('searchContainer');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const menuBtn = document.getElementById('menuBtn');

        // === Toggle sidebar ===
        menuBtn?.addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar?.classList.toggle('active');
        });

        // === Toggle search box ===
        searchButton.addEventListener('click', () => {
            const isHidden = searchContainer.classList.contains('hidden');
            if (isHidden) {
                searchContainer.classList.remove('hidden');
                requestAnimationFrame(() => {
                    searchContainer.classList.remove('opacity-0', 'scale-y-0');
                    searchContainer.classList.add('opacity-100', 'scale-y-100');
                });
                searchInput.focus();
            } else {
                searchContainer.classList.add('opacity-0', 'scale-y-0');
                searchContainer.classList.remove('opacity-100', 'scale-y-100');
                setTimeout(() => searchContainer.classList.add('hidden'), 200);
            }
        });

        // === Fungsi Membuat Modal Beli ===
        function createBeliModal(prod) {
            const hargaFinal = prod.diskon > 0 ? prod.harga - (prod.harga * prod.diskon / 100) : prod.harga;
            const foto = prod.fotos?.length ? `/storage/${prod.fotos[0].foto}` : '/assets/images/no-image.png';

            const modal = `
        <div id="productBeliModal-${prod.id}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
                <button onclick="closeModal('productBeliModal-${prod.id}')" class="absolute top-3 right-3 text-2xl">&times;</button>
                <div class="flex items-center gap-4 mb-5 mt-5 bg-gray-100 rounded-lg p-2">
                    <img src="${foto}" alt="${prod.nama_produk}" class="w-20 h-20 object-contain rounded-lg">
                    <div>
                        <p class="font-bold text-black">${prod.nama_produk}</p>
                        <p class="text-red-800 font-bold">IDR ${hargaFinal.toLocaleString('id-ID')}</p>
                        <p class="text-sm text-gray-500">Stok: ${prod.jumlah}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <label>Jumlah:</label>
                    <input type="number" id="buyQty-${prod.id}" value="1" min="1" max="${prod.jumlah}" class="w-full text-center border rounded-lg">
                    <button onclick="alert('Checkout ${prod.nama_produk}')" class="w-full bg-gray-600 text-white py-2 rounded-lg">Beli Sekarang</button>
                </div>
            </div>
        </div>`;
            document.body.insertAdjacentHTML('beforeend', modal);
        }

        // === Fungsi Membuat Modal Cart ===
        function createCartModal(prod) {
            const hargaFinal = prod.diskon > 0 ? prod.harga - (prod.harga * prod.diskon / 100) : prod.harga;
            const foto = prod.fotos?.length ? `/storage/${prod.fotos[0].foto}` : '/assets/images/no-image.png';

            const modal = `
        <div id="productModal-${prod.id}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
                <button onclick="closeModal('productModal-${prod.id}')" class="absolute top-3 right-3 text-2xl">&times;</button>
                <div class="flex items-center gap-4 mb-5 mt-5 bg-gray-100 rounded-lg p-2">
                    <img src="${foto}" alt="${prod.nama_produk}" class="w-20 h-20 object-contain rounded-lg">
                    <div>
                        <p class="font-bold text-black">${prod.nama_produk}</p>
                        <p class="text-red-800 font-bold">IDR ${hargaFinal.toLocaleString('id-ID')}</p>
                        <p class="text-sm text-gray-500">Stok: ${prod.jumlah}</p>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <label>Jumlah:</label>
                    <input type="number" id="cartQty-${prod.id}" value="1" min="1" max="${prod.jumlah}" class="w-full text-center border rounded-lg">
                    <button onclick="alert('Tambah ${prod.nama_produk} ke keranjang')" class="w-full bg-gray-600 text-white py-2 rounded-lg">Tambahkan ke Keranjang</button>
                </div>
            </div>
        </div>`;
            document.body.insertAdjacentHTML('beforeend', modal);
        }

        // === Fungsi open/close modal ===
        window.openModal = function (id) {
            document.getElementById(id).classList.remove('hidden');
        }
        window.closeModal = function (id) {
            document.getElementById(id).classList.add('hidden');
        }

        // === Event input pencarian ===
        searchInput.addEventListener('input', async function () {
            const query = this.value.trim();
            searchResults.innerHTML = '';
            if (query.length < 2) return;

            try {
                const response = await fetch(`/search-produk?q=${encodeURIComponent(query)}`);
                const data = await response.json();

                if (!data.length) {
                    searchResults.innerHTML = `<p class="text-gray-500 col-span-full text-center">Tidak ada produk ditemukan.</p>`;
                    return;
                }

                data.forEach(prod => {
                    const foto = prod.fotos?.length ? `/storage/${prod.fotos[0].foto}` : '/assets/images/no-image.png';
                    const stok = prod.jumlah > 0 ? 'Tersedia' : 'Habis';
                    const hargaHTML = prod.diskon > 0
                        ? `
            <p class="text-red-500 font-bold text-sm">
                IDR ${(prod.harga - prod.harga * prod.diskon / 100).toLocaleString('id-ID')}
            </p>
            <p class="text-gray-400 line-through text-xs">
                IDR ${prod.harga.toLocaleString('id-ID')}
            </p>
        `
                        : `<p class="text-black font-bold text-sm">
                IDR ${prod.harga.toLocaleString('id-ID')}
           </p>`;

                    const card = `
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition 
                flex flex-col justify-between w-full">
        <a href="/produk/${prod.id}" class="block">
            <img src="${foto}" alt="${prod.nama_produk}" 
                 class="w-full h-40 sm:h-44 md:h-48 object-cover hover:opacity-90 transition" />
        </a>
        <div class="p-3 flex flex-col justify-between flex-grow">
            <h3 class="text-sm md:text-base font-semibold text-gray-800 truncate mb-1">
                ${prod.nama_produk}
            </h3>
            <div class="mb-1">${hargaHTML}</div>
            <span class="text-xs md:text-sm ${stok === 'Tersedia' ? 'text-green-600' : 'text-red-500'}">${stok}</span>
            <div class="mt-3 flex items-center gap-2">
                <button onclick="openModal('productModal-${prod.id}')"
                    class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-600 hover:bg-gray-400 text-white transition">
                    <i data-lucide='shopping-cart'></i>
                </button>
                <button onclick="openModal('productBeliModal-${prod.id}')"
                    class="flex-1 py-2 rounded-lg bg-gray-600 hover:bg-gray-400 text-white font-medium text-sm transition">
                    Beli
                </button>
            </div>
        </div>
    </div>`;


                    searchResults.insertAdjacentHTML('beforeend', card);

                    // Tambahkan modal dinamis
                    createBeliModal(prod);
                    createCartModal(prod);
                });

                // Refresh ikon lucide
                lucide.createIcons();

            } catch (err) {
                console.error('Error:', err);
                searchResults.innerHTML = `<p class="text-red-500 col-span-full text-center">Terjadi kesalahan memuat data.</p>`;
            }
        });

        // === Klik di luar area menutup search box ===
        document.addEventListener('click', (e) => {
            if (!searchContainer.contains(e.target) && !searchButton.contains(e.target)) {
                searchContainer.classList.add('opacity-0', 'scale-y-0');
                searchContainer.classList.remove('opacity-100', 'scale-y-100');
                setTimeout(() => searchContainer.classList.add('hidden'), 200);
            }
        });
    });
</script>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal?.classList.remove('hidden');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal?.classList.add('hidden');
    }
</script>

<!-- ======================== RESPONSIVE STYLE ======================== -->

<style>
    #searchContainer {
        backdrop-filter: blur(6px);
    }

    @media (max-width: 768px) {
        .left-header span {
            font-size: 1.2rem;
        }

        .logo {
            font-size: 1rem;
            margin-left: 5.1rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* === SEARCH CONTAINER === */
        #searchContainer {
            position: absolute;
            top: 100%;
            right: 0;
            width: 250px;
            height: 400px;
            background: white;
            border-radius: 0.75rem;
            /* 12px */
            margin-top: 0.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            z-index: 999;
        }

        /* === SEARCH INPUT === */
        #searchContainer input {
            font-size: 0.9rem;
            width: 100%;
            height: 45px;
            padding: 0 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            outline: none;
        }

        /* === HASIL PENCARIAN === */
        #searchResults {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            padding: 0.75rem;
            overflow-y: auto;
            flex-grow: 1;
        }


        .logo-img {
            width: 1.2rem;
            height: 1.2rem;
        }

        .nav-icons {
            gap: 0.5rem;
        }

        .nav-icons i {
            width: 1rem;
            height: 1rem;
        }

        .nav-icons a,
        .nav-icons button {
            width: 1.2rem;
            height: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .nav-icons i[data-lucide="user"] {
            width: 0.9rem;
            height: 0.9rem;
            margin-right: 0;
        }

        .absolute {
            width: 0.9rem;
            height: 0.9rem;
            font-size: 0.55rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    }
</style>