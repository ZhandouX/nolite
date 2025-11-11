@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-linear-to-br from-gray-50 via-blue-50 to-indigo-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @include('layouts.partials_admin.statistik_charts.statistik')

            {{-- CHART PENDAPATAN --}}
            @include('layouts.partials_admin.statistik_charts.chart')

            {{-- PESANAN TERBARU --}}
            @include('layouts.partials_admin.tables.pesanan')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                {{-- SIDEBAR --}}
                <div class="space-y-6">

                    {{-- PRODUK TERLARIS --}}
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-8 bg-linear-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                                <h2 class="text-lg font-bold text-gray-900">Produk Terlaris</h2>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            @forelse($produkTerlaris as $index => $produk)
                                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <div class="shrink-0 relative">
                                        @if ($produk->fotos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}"
                                                alt="{{ $produk->nama_produk }}"
                                                class="w-14 h-14 rounded-xl object-cover ring-2 ring-gray-100 group-hover:ring-blue-200 transition-all">
                                            <div
                                                class="absolute -top-2 -left-2 w-6 h-6 bg-linear-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg">
                                                {{ $index + 1 }}
                                            </div>
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate mb-1">{{ $produk->nama_produk }}
                                        </p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                                {{ $produk->total_terjual ?? 0 }} terjual
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">IDR
                                            {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p class="text-sm text-gray-500">Belum ada data</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- QUICK ACTIONS --}}
                    <div class="bg-linear-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6">
                        <h2 class="text-lg text-white font-bold mb-1">Aksi Cepat</h2>
                        <p class="text-sm text-blue-100 mb-6">Kelola toko Anda dengan mudah</p>

                        <div class="space-y-3">
                            <a href="{{ route('admin.produk.create') }}"
                                class="flex items-center justify-between p-4 text-white rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all group border border-white/20">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-white">Tambah Produk</span>
                                </div>
                                <svg class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('admin.order.index') }}"
                                class="flex items-center justify-between p-4 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all group border border-white/20">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-white">Kelola Pesanan</span>
                                </div>
                                <svg class="w-5 h-5 text-white group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('admin.produk.index') }}"
                                class="flex items-center justify-between p-4 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm transition-all group border border-white/20">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-semibold text-white">Lihat Produk</span>
                                </div>
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform text-white" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bulanLabels = @json($bulanLabels);
            const pendapatanData = @json($pendapatanData);
            const penggunaData = @json($penggunaData);

            // Grafik Penjualan
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: bulanLabels,
                    datasets: [{
                        label: 'Penjualan',
                        data: pendapatanData,
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true },
                        x: {}
                    }
                }
            });

            // Grafik Pengguna
            const usersCtx = document.getElementById('usersChart').getContext('2d');
            new Chart(usersCtx, {
                type: 'bar',
                data: {
                    labels: bulanLabels,
                    datasets: [{
                        label: 'Pengguna Baru',
                        data: penggunaData,
                        backgroundColor: 'rgba(14, 165, 233, 0.7)',
                        borderColor: '#0ea5e9',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' } },
                    scales: {
                        y: { beginAtZero: true },
                        x: {}
                    }
                }
            });

            // Animasi untuk grafik saat dimuat
            const charts = document.querySelectorAll('.chart-loading');
            charts.forEach(chart => {
                setTimeout(() => {
                    chart.classList.add('chart-loaded');
                }, 300);
            });
        });
    </script>
@endpush