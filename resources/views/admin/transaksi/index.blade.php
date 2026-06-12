@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-6">
        <div class="max-w-screen mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div
                        class="shrink-0 h-12 w-12 rounded-tl-xl rounded-br-xl bg-primary-500 flex items-center justify-center shadow-sm">
                        <i data-lucide="wallet" class="text-white text-lg"></i>
                    </div>

                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Riwayat Transaksi
                        </h1>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Monitor seluruh transaksi pembayaran pengguna
                        </p>
                    </div>
                </div>
            </div>

            <!-- FILTER -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-8 transition-all duration-300">

                <form method="GET" action="{{ route('admin.transaksi.index') }}"
                    class="grid grid-cols-1 md:grid-cols-12 gap-4">

                    <!-- SEARCH -->
                    <div class="md:col-span-5">

                        <div class="relative">

                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                            </div>

                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari invoice / nama / email..."
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">

                        </div>

                    </div>

                    <!-- FILTER STATUS -->
                    <div class="md:col-span-5">

                        <select name="status" onchange="this.form.submit()"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>
                                Paid
                            </option>

                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>
                                Failed
                            </option>

                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>
                                Expired
                            </option>

                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>
                                Cancel
                            </option>

                        </select>

                    </div>

                    <!-- BUTTON -->
                    <div class="md:col-span-2">

                        <button type="submit"
                            class="w-full h-full bg-black dark:bg-primary-500 hover:bg-primary-600 text-white font-medium py-3 px-4 rounded-2xl transition-colors duration-200 flex items-center justify-center shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">

                            <i data-lucide="search" class="w-5 h-5 mr-2"></i>

                            <span class="text-sm font-semibold">
                                Cari
                            </span>

                        </button>

                    </div>

                </form>

            </div>

            <!-- CONTENT -->
            @if($orders->isEmpty())

                <!-- EMPTY STATE -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center transition-all duration-300">

                    <div class="max-w-md mx-auto">

                        <div
                            class="w-16 h-16 mx-auto mb-4 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center">

                            <i class="fa-solid fa-file-invoice-dollar text-yellow-500 dark:text-yellow-400 text-xl"></i>

                        </div>

                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">

                            Tidak ada transaksi

                        </h3>

                        <p class="text-gray-500 dark:text-gray-400 mb-6">

                            Belum ada data transaksi yang tersedia.

                        </p>

                    </div>

                </div>

            @else

                <!-- TABLE -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-all duration-300">

                    <!-- TABLE HEADER -->
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-blue-100 dark:bg-gray-700/50">

                        <div class="flex items-center justify-between">

                            <div class="flex items-center">

                                <i class="fa-solid fa-wallet text-primary-500 mr-2"></i>

                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">

                                    Daftar Transaksi

                                </h4>

                            </div>

                            <span class="text-sm text-gray-500 dark:text-gray-400">

                                {{ $orders->count() }} hasil ditemukan

                            </span>

                        </div>

                    </div>

                    <!-- TABLE -->
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                            <thead class="bg-gray-800 dark:bg-gray-700">

                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Invoice
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Customer
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Total
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Pembayaran
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        Tanggal
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                                @foreach($orders as $order)

                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">

                                        <!-- INVOICE -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">

                                                {{ $order->midtrans_order_id }}

                                            </div>

                                        </td>

                                        <!-- CUSTOMER -->
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

                                                        {{ $order->email }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>

                                        <!-- TOTAL -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <div class="text-sm font-semibold text-red-700 dark:text-red-400">

                                                Rp {{ number_format($order->subtotal, 0, ',', '.') }}

                                            </div>

                                        </td>

                                        <!-- PAYMENT -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">

                                                {{ $order->metode_pembayaran ?? '-' }}

                                            </span>

                                        </td>

                                        <!-- STATUS -->
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <span class="
                                                        inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold

                                                        @if($order->payment_status === 'paid')
                                                            bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300

                                                        @elseif($order->payment_status === 'pending')
                                                            bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300

                                                        @elseif($order->payment_status === 'failed')
                                                            bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300

                                                        @elseif($order->payment_status === 'expired')
                                                            bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300

                                                        @else
                                                            bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                                        @endif
                                                    ">

                                                {{ ucfirst($order->payment_status) }}

                                            </span>

                                        </td>

                                        <!-- DATE -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">

                                            <div class="flex items-center">

                                                <i class="fa-solid fa-clock mr-1.5 text-gray-400"></i>

                                                {{ $order->created_at->format('d M Y H:i') }}

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <!-- PAGINATION -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">

                        <div class="flex items-center justify-between">

                            <div class="text-sm text-gray-500 dark:text-gray-400">

                                Menampilkan {{ $orders->count() }}
                                dari {{ $orders->total() }} hasil

                            </div>

                            @if($orders->hasPages())

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

                            @endif

                        </div>

                    </div>

                </div>

            @endif

        </div>
    </div>

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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const elements = document.querySelectorAll(
                '.bg-white, .bg-gray-50'
            );

            elements.forEach((el) => {
                el.classList.add('fade-in');
            });

        });
    </script>
@endsection
