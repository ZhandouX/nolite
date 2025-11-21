@extends('layouts.app')

@section('title', 'Daftar Order')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-screen mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="shrink-0 h-12 w-12 rounded-tl-xl rounded-br-xl bg-primary-500 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-shopping-cart text-white text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Manajemen Pesanan
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Kelola dan pantau semua pesanan pelanggan
                        </p>
                    </div>
                </div>
            </div>

            <!-- Alert Success -->
            @if(session('success'))
                <div
                    class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <i class="fa-solid fa-circle-check text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-400">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                <!-- Header Card -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-list text-primary-500 mr-2"></i>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Semua Pesanan
                            </h4>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $orders->count() }} pesanan ditemukan
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    ID Order
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Penerima
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Alamat
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pesanan
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                                    <!-- ID Order -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            #NA-ORD-{{ $order->id }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </td>

                                    <!-- Penerima -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="shrink-0 h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                                <i class="fa-solid fa-user text-primary-600 dark:text-primary-400"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $order->nama_penerima }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $order->no_hp }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Alamat -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white max-w-xs">
                                            <div class="font-medium">{{ $order->provinsi }}, {{ $order->kota }}</div>
                                            <div class="text-gray-500 dark:text-gray-400 mt-1 text-xs">
                                                {{ Str::limit($order->alamat_detail, 60) }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Pesanan -->
                                    <td class="px-6 py-4">
                                        <div class="space-y-3">
                                            @foreach($order->items as $item)
                                                <div class="border-l-4 border-primary-200 dark:border-primary-800 pl-3 py-1">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $item->produk->nama_produk }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                Jumlah: {{ $item->jumlah }} ×
                                                                @if($item->produk->diskon && $item->produk->diskon > 0)
                                                                    <span class="line-through text-gray-400 mr-1">
                                                                        Rp{{ number_format($item->produk->harga, 0, ',', '.') }}
                                                                    </span>
                                                                    <span class="text-red-600 dark:text-red-400 font-semibold">
                                                                        Rp{{ number_format($item->produk->harga - ($item->produk->harga * $item->produk->diskon / 100), 0, ',', '.') }}
                                                                    </span>
                                                                @else
                                                                    <span class="text-gray-700 dark:text-gray-300 font-semibold">
                                                                        Rp{{ number_format($item->produk->harga, 0, ',', '.') }}
                                                                    </span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-1 text-xs font-semibold text-primary-600 dark:text-primary-400">
                                                        Subtotal: Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Total Order -->
                                            @php
                                                $totalOrder = $order->items->sum('subtotal');
                                            @endphp
                                            <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                                                <div
                                                    class="flex justify-between items-center text-sm font-bold text-gray-900 dark:text-white">
                                                    <span>Total:</span>
                                                    <span>Rp{{ number_format($totalOrder, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $config['color'] }}-100 dark:bg-{{ $config['color'] }}-900 text-{{ $config['color'] }}-800 dark:text-{{ $config['color'] }}-200 capitalize">
                                            <i class="fa-solid {{ $config['icon'] }} mr-1.5"></i>
                                            {{ $order->status }}
                                        </span>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Tombol Aksi Utama -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open"
                                                    class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                                    Aksi
                                                    <i class="fa-solid fa-chevron-down ml-1 text-xs"></i>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div x-show="open" @click.away="open = false"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-10">
                                                    <div class="py-1" role="menu">
                                                        <button onclick="openModal('modal-{{ $order->id }}')"
                                                            class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150"
                                                            role="menuitem">
                                                            <i class="fa-solid fa-pen-to-square mr-2 text-blue-500"></i>
                                                            Update Status
                                                        </button>
                                                        <a href="{{ route('admin.order.show', $order->id) }}"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150"
                                                            role="menuitem">
                                                            <i class="fa-solid fa-eye mr-2 text-green-500"></i>
                                                            Lihat Detail
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Update Status -->
                                <div id="modal-{{ $order->id }}"
                                    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 transition-opacity duration-300 p-4">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full p-6 transform transition-all duration-300 scale-95"
                                        @click.away="closeModal('modal-{{ $order->id }}')">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                                <i class="fa-solid fa-edit text-primary-500 mr-2"></i>
                                                Ubah Status Order
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
                                                        Order #{{ $order->id }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $order->nama_penerima }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST"
                                            class="space-y-4">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Tabel (Pagination) -->
                @if($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan
                            </div>
                            <div class="flex space-x-2">
                                @if($orders->onFirstPage())
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-white dark:bg-gray-700 cursor-not-allowed">
                                        Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $orders->previousPageUrl() }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                        Sebelumnya
                                    </a>
                                @endif

                                @if($orders->hasMorePages())
                                    <a href="{{ $orders->nextPageUrl() }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-500 hover:bg-primary-600 transition-colors duration-200">
                                        Selanjutnya
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-primary-300 dark:bg-primary-800 cursor-not-allowed">
                                        Selanjutnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Modal Functions
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

        // Auto-hide success message after 5 seconds
        @if(session('success'))
            setTimeout(() => {
                const successAlert = document.querySelector('.bg-green-50');
                if (successAlert) {
                    successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }
            }, 5000);
        @endif
    </script>

    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar untuk tabel */
        .table-scrollbar::-webkit-scrollbar {
            height: 8px;
        }

        .table-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark .table-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>

    <script>
        // Add fade-in animation to elements
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
            elements.forEach((el, index) => {
                el.classList.add('fade-in');
            });

            // Tambahkan class untuk custom scrollbar
            const tableContainer = document.querySelector('.overflow-x-auto');
            if (tableContainer) {
                tableContainer.classList.add('table-scrollbar');
            }
        });
    </script>
@endsection