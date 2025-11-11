<div id="sidebar" class="sidebar-transition bg-white dark:bg-gray-800 w-64 flex flex-col shadow-lg z-10 
            h-screen overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600">

    <!-- HEADER SIDEBAR (tetap di atas) -->
    <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700
                sticky top-0 bg-white dark:bg-gray-800 z-20">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Logo" class="w-6 h-6">
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800 dark:text-white">NoliteAspiciens</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 p-4">
        <ul class="space-y-2">
            {{-- DASHBOARD --}}
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg transition-all duration-150
                {{ request()->routeIs('admin.dashboard')
    ? 'bg-primary-50 dark:bg-gray-700 text-primary-700 dark:text-white font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>

            <li class="text-bold text-gray-500 text-sm dark:text-white/50 mt-4"><span>MANAJEMEN DATA</span></li>

            {{-- PRODUK --}}
            <li>
                <a href="{{ route('admin.produk.index') }}" class="flex items-center p-3 rounded-lg transition-all duration-150
                {{ request()->routeIs('admin.produk.*')
    ? 'bg-primary-50 dark:bg-gray-700 text-primary-700 dark:text-white font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700' }}">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span class="ml-3">Produk</span>
                </a>
            </li>

            {{-- PESANAN --}}
            <li>
                <a href="{{ route('admin.order.index') }}" class="flex items-center p-3 rounded-lg transition-all duration-150
                {{ request()->routeIs('admin.order.*')
    ? 'bg-primary-50 dark:bg-gray-700 text-primary-700 dark:text-white font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700' }}">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span class="ml-3">Pesanan</span>
                </a>
            </li>

            <li class="text-bold text-gray-500 text-sm dark:text-white/50 mt-4"><span>MANAJEMEN PENGGUNA</span></li>

            {{-- PENGGUNA --}}
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 rounded-lg transition-all duration-150
                {{ request()->routeIs('admin.users.*')
    ? 'bg-primary-50 dark:bg-gray-700 text-primary-700 dark:text-white font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700' }}">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="ml-3">Pengguna</span>
                </a>
            </li>

            {{-- CHAT --}}
            <li>
                <a href="{{ route('admin.chats.index') }}" class="flex items-center p-3 rounded-lg transition-all duration-150
                {{ request()->routeIs('admin.chats.*')
    ? 'bg-primary-50 dark:bg-gray-700 text-primary-700 dark:text-white font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700' }}">
                    <i data-lucide="messages-square" class="w-5 h-5"></i>
                    <span class="ml-3">Chat</span>
                </a>
            </li>

            {{-- CUSTOMER SERVICE --}}
            <li>
                <a href="{{ route('admin.customer-service.index') }}" class="flex items-center p-3 rounded-lg transition-all duration-150
                {{ request()->routeIs('admin.customer-service.*')
    ? 'bg-primary-50 dark:bg-gray-700 text-primary-700 dark:text-white font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700' }}">
                    <i data-lucide="headphones" class="w-5 h-5"></i>
                    <span class="ml-3">Customer Service</span>
                </a>
            </li>

            <li class="text-bold text-gray-500 text-sm dark:text-white/50 mt-4"><span>LAPORAN & ANALITIK</span></li>

            {{-- LAPORAN --}}
            <li>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center p-3 rounded-lg transition-all duration-150
                {{ request()->routeIs('admin.laporan.*')
    ? 'bg-primary-50 dark:bg-gray-700 text-primary-700 dark:text-white font-semibold'
    : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-gray-700' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    <span class="ml-3">Laporan</span>
                </a>
            </li>
        </ul>
    </nav>


    <!-- User Info -->
    <!-- <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            <img class="h-10 w-10 rounded-full"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt="Profile">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->nama ?? '' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? '' }}</p>
            </div>
        </div>
    </div> -->
</div>

<style>
    .sidebar-toggle svg {
        transition: transform 0.3s ease;
    }

    #sidebar {
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE / Edge lama */
    }

    #sidebar::-webkit-scrollbar {
        /* Chrome, Safari, Opera */
        display: none;
    }
</style>