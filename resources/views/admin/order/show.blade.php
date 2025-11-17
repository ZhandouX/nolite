@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-screen mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div
                        class="shrink-0 h-12 w-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-receipt text-white text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Detail Pesanan
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Informasi lengkap pesanan <span class="bg-primary-500/20 font-bold ml-2 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-bl-lg rounded-tr-lg">#NA-ORD-{{ $order->id }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                <!-- Header Card -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-info-circle text-primary-500 mr-2"></i>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Ringkasan Pesanan
                            </h2>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <!-- Informasi Penerima & Status -->
                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <!-- Informasi Penerima -->
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div
                                    class="shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Informasi Penerima
                                    </h3>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Lengkap</span>
                                    <span
                                        class="text-sm text-gray-900 dark:text-white font-medium">{{ $order->nama_penerima ?? '-' }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Nomor Telepon</span>
                                    <span
                                        class="text-sm text-gray-900 dark:text-white font-medium">{{ $order->no_hp ?? '-' }}</span>
                                </div>
                                <div class="py-2">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block mb-2">Alamat
                                        Pengiriman</span>
                                    <div
                                        class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                        <p class="font-medium">{{ $order->provinsi ?? '-' }}, {{ $order->kota ?? '-' }}</p>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $order->alamat_detail ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Pesanan -->
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div
                                    class="shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                    <i class="fa-solid fa-truck text-green-600 dark:text-green-400"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Status Pesanan
                                    </h3>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <!-- Status Badge -->
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status Saat
                                        Ini</span>
                                    @php
                                        $statusConfig = [
                                            'menunggu' => ['color' => 'yellow', 'icon' => 'fa-clock'],
                                            'diproses' => ['color' => 'blue', 'icon' => 'fa-cog'],
                                            'dikirim' => ['color' => 'purple', 'icon' => 'fa-truck'],
                                            'selesai' => ['color' => 'green', 'icon' => 'fa-check-circle']
                                        ];
                                        $config = $statusConfig[$order->status] ?? ['color' => 'gray', 'icon' => 'fa-question'];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $config['color'] }}-100 dark:bg-{{ $config['color'] }}-900 text-{{ $config['color'] }}-800 dark:text-{{ $config['color'] }}-200 capitalize">
                                        <i class="fa-solid {{ $config['icon'] }} mr-1.5"></i>
                                        {{ $order->status }}
                                    </span>
                                </div>

                                <!-- Timeline Status -->
                                <div class="space-y-3">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Timeline</span>
                                    <div class="space-y-2">
                                        @foreach(['menunggu', 'diproses', 'dikirim', 'selesai'] as $status)
                                            <div class="flex items-center">
                                                <div class="shrink-0 w-6 h-6 rounded-full flex items-center justify-center 
                                                        @if(array_search($order->status, ['menunggu', 'diproses', 'dikirim', 'selesai']) >= array_search($status, ['menunggu', 'diproses', 'dikirim', 'selesai']))
                                                            bg-primary-500 text-white
                                                        @else
                                                            bg-gray-200 dark:bg-gray-700 text-gray-400
                                                        @endif">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                </div>
                                                <span
                                                    class="ml-3 text-sm text-gray-600 dark:text-gray-400 capitalize">{{ $status }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Produk -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="shrink-0 h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                <i class="fa-solid fa-box text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Daftar Produk
                                </h3>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div
                                    class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl transition-all duration-200 hover:shadow-sm">
                                    <div class="flex items-center space-x-4 flex-1">
                                        <!-- Foto Produk -->
                                        @if ($item->produk->fotos->isNotEmpty())
                                            <img src="{{ asset('storage/' . $item->produk->fotos->first()->foto) }}"
                                                class="w-16 h-16 rounded-lg object-cover border border-gray-200 dark:border-gray-600 shadow-sm"
                                                alt="{{ $item->produk->nama_produk }}">
                                        @else
                                            <div
                                                class="w-16 h-16 rounded-lg bg-gray-200 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 flex items-center justify-center">
                                                <i class="fa-solid fa-image text-gray-400 dark:text-gray-500"></i>
                                            </div>
                                        @endif

                                        <!-- Informasi Produk -->
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-white">
                                                {{ $item->produk->nama_produk ?? 'Produk tidak tersedia' }}
                                            </h4>
                                            <div
                                                class="flex items-center space-x-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-hashtag mr-1.5"></i>
                                                    {{ $item->jumlah }} pcs
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-tag mr-1.5"></i>
                                                    @if(!empty($item->diskon) && $item->diskon > 0)
                                                        <span class="line-through text-gray-400 mr-1">
                                                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                                                        </span>
                                                        <span class="text-red-600 dark:text-red-400 font-semibold">
                                                            Rp{{ number_format($item->harga_diskon, 0, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-900 dark:text-white font-semibold">
                                                            Rp{{ number_format($item->harga_diskon, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                            @if(!empty($item->diskon) && $item->diskon > 0)
                                                <div class="mt-1">
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                        <i class="fa-solid fa-percent mr-1"></i>
                                                        Diskon {{ $item->diskon }}%
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-primary-600 dark:text-primary-400">
                                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Subtotal</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ringkasan Pembayaran -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fa-solid fa-credit-card text-primary-500 mr-2"></i>
                            Ringkasan Pembayaran
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-white font-medium">
                                    Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            <div
                                class="flex justify-between items-center py-2 border-t border-gray-200 dark:border-gray-600 pt-4">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total Pembayaran</span>
                                <span class="text-xl font-bold text-primary-600 dark:text-primary-400">
                                    Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran</span>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                    <i class="fa-solid fa-wallet mr-1.5"></i>
                                    {{ $order->metode_pembayaran }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.order.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 order-2 sm:order-1">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>

                        <div class="flex gap-3 order-1 sm:order-2">
                            <button onclick="openModal('modal-{{ $order->id }}')"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-pen-to-square mr-2"></i>
                                Ubah Status
                            </button>

                            <a href="{{ route('admin.order.index') }}"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-list mr-2"></i>
                                Semua Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Status -->
    <div id="modal-{{ $order->id }}"
        class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 transition-opacity duration-300 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all duration-300 scale-95"
            @click.away="closeModal('modal-{{ $order->id }}')">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fa-solid fa-edit text-primary-500 mr-2"></i>
                    Ubah Status Pesanan
                </h3>
                <button onclick="closeModal('modal-{{ $order->id }}')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <div class="mb-4">
                <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div
                        class="shrink-0 h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                        <i class="fa-solid fa-receipt text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            Pesanan #{{ $order->id }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $order->nama_penerima }}
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Status Pesanan
                    </label>
                    <select name="status"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 appearance-none">
                        <option value="menunggu" {{ $order->status == 'menunggu' ? 'selected' : '' }}>
                            🕐 Menunggu
                        </option>
                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>
                            ⚙️ Diproses
                        </option>
                        <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>
                            🚚 Dikirim
                        </option>
                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>
                            ✅ Selesai
                        </option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('modal-{{ $order->id }}')"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.querySelector('.transform').classList.remove('scale-100');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('[id^="modal-"]');
                modals.forEach(modal => {
                    if (modal.classList.contains('flex')) {
                        closeModal(modal.id);
                    }
                });
            }
        });

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
    </style>
@endsection