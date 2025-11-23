<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pesanan Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border-b-2 border-gray-700 dark:border-gray-100">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        ID Pesanan</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Pelanggan</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Tanggal</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Jumlah</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status</th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($pesananTerbaru as $order)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer"
                        data-id="{{ $order->id }}" data-user="{{ $order->user->name ?? 'Guest' }}"
                        data-tanggal="{{ $order->created_at->translatedFormat('d M Y') }}"
                        data-subtotal="{{ $order->subtotal }}"
                        data-status="{{ ucfirst($order->status) }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            #NA-ORD-{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $order->user->name ?? 'Guest' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $order->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'selesai' => 'green',
                                    'menunggu' => 'yellow',
                                    'diproses' => 'blue',
                                    'dikirim' => 'purple',
                                    'dibatalkan' => 'red',
                                ];
                                $color = $statusColors[$order->status] ?? 'gray';
                            @endphp
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-200">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.order.show', $order->id) }}"
                                class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Menampilkan 1 hingga {{ $pesananTerbaru->count() }} dari {{ \App\Models\Order::count() }} hasil
        </div>
        <div class="flex space-x-2">
            <button
                class="px-3 py-1 text-sm bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-lg">Sebelumnya</button>
            <button
                class="px-3 py-1 text-sm text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">Selanjutnya</button>
        </div>
    </div>
</div>

{{-- MODAL INFORMASI PESANAN --}}
<div id="pesananModal"
    class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <i class="fa-solid fa-receipt text-blue-600 dark:text-blue-400 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Detail Pesanan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Informasi lengkap pesanan</p>
                </div>
            </div>
            <button id="closeModal" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                <i class="fa-solid fa-xmark text-gray-500 hover:text-gray-700 dark:hover:text-white text-lg"></i>
            </button>
        </div>

        <!-- Content -->
        <div id="modalContent" class="p-6 space-y-4">
            <!-- Konten pesanan akan diisi melalui JS -->
        </div>

        <!-- Footer -->
        <div
            class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-b-2xl">
            <div class="flex justify-end">
                <button id="closeModalBtn"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg font-medium transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>