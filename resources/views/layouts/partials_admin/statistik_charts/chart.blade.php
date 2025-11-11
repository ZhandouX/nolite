<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Statistik Penjualan</h3>
            <div class="flex space-x-2">
                <button
                    class="px-3 py-1 text-xs bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-lg">Bulanan</button>
                <button
                    class="px-3 py-1 text-xs text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Tahunan</button>
            </div>
        </div>
        <div class="h-80">
            <canvas id="salesChart" class="chart-loading"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Statistik Pengguna</h3>
            <div class="flex space-x-2">
                <button
                    class="px-3 py-1 text-xs bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-lg">Bulanan</button>
                <button
                    class="px-3 py-1 text-xs text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Tahunan</button>
            </div>
        </div>
        <div class="h-80">
            <canvas id="usersChart" class="chart-loading"></canvas>
        </div>
    </div>
</div>