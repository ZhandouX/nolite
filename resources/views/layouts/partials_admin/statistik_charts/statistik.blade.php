<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    {{-- TOTAL PENGGUNA --}}
    <div class="group p-4 md:p-5 border-b-4 border-blue-500 dark:border-blue-400 bg-gradient-to-r from-blue-50/50 to-transparent dark:from-blue-900/10 dark:to-transparent hover:from-blue-50 dark:hover:from-blue-900/20 transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1 md:mb-2">Total Pengguna</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-2 md:mb-3">{{ $totalPengguna }}</p>
                <div class="flex items-center text-xs md:text-sm">
                    <div class="flex items-center text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ $growthPengguna }}%</span>
                    </div>
                    <span class="text-gray-500 dark:text-gray-400 ml-2 hidden sm:inline">dari bulan lalu</span>
                </div>
            </div>
            <div class="p-2 md:p-3 bg-blue-100/50 dark:bg-blue-900/20 rounded-lg group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30 transition-colors">
                <i data-lucide="users" class="w-4 h-4 md:w-6 md:h-6 text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>

    {{-- TOTAL PENJUALAN --}}
    <div class="group p-4 md:p-5 border-b-4 border-green-500 dark:border-green-400 bg-gradient-to-r from-green-50/50 to-transparent dark:from-green-900/10 dark:to-transparent hover:from-green-50 dark:hover:from-green-900/20 transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1 md:mb-2">Total Penjualan</p>
                <p class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-2 md:mb-3">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                <div class="flex items-center text-xs md:text-sm">
                    <div class="flex items-center text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ $growthPenjualan }}%</span>
                    </div>
                    <span class="text-gray-500 dark:text-gray-400 ml-2 hidden sm:inline">dari bulan lalu</span>
                </div>
            </div>
            <div class="p-2 md:p-3 bg-green-100/50 dark:bg-green-900/20 rounded-lg group-hover:bg-green-100 dark:group-hover:bg-green-900/30 transition-colors">
                <i data-lucide="wallet" class="w-4 h-4 md:w-6 md:h-6 text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>

    {{-- TOTAL PESANAN --}}
    <div class="group p-4 md:p-5 border-b-4 border-purple-500 dark:border-purple-400 bg-gradient-to-r from-purple-50/50 to-transparent dark:from-purple-900/10 dark:to-transparent hover:from-purple-50 dark:hover:from-purple-900/20 transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1 md:mb-2">Total Pesanan</p>
                <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-2 md:mb-3">{{ $totalPesanan }}</p>
                <div class="flex items-center text-xs md:text-sm">
                    <div class="flex items-center text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ $growthPesanan }}%</span>
                    </div>
                    <span class="text-gray-500 dark:text-gray-400 ml-2 hidden sm:inline">dari bulan lalu</span>
                </div>
            </div>
            <div class="p-2 md:p-3 bg-purple-100/50 dark:bg-purple-900/20 rounded-lg group-hover:bg-purple-100 dark:group-hover:bg-purple-900/30 transition-colors">
                <i data-lucide="shopping-bag" class="w-4 h-4 md:w-6 md:h-6 text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
    </div>

    {{-- PENDAPATAN --}}
    <div class="group p-4 md:p-5 border-b-4 border-yellow-500 dark:border-yellow-400 bg-gradient-to-r from-yellow-50/50 to-transparent dark:from-yellow-900/10 dark:to-transparent hover:from-yellow-50 dark:hover:from-yellow-900/20 transition-all duration-300">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <p class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400 mb-1 md:mb-2">Pendapatan</p>
                <p class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-2 md:mb-3">Rp{{ number_format($pendapatan, 0, ',', '.') }}</p>
                <div class="flex items-center text-xs md:text-sm">
                    <div class="flex items-center text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ $growthPendapatan }}%</span>
                    </div>
                    <span class="text-gray-500 dark:text-gray-400 ml-2 hidden sm:inline">dari bulan lalu</span>
                </div>
            </div>
            <div class="p-2 md:p-3 bg-yellow-100/50 dark:bg-yellow-900/20 rounded-lg group-hover:bg-yellow-100 dark:group-hover:bg-yellow-900/30 transition-colors">
                <i data-lucide="circle-dollar-sign" class="w-4 h-4 md:w-6 md:h-6 text-yellow-600 dark:text-yellow-400"></i>
            </div>
        </div>
    </div>
</div>