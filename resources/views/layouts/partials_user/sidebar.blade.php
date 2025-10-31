<!-- SIDEBAR -->
<div id="sidebar"
    class="fixed top-0 left-0 w-[250px] h-full bg-white text-black transform -translate-x-full transition-transform duration-300 ease-in-out z-[200]">

    <!-- HEADER LOGO -->
    <div class="w-full bg-black flex items-center justify-between px-4 py-4 border-b border-gray-700">
        <div class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite"
                class="w-10 h-10 object-contain" />
            <h2 class="text-base font-semibold text-white">Nolite Aspiciens</h2>
        </div>
        <button id="closeSidebar"
            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-800 text-white hover:text-white transition">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
    </div>

    <!-- NAVIGATION -->
    <nav class="flex-1 p-3 overflow-y-auto bg-white">
        <ul class="space-y-1">
            <!-- BERANDA -->
            <li>
                <a href="{{ route('customer.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200 hover:text-gray-900 transition">
                    <i class="fa-solid fa-house w-5 text-base"></i>
                    <span>Beranda</span>
                </a>
            </li>

            <!-- PRODUK -->
            <li>
                <a href="{{ route('customer.allProduk') }}"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200 hover:text-gray-900 transition">
                    <i class="fa-solid fa-shirt w-5 text-base"></i>
                    <span>Produk</span>
                </a>
            </li>

            <!-- KATEGORI DROPDOWN -->
            <li class="relative group">
                <button type="button"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200 hover:text-gray-900 transition w-full">
                    <i class="fa-solid fa-layer-group w-5 text-base"></i>
                    <span>Kategori</span>
                    <i class="fa-solid fa-chevron-down text-xs ml-auto transition-transform group-hover:rotate-180"></i>
                </button>

                <!-- DROPDOWN MENU -->
                <ul
                    class="hidden group-hover:block mt-1 ml-0 space-y-1 bg-gray-50 rounded-lg p-1 border border-gray-200">
                    <li>
                        <a href="{{ route('customer.kategori-tshirt') }}"
                            class="flex items-center px-4 py-2.5 pl-12 text-sm text-gray-600 rounded-md hover:bg-white hover:text-gray-900 transition">
                            T-Shirt
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.kategori-hoodie') }}"
                            class="flex items-center px-4 py-2.5 pl-12 text-sm text-gray-600 rounded-md hover:bg-white hover:text-gray-900 transition">
                            Hoodie
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.kategori-jersey') }}"
                            class="flex items-center px-4 py-2.5 pl-12 text-sm text-gray-600 rounded-md hover:bg-white hover:text-gray-900 transition">
                            Jersey
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>