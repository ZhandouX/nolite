@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div
                        class="shrink-0 h-12 w-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-chart-bar text-white text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Manajemen Laporan Terpadu
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Analisis dan ekspor data bisnis dalam berbagai format
                        </p>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-8 transition-all duration-300">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="fa-solid fa-filter text-primary-500 mr-2"></i>
                    Filter Laporan
                </h3>

                <form id="formFilter" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    @csrf

                    <!-- Jenis Laporan -->
                    <div class="lg:col-span-4">
                        <label for="jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jenis Laporan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="jenis" name="jenis" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 appearance-none">
                                <option value="">-- Pilih Jenis Laporan --</option>
                                <option value="penjualan">💰 Penjualan</option>
                                <option value="produk">🏷️ Produk</option>
                                <option value="pengguna">👥 Pengguna</option>
                                <option value="pesanan">🚚 Pesanan</option>
                                <option value="keuangan">🧾 Keuangan</option>
                                <option value="stok">📦 Stok</option>
                                <option value="ulasan">⭐ Ulasan</option>
                                <option value="aktivitas">📈 Aktivitas Admin</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Awal -->
                    <div class="lg:col-span-3">
                        <label for="tanggal_awal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dari Tanggal
                        </label>
                        <div class="relative">
                            <input type="date" id="tanggal_awal" name="tanggal_awal"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fa-solid fa-calendar text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="lg:col-span-3">
                        <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Sampai Tanggal
                        </label>
                        <div class="relative">
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fa-solid fa-calendar text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tampilkan -->
                    <div class="lg:col-span-2 flex items-end">
                        <button type="submit"
                            class="w-full h-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex items-center justify-center">
                            <i class="fa-solid fa-eye mr-2"></i>
                            Tampilkan
                        </button>
                    </div>
                </form>

                <!-- Tombol Ekspor -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row gap-3">
                    <button id="btnPdf"
                        class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <i class="fa-solid fa-file-pdf mr-2"></i>
                        Ekspor PDF
                    </button>
                    <button id="btnExcel"
                        class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <i class="fa-solid fa-file-excel mr-2"></i>
                        Ekspor Excel
                    </button>
                </div>
            </div>

            <!-- Grafik Section -->
            <div id="chartContainer"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-8 transition-all duration-300 hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 id="chartTitle" class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-chart-line text-primary-500 mr-2"></i>
                        Grafik Laporan
                    </h3>
                    <button id="chartFullscreen"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                        <i class="fa-solid fa-expand"></i>
                    </button>
                </div>
                <div class="h-80">
                    <canvas id="laporanChart"></canvas>
                </div>
            </div>

            <!-- Hasil Data Section -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-table text-primary-500 mr-2"></i>
                        Hasil Data
                    </h3>
                </div>

                <div class="p-6">
                    <div id="hasilLaporan" class="transition-all duration-300">
                        <div class="text-center py-12">
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fa-solid fa-chart-bar text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                Pilih Jenis Laporan
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                                Silakan pilih jenis laporan dan filter untuk melihat hasil analisis data.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Modal untuk Grafik -->
    <div id="fullscreenModal"
        class="fixed inset-0 bg-black bg-opacity-75 hidden justify-center items-center z-50 transition-opacity duration-300 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full h-full max-w-6xl max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 id="fullscreenChartTitle" class="text-xl font-semibold text-gray-900 dark:text-white"></h3>
                <button id="closeFullscreen"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            <div class="flex-1 p-6">
                <canvas id="fullscreenChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chart;
        let fullscreenChart;

        // Format Rupiah
        function formatRupiah(angka) {
            if (!angka) return '-';
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Format Tanggal
        function formatTanggal(tgl) {
            if (!tgl) return '-';
            const date = new Date(tgl);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }

        // Get Chart Colors based on theme
        function getChartColors() {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                background: isDark ? [
                    'rgba(59, 130, 246, 0.6)',
                    'rgba(16, 185, 129, 0.6)',
                    'rgba(245, 158, 11, 0.6)',
                    'rgba(239, 68, 68, 0.6)',
                    'rgba(139, 92, 246, 0.6)',
                    'rgba(14, 165, 233, 0.6)',
                ] : [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 205, 86, 0.6)',
                ],
                border: isDark ? [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(139, 92, 246, 1)',
                    'rgba(14, 165, 233, 1)',
                ] : [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 205, 86, 1)',
                ]
            };
        }

        // Get Chart Options
        function getChartOptions(jenis) {
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#f8fafc' : '#1f2937';
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

            const baseOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: textColor,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: isDark ? '#1f2937' : '#ffffff',
                        titleColor: textColor,
                        bodyColor: textColor,
                        borderColor: isDark ? '#374151' : '#d1d5db',
                        borderWidth: 1
                    }
                }
            };

            if (jenis === 'keuangan') {
                return baseOptions;
            }

            return {
                ...baseOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: textColor
                        }
                    },
                    x: {
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            color: textColor
                        }
                    }
                }
            };
        }

        // Initialize Chart
        function initChart(jenis, chartData) {
            const ctx = document.getElementById('laporanChart').getContext('2d');
            const colors = getChartColors();

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: jenis === 'keuangan' ? 'doughnut' : 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: chartData.label || 'Jumlah',
                        data: chartData.values,
                        backgroundColor: colors.background,
                        borderColor: colors.border,
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: getChartOptions(jenis)
            });
        }

        // Initialize Fullscreen Chart
        function initFullscreenChart(jenis, chartData) {
            const ctx = document.getElementById('fullscreenChart').getContext('2d');
            const colors = getChartColors();

            if (fullscreenChart) {
                fullscreenChart.destroy();
            }

            fullscreenChart = new Chart(ctx, {
                type: jenis === 'keuangan' ? 'doughnut' : 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: chartData.label || 'Jumlah',
                        data: chartData.values,
                        backgroundColor: colors.background,
                        borderColor: colors.border,
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    ...getChartOptions(jenis),
                    plugins: {
                        ...getChartOptions(jenis).plugins,
                        legend: {
                            position: 'top',
                            labels: {
                                color: getChartOptions(jenis).plugins.legend.labels.color,
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });
        }

        // Form Submission
        document.getElementById('formFilter').addEventListener('submit', function (e) {
            e.preventDefault();
            const jenis = document.getElementById('jenis').value;

            if (!jenis) {
                showNotification('Pilih jenis laporan terlebih dahulu', 'error');
                return;
            }

            const formData = new FormData(this);

            // Show loading state
            document.getElementById('hasilLaporan').innerHTML = `
                <div class="text-center py-12">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                        <i class="fa-solid fa-spinner fa-spin text-primary-600 dark:text-primary-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        Memuat Data
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        Sedang mengambil data laporan...
                    </p>
                </div>
            `;

            fetch("{{ route('admin.laporan.getData') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    const { data: resultData, chart: chartData } = data;

                    // Update Chart
                    if (chartData && chartData.labels && chartData.values) {
                        document.getElementById('chartContainer').classList.remove('hidden');
                        document.getElementById('chartTitle').textContent = chartData.title;
                        document.getElementById('fullscreenChartTitle').textContent = chartData.title;
                        initChart(jenis, chartData);
                    } else {
                        document.getElementById('chartContainer').classList.add('hidden');
                    }

                    // Update Table
                    let html = '';
                    if (!resultData || (Array.isArray(resultData) && resultData.length === 0)) {
                        html = `
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                <i class="fa-solid fa-search text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                Tidak ada data ditemukan
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                Tidak ada data yang sesuai dengan filter yang dipilih.
                            </p>
                        </div>
                    `;
                    } else if (Array.isArray(resultData)) {
                        html = `
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        ${Object.keys(resultData[0]).map(key =>
                            `<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                ${key.replace(/_/g, ' ').toUpperCase()}
                                            </th>`
                        ).join('')}
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    ${resultData.map(row => `
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                            ${Object.entries(row).map(([key, value]) => {
                            let displayValue = value;
                            if (key.includes('harga') || key.includes('subtotal') || key.includes('total')) {
                                displayValue = formatRupiah(value);
                            } else if (key.includes('created_at') || key.includes('updated_at')) {
                                displayValue = formatTanggal(value);
                            } else if (value === null || value === undefined) {
                                displayValue = '-';
                            }
                            return `<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${displayValue}</td>`;
                        }).join('')}
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                    } else if (typeof resultData === 'object') {
                        html = `
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    ${Object.entries(resultData).map(([key, value]) => {
                            let displayValue = value;
                            if (key.includes('harga') || key.includes('total')) {
                                displayValue = formatRupiah(value);
                            }
                            return `
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">
                                                    ${key.replace(/_/g, ' ').toUpperCase()}
                                                </th>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    ${displayValue}
                                                </td>
                                            </tr>
                                        `;
                        }).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                    }

                    document.getElementById('hasilLaporan').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('hasilLaporan').innerHTML = `
                    <div class="text-center py-12">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center">
                            <i class="fa-solid fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Terjadi Kesalahan
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            Gagal memuat data. Silakan coba lagi.
                        </p>
                    </div>
                `;
                    document.getElementById('chartContainer').classList.add('hidden');
                });
        });

        // Export PDF
        document.getElementById('btnPdf').addEventListener('click', function () {
            const jenis = document.getElementById('jenis').value;
            const tanggalAwal = document.getElementById('tanggal_awal').value;
            const tanggalAkhir = document.getElementById('tanggal_akhir').value;

            if (!jenis) {
                showNotification('Pilih jenis laporan terlebih dahulu', 'error');
                return;
            }

            let url = "{{ url('admin/laporan/export-pdf') }}/" + jenis;
            url += `?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
            window.open(url, '_blank');
        });

        // Export Excel
        document.getElementById('btnExcel').addEventListener('click', function () {
            const jenis = document.getElementById('jenis').value;
            const tanggalAwal = document.getElementById('tanggal_awal').value;
            const tanggalAkhir = document.getElementById('tanggal_akhir').value;

            if (!jenis) {
                showNotification('Pilih jenis laporan terlebih dahulu', 'error');
                return;
            }

            let url = "{{ url('admin/laporan/export-excel') }}/" + jenis;
            url += `?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
            window.location.href = url;
        });

        // Fullscreen Chart
        document.getElementById('chartFullscreen').addEventListener('click', function () {
            const chartContainer = document.getElementById('chartContainer');
            if (chartContainer.classList.contains('hidden')) return;

            const jenis = document.getElementById('jenis').value;
            const chartTitle = document.getElementById('chartTitle').textContent;

            document.getElementById('fullscreenChartTitle').textContent = chartTitle;
            document.getElementById('fullscreenModal').classList.remove('hidden');

            // Reinitialize chart for fullscreen
            setTimeout(() => {
                const chartData = {
                    labels: chart.data.labels,
                    values: chart.data.datasets[0].data,
                    label: chart.data.datasets[0].label
                };
                initFullscreenChart(jenis, chartData);
            }, 100);
        });

        // Close Fullscreen
        document.getElementById('closeFullscreen').addEventListener('click', function () {
            document.getElementById('fullscreenModal').classList.add('hidden');
        });

        // Notification Function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${type === 'error' ? 'bg-red-500 text-white' :
                    type === 'success' ? 'bg-green-500 text-white' :
                        'bg-blue-500 text-white'
                }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fa-solid ${type === 'error' ? 'fa-exclamation-circle' :
                    type === 'success' ? 'fa-check-circle' :
                        'fa-info-circle'
                } mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('opacity-0');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Add fade-in animation
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
            elements.forEach((el, index) => {
                el.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    el.classList.add('transition-all', 'duration-500');
                    el.classList.remove('opacity-0', 'translate-y-4');
                }, index * 100);
            });
        });
    </script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>

    <script>
        // Add custom scrollbar to tables
        document.addEventListener('DOMContentLoaded', function () {
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                table.closest('.overflow-x-auto')?.classList.add('custom-scrollbar');
            });
        });
    </script>
@endsection