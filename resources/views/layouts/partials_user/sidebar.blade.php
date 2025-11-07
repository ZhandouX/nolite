<style>
    @media (max-width: 640px) {
        #sidebar-inner .header-logo {
            padding-top: 8px;
            padding-bottom: 8px;
            height: 44px;
        }
    }

    /* Sidebar fix agar bisa scroll bagian atas tapi Chatbot tetap di bawah */
    #sidebar {
        display: flex;
        flex-direction: column;
    }

    #sidebar nav {
        flex: 1;
        overflow-y: auto;
        padding-bottom: 70px;
        /* beri ruang untuk menu chatbot bawah */
    }

    /* Bagian Chatbot tetap nempel di bawah */
    .sidebar-bottom {
        position: sticky;
        bottom: 0;
        background: white;
        border-top: 1px solid #e5e7eb;
        padding: 0.75rem;
    }

    .sidebar-bottom a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        border-radius: 0.5rem;
        transition: all 0.2s;
    }

    .sidebar-bottom a:hover {
        background-color: #e5e7eb;
        color: #111827;
    }
</style>

<!-- SIDEBAR -->
<div id="sidebar"
    class="sidebar-fix fixed top-0 left-0 w-[200px] md:w-[250px] h-full bg-white text-black transform -translate-x-full transition-transform duration-300 ease-in-out z-[200]">
    <div id="sidebar-inner" class="flex flex-col h-full">
        <!-- HEADER LOGO -->
        <div class="header-logo w-full bg-black flex items-center justify-between px-4 py-4 border-b border-gray-700">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo Nolite"
                    class="w-8 h-8 md:w-10 md:h-10 object-contain" />
                <h2 class="text-[12px] md:text-base font-semibold text-white">Nolite Aspiciens</h2>
            </div>
            <button id="closeSidebar"
                class="w-8 h-8 -mr-[12px] flex items-center justify-center rounded-lg hover:bg-gray-800 text-white hover:text-white transition">
                <i class="fa-solid fa-chevron-left text-[12px] md:text-lg"></i>
            </button>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex-1 p-3 overflow-y-auto bg-white">
            <ul class="space-y-1">
                <!-- BERANDA -->
                <li>
                    <a href="{{ route('customer.dashboard') }}"
                        class="flex items-center gap-3 px-2 py-1 md:px-4 md:py-3 text-[12px] md:text-sm text-gray-700 rounded-lg hover:bg-gray-200 hover:text-gray-900 transition">
                        <i class="fa-solid fa-house text-[14px] md:text-base"></i>
                        <span>Beranda</span>
                    </a>
                </li>

                <!-- PRODUK -->
                <li>
                    <a href="{{ route('customer.allProduk') }}"
                        class="flex items-center gap-3 px-2 py-1 md:px-4 md:py-3 text-[12px] md:text-sm text-gray-700 rounded-lg hover:bg-gray-200 hover:text-gray-900 transition">
                        <i class="fa-solid fa-shirt text-[14px] md:text-base"></i>
                        <span>Produk</span>
                    </a>
                </li>

                <!-- KATEGORI DROPDOWN -->
                <li class="relative group">
                    <button type="button"
                        class="flex items-center gap-3 px-2 py-1 md:px-4 md:py-3 text-[12px] md:text-sm text-gray-700 rounded-lg hover:bg-gray-200 hover:text-gray-900 transition w-full">
                        <i class="fa-solid fa-layer-group text-[14px] md:text-base"></i>
                        <span>Kategori</span>
                        <i
                            class="fa-solid fa-chevron-down text-xs ml-auto transition-transform group-hover:rotate-180"></i>
                    </button>

                    <!-- DROPDOWN MENU -->
                    <ul class="hidden group-hover:block mt-1 ml-0 space-y-1 bg-transparent rounded-lg p-1">
                        <li>
                            <a href="{{ route('customer.kategori-tshirt') }}"
                                class="flex items-center px-2 py-1.5 pl-10 text-[12px] md:px-4 md:py-2.5 md:pl-12 md:text-sm text-gray-600 rounded-md hover:bg-gray-600 hover:text-white transition">
                                T-Shirt
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.kategori-hoodie') }}"
                                class="flex items-center px-2 py-1.5 pl-10 text-[12px] md:px-4 md:py-2.5 md:pl-12 md:text-sm text-gray-600 rounded-md hover:bg-gray-600 hover:text-white transition">
                                Hoodie
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.kategori-jersey') }}"
                                class="flex items-center px-2 py-1.5 pl-10 text-[12px] md:px-4 md:py-2.5 md:pl-12 md:text-sm text-gray-600 rounded-md hover:bg-gray-600 hover:text-white transition">
                                Jersey
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- SIDEBAR BOTTOM -->
        <div class="sidebar-bottom flex items-center gap-3 p-3 bg-gray-100 rounded-lg">
            @auth
                <!-- Foto profil inisial -->
                <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-semibold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{-- Ambil inisial pertama --}}
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
                    <span class="text-sm text-gray-500">{{ Auth::user()->email }}</span>
                </div>
            @else
                <!-- Guest -->
                <div class="w-10 h-10 rounded-full bg-gray-400 flex items-center justify-center text-white font-semibold">
                    G
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-gray-800">Guest</span>
                    <span class="text-sm text-gray-500">Belum login</span>
                </div>
            @endauth
        </div>
    </div>
</div>