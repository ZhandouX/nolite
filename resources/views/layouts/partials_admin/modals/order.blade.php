<div id="pesananModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9998]">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 relative">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <h2 class="text-lg font-semibold mb-4 text-gray-800">
            Pesanan Menunggu ({{ $jumlahMenunggu ?? 0 }})
        </h2>

        @if (empty($pesananMenunggu) || $pesananMenunggu->isEmpty())
            <p class="text-gray-500 italic">Tidak ada pesanan menunggu.</p>
        @else
            <div class="max-h-80 overflow-y-auto">
                @foreach ($pesananMenunggu as $order)
                    <div class="border rounded-lg p-3 mb-3 hover:bg-gray-50 relative">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">
                                    #{{ $order->id }} - {{ $order->nama_penerima ?? 'Tanpa Nama' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            {{-- Dropdown aksi --}}
                            <div class="relative">
                                <button onclick="toggleDropdown('dropdown-{{ $order->id }}')"
                                    class="p-2 text-gray-500 hover:text-gray-700">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                                <div id="dropdown-{{ $order->id }}"
                                    class="hidden absolute right-0 mt-2 w-60 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fa-solid fa-eye mr-2 text-gray-500"></i> Lihat Pesanan</a>
                                    <a href="{{ route('admin.order.index') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fa-solid fa-list mr-2 text-gray-500"></i> Lihat Semua
                                    </a>
                                </div>
                            </div>
                        </div>

                        <span class="inline-block mt-1 text-sm font-semibold text-yellow-600 bg-yellow-100 px-2 py-1 rounded">
                            Menunggu
                        </span>

                        {{-- Daftar Produk --}}
                        @if ($order->items->isNotEmpty())
                            <ul class="mt-2 text-sm text-gray-700 list-disc list-inside">
                                @foreach ($order->items as $item)
                                    <li>{{ $item->produk->nama_produk ?? '-' }} ({{ $item->jumlah }} pcs)</li>
                                @endforeach
                            </ul>
                        @endif

                        <p class="text-gray-800 font-semibold mt-2">
                            Total: IDR {{ number_format($order->subtotal, 0, ',', '.') }}
                        </p>
                        <p class="text-gray-800 font-semibold mt-2">
                            Metode Pembayaran: {{ $order->metode_pembayaran }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    function toggleDropdown(id) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            if (el.id !== id) el.classList.add('hidden');
        });
        document.getElementById(id).classList.toggle('hidden');
    }

    // Tutup dropdown jika klik di luar
    window.addEventListener('click', function (e) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(drop => {
            if (!drop.contains(e.target) && !drop.previousElementSibling.contains(e.target)) {
                drop.classList.add('hidden');
            }
        });
    });
</script>