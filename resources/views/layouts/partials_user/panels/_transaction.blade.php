<!-- Riwayat Transaksi Content -->
<div id="riwayat-transaksi" class="tab-content hidden text-gray-700">

    @if($orders->isEmpty())
        <div class="text-center text-gray-500 py-10">
            <i class="fa-solid fa-receipt mb-3 opacity-70 text-red-500 text-5xl"></i>

            <p class="text-base font-medium">
                Belum ada transaksi
            </p>

            <small class="block text-sm mb-4">
                Semua riwayat transaksi Anda akan muncul di sini.
            </small>

            <a href="{{ route('customer.allProduk') }}"
                class="inline-block px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-700 transition font-medium">
                Belanja Sekarang
            </a>
        </div>
    @else

        <!-- Scroll Area -->
        <div class="max-h-[550px] overflow-y-auto pr-2 space-y-4">

            @foreach($orders as $order)

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition duration-300 p-4">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                        <!-- KIRI -->
                        <div class="flex items-start gap-4">

                            <!-- Thumbnail -->
                            <div class="w-20 h-20 rounded-xl overflow-hidden border border-gray-200 flex-shrink-0 bg-gray-100">

                                @php
                                    $firstItem = $order->items->first();
                                @endphp

                                @if($firstItem && $firstItem->produk && $firstItem->produk->fotos->isNotEmpty())
                                    <img src="{{ asset('storage/' . $firstItem->produk->fotos->first()->foto) }}" alt="Produk"
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                        class="w-full h-full object-contain p-2">
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-1">

                                <!-- Invoice -->
                                <h3 class="font-bold text-gray-800 text-sm sm:text-base">
                                    #{{ $order->midtrans_order_id ?? 'ORDER-' . $order->id }}
                                </h3>

                                <!-- Tanggal -->
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $order->created_at->translatedFormat('d F Y, H:i') }}
                                </p>

                                <!-- Produk -->
                                <div class="mt-2">

                                    <p class="text-sm font-medium text-gray-700">
                                        {{ $firstItem->nama_produk ?? 'Produk tidak ditemukan' }}
                                    </p>

                                    @if($order->items->count() > 1)
                                        <p class="text-xs text-gray-500">
                                            + {{ $order->items->count() - 1 }} produk lainnya
                                        </p>
                                    @endif

                                </div>

                                <!-- Total -->
                                <div class="mt-2">
                                    <span class="text-xs text-gray-500">
                                        Total Belanja
                                    </span>

                                    <p class="font-bold text-red-900 text-sm sm:text-base">
                                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <!-- KANAN -->
                        <div class="flex flex-col items-start lg:items-end gap-3">

                            <!-- Status -->
                            <div class="flex flex-wrap gap-2">

                                <!-- Payment Status -->
                                <span class="
                                            px-3 py-1 rounded-full text-xs font-semibold

                                            @if($order->payment_status === 'paid')
                                                bg-green-100 text-green-700
                                            @elseif($order->payment_status === 'pending')
                                                bg-yellow-100 text-yellow-700
                                            @elseif($order->payment_status === 'failed')
                                                bg-red-100 text-red-700
                                            @else
                                                bg-gray-100 text-gray-700
                                            @endif
                                        ">
                                    {{ ucfirst($order->payment_status) }}
                                </span>

                                <!-- Order Status -->
                                <span class="
                                            px-3 py-1 rounded-full text-xs font-semibold

                                            @if($order->status === 'diproses')
                                                bg-blue-100 text-blue-700
                                            @elseif($order->status === 'dikirim')
                                                bg-purple-100 text-purple-700
                                            @elseif($order->status === 'selesai')
                                                bg-green-100 text-green-700
                                            @elseif($order->status === 'dibatalkan')
                                                bg-red-100 text-red-700
                                            @else
                                                bg-gray-100 text-gray-700
                                            @endif
                                        ">
                                    {{ ucfirst($order->status) }}
                                </span>

                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="text-sm text-gray-600">
                                {{ $order->metode_pembayaran ?? 'Belum dipilih' }}
                            </div>

                            <!-- Button -->
                            <div class="flex gap-2">

                                <a href="#"
                                    class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-100 transition">
                                    Detail
                                </a>

                                @if($order->payment_status === 'pending')
                                    <a href="{{ $order->payment_url }}"
                                        class="px-4 py-2 text-sm font-medium rounded-lg bg-red-900 text-white hover:bg-red-800 transition">
                                        Bayar
                                    </a>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>