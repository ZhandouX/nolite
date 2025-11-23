<div class="left-header">
    <button id="menuBtn"
        class="-ml-4 md:ml-0 flex items-center justify-center w-8 h-8 cursor-pointer rounded-lg hover:bg-white/10 transition-all duration-300">
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
            <div id="loadingState" class="hidden flex-col text-center items-center justify-center py-12">
                <div class="relative">
                    <div class="animate-spin rounded-full h-12 w-12 border-2 border-gray-300 border-t-gray-600 mx-auto">
                    </div>
                    <i
                        class="fa-solid fa-magnifying-glass absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-gray-600 text-sm"></i>
                </div>
                <p class="mt-4 text-gray-500 text-sm font-medium">Mencari produk...</p>
            </div>

            <!-- NO RESULTS -->
            <div id="noResults" class="hidden flex flex-col items-center justify-center py-6 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-search text-3xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 font-medium mb-2">Produk tidak ditemukan</p>
                <p class="text-gray-400 text-sm text-center">Coba kata kunci lain atau periksa ejaan</p>
            </div>

            <!-- RESULTS GRID -->
            <div id="resultsGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 justify-items-center gap-4 p-4">
                <!-- JS VIEW -->
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