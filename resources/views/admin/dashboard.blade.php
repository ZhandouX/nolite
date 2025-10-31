@extends('layouts.admin_app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- STATS CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                {{-- TOTAL PRODUK --}}
                <div class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Produk</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalProduk }}</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            Stok: {{ $stokTersedia }} unit
                        </div>
                    </div>
                </div>

                {{-- TOTAL PESANAN --}}
                <div class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-3 shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">Orders</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Pesanan</p>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalPesanan }}</p>
                        <div class="flex items-center text-xs">
                            <span class="text-green-600 font-semibold bg-green-50 px-2 py-0.5 rounded">
                                ↗ Bulan ini
                            </span>
                        </div>
                    </div>
                </div>

                {{-- PENDAPATAN --}}
                <div class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-3 shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">Revenue</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-900 mb-2">
                            IDR {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </p>
                        <div class="text-xs text-gray-500">
                            Total keseluruhan
                        </div>
                    </div>
                </div>

                {{-- PESANAN MENUNGGU (PENDING) --}}
                <div class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-3 shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-3 py-1 rounded-full animate-pulse">Pending</span>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pesanan Pending</p>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ $pesananPending }}</p>
                        <div class="text-xs">
                            <span class="text-orange-600 font-semibold">⚠ Perlu ditindaklanjuti</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHART PENDAPATAN --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Grafik Pendapatan</h2>
                        <p class="text-sm text-gray-500 mt-1">Tren pendapatan 12 bulan terakhir</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-lg">12 Bulan</span>
                    </div>
                </div>
                <div class="relative">
                    <canvas id="pendapatanChart" height="100"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- PESANAN TERBARU --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Pesanan Terbaru</h2>
                                <p class="text-sm text-gray-500 mt-1">Daftar pesanan yang baru masuk</p>
                            </div>
                            <a href="{{ route('admin.order.index') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors font-medium text-sm">
                                Lihat Semua
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($pesananTerbaru as $pesanan)
                                    <tr class="hover:bg-blue-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-blue-600">#{{ $pesanan->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3">
                                                    {{ substr($pesanan->nama_penerima, 0, 1) }}
                                                </div>
                                                <span class="text-sm font-medium text-gray-900">{{ $pesanan->nama_penerima }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-900">IDR {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($pesanan->status == 'pending')
                                                <span class="px-3 py-1.5 inline-flex text-xs font-bold rounded-lg bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                                                    Pending
                                                </span>
                                            @elseif($pesanan->status == 'selesai')
                                                <span class="px-3 py-1.5 inline-flex text-xs font-bold rounded-lg bg-green-100 text-green-700 border border-green-200">
                                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="px-3 py-1.5 inline-flex text-xs font-bold rounded-lg bg-blue-100 text-blue-700 border border-blue-200">
                                                    {{ ucfirst($pesanan->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-500">Belum ada pesanan</p>
                                                <p class="text-xs text-gray-400 mt-1">Pesanan baru akan muncul di sini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <div class="space-y-6">
                    
                    {{-- PRODUK TERLARIS --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-8 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                                <h2 class="text-lg font-bold text-gray-900">Produk Terlaris</h2>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            @forelse($produkTerlaris as $index => $produk)
                                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <div class="flex-shrink-0 relative">
                                        @if ($produk->fotos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}"
                                                alt="{{ $produk->nama_produk }}" 
                                                class="w-14 h-14 rounded-xl object-cover ring-2 ring-gray-100 group-hover:ring-blue-200 transition-all">
                                            <div class="absolute -top-2 -left-2 w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg">
                                                {{ $index + 1 }}
                                            </div>
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate mb-1">{{ $produk->nama_produk }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                                {{ $produk->total_terjual ?? 0 }} terjual
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">IDR {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">Belum ada data</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6">
                        <h2 class="text-lg text-white font-bold mb-1">Aksi Cepat</h2>
                        <p class="text-sm text-blue-100 mb-6">Kelola toko Anda dengan mudah</p>
                        
                        <div class="space-y-3">
                            <a href="{{ route('admin.produk.create') }}"
                                class="flex items-center justify-between p-4 text-white rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all group border border-white/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-white">Tambah Produk</span>
                                </div>
                                <svg class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('admin.order.index') }}"
                                class="flex items-center justify-between p-4 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all group border border-white/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-white">Kelola Pesanan</span>
                                </div>
                                <svg class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('admin.produk.index') }}"
                                class="flex items-center justify-between p-4 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all group border border-white/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-white">Lihat Produk</span>
                                </div>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pendapatanChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
        
        const pendapatanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($bulanLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($pendapatanData),
                    borderColor: '#3b82f6',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointHoverBackgroundColor: '#3b82f6',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { 
                        display: false 
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        displayColors: false,
                        callbacks: {
                            label: function (context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            callback: function (value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID', {
                                    notation: 'compact',
                                    compactDisplay: 'short'
                                }).format(value);
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush