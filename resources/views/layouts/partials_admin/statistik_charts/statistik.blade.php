<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- TOTAL PENGGUNA --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 animate-fade-in">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalPengguna }}</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ $growthPengguna }}% dari bulan lalu</span>
            </div>
        </div>
    </div>

    {{-- TOTAL PENJUALAN --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 animate-fade-in" style="animation-delay: 0.1s;">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Penjualan</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">IDR
                    {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ $growthPenjualan }}% dari bulan lalu</span>
            </div>
        </div>
    </div>

    {{-- TOTAL PESANAN --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pesanan</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalPesanan }}</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ $growthPesanan }}% dari bulan lalu</span>
            </div>
        </div>
    </div>

    {{-- PENDAPATAN --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 animate-fade-in" style="animation-delay: 0.3s;">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pendapatan</p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-white">IDR
                    {{ number_format($pendapatan, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="flex items-center text-sm text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span>{{ $growthPendapatan }}% dari bulan lalu</span>
            </div>
        </div>
    </div>
</div>