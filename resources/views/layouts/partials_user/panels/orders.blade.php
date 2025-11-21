<div id="orders" class="tab-content block">
    @if ($orders->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 px-4">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-12 text-center max-w-md">
                <div class="w-20 h-20 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No orders"
                        class="w-10 h-10 opacity-40">
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-500 text-sm mb-6">Mulai berbelanja untuk melihat pesanan Anda di sini.</p>
                <a href="{{ route('customer.allProduk') }}"
                    class="inline-flex items-center gap-2 bg-red-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-800 transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Telusuri Produk
                </a>
            </div>
        </div>
    @else
        <div id="ordersGrid"
            class="max-h-[600px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                @foreach ($orders as $order)
                    @php
                        $firstItem = $order->items->first();
                        $foto = $firstItem->produk->fotos->first()->foto ?? null;
                    @endphp
                    <div class="order-card group bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer transform hover:-translate-y-1"
                        data-status="{{ strtolower($order->status) }}" onclick="openOrderModal({{ $order->id }})">

                        <div
                            class="relative w-full h-[150px] md:h-52 bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden">
                            @if ($foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="{{ $firstItem->nama_produk }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                        class="w-20 h-20 object-contain opacity-30">
                                </div>
                            @endif
                            <div class="absolute top-0 right-1 z-20 py-0 md:py-0">
                                <span
                                    class="px-2.5 sm:px-3 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold rounded-full
                                        {{ $order->status === 'selesai' ? 'bg-green-500/90 text-white' : '' }}
                                        {{ $order->status === 'menunggu' ? 'bg-yellow-500/90 text-white' : '' }}
                                        {{ $order->status === 'diproses' ? 'bg-blue-500/90 text-white' : '' }}
                                        {{ $order->status === 'dikirim' ? 'bg-purple-500/90 text-white' : '' }}
                                        {{ $order->status === 'batal' ? 'bg-red-500/90 text-white' : '' }}">
                                        {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <div class="absolute bottom-1 left-0">
                                <span
                                    class="px-3 py-1 bg-red-900/90 text-white text-xs font-medium rounded-full shadow-sm min-w-[60px] text-center">
                                    {{ $order->items->count() }}
                                    {{ $order->items->count() > 1 ? 'pcs' : 'item' }}
                                </span>
                            </div>
                        </div>

                        <div class="py-1 px-2 md:px-4 mb-2 md:p-5">
                            <div class="flex items-center justify-between mb-1 md:mb-3">
                                <h3 class="font-bold text-gray-800 text-xs md:text-base truncate">
                                    {{ $firstItem->nama_produk }}
                                    @if ($order->items->count() > 1)
                                        <span class="font-medium">+{{ $order->items->count() - 1 }}
                                            more</span>
                                    @endif
                                </h3>
                                <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-red-900"></i>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-xs md:text-sm font-medium text-gray-500">
                                        Rp
                                    </span>
                                    <span class="text-[16px] md:text-2xl font-bold text-red-900">
                                        {{ number_format($order->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                                <p class="text-[10px] md:text-xs text-gray-500 line-clamp-1">
                                    ID: #ORD-NA-{{ $order->id }}
                                </p>
                            </div>
                        </div>

                        @php
                            $itemsData = $order->items->map(function ($item) {
                                return [
                                    'id' => $item->id,
                                    'order_id' => $item->order_id,
                                    'produk_id' => $item->produk_id,
                                    'nama_produk' => $item->nama_produk,
                                    'warna' => $item->warna,
                                    'ukuran' => $item->ukuran,
                                    'jumlah' => $item->jumlah,
                                    'subtotal' => $item->subtotal,
                                    'produk' => [
                                        'id' => $item->produk->id,
                                        'nama_produk' => $item->produk->nama_produk,
                                        'foto' => $item->produk->fotos->first()->foto ?? null
                                    ],
                                    'ulasan_id' => $item->ulasan->id ?? null,
                                    'ulasan_data' => $item->ulasan ? [
                                        'id' => $item->ulasan->id,
                                        'rating' => $item->ulasan->rating,
                                        'komentar' => $item->ulasan->komentar,
                                        'fotos' => $item->ulasan->fotos->map(function ($foto) {
                                            return ['id' => $foto->id, 'foto' => $foto->foto];
                                        })
                                    ] : null
                                ];
                            });
                        @endphp

                        <div class="order-data hidden" data-id="{{ $order->id }}" data-status="{{ $order->status }}"
                            data-subtotal="{{ $order->subtotal }}" data-items='@json($itemsData)'>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ORDER MODAL --}}
    <div id="orderModal"
        class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 md:p-6">
        <div
            class="bg-white w-full max-w-3xl max-h-[90vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col border border-gray-200 animate-fadeIn">

            {{-- HEADER --}}
            <div
                class="bg-gradient-to-r from-red-900 via-red-800 to-red-700 text-white px-6 py-5 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">Order #<span id="modalOrderId"></span></h2>
                    <p class="text-sm text-red-100">Status:
                        <span id="modalOrderStatus" class="font-semibold"></span>
                    </p>
                </div>
                <button onclick="closeOrderModal()"
                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/20 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- BODY --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-6">

                {{-- ORDER ITEMS --}}
                <div id="modalOrderItems" class="space-y-4"></div>

                {{-- === FORM ULASAN MODERN === --}}
                <div id="ulasanContainer" class="border-t border-gray-200 pt-6 mt-6 hidden">
                    <form id="ulasanForm" action="{{ route('customer.ulasan.store') }}" method="POST"
                        enctype="multipart/form-data" class="hidden">
                        @csrf

                        {{-- akan diisi oleh JS --}}
                        <input type="hidden" name="order_id" id="ulasanOrderId">
                        <input type="hidden" name="produk_id" id="ulasanProdukId">
                        <input type="hidden" name="order_item_id" id="ulasanOrderItemId">

                        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                            {{-- HEADER --}}
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                                    <i class="fa-solid fa-star text-white text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">Beri Ulasan</h3>
                                    <p class="text-sm text-gray-600 mt-1">Bagikan pengalaman Anda dengan produk ini</p>
                                </div>
                            </div>

                            {{-- RATING STARS --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">Rating Produk</label>
                                <div class="flex items-center gap-1" id="starRating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            class="star-btn w-10 h-10 text-2xl transition-all duration-200 hover:scale-110"
                                            data-rating="{{ $i }}">
                                            <span class="text-gray-300 hover:text-yellow-400">★</span>
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="selectedRating" required>
                                <p id="ratingText" class="text-sm text-gray-500 mt-2">Pilih rating dengan mengklik
                                    bintang</p>
                            </div>

                            {{-- COMMENT TEXTAREA --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">Komentar</label>
                                <div class="relative">
                                    <textarea name="komentar" rows="4"
                                        class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 resize-none"
                                        placeholder="Ceritakan pengalaman Anda menggunakan produk ini... Apa yang Anda sukai? Apakah sesuai dengan ekspektasi?"
                                        required></textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                        <span id="charCount">0</span>/500
                                    </div>
                                </div>
                            </div>

                            {{-- FILE UPLOAD --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">Foto Ulasan</label>

                                {{-- Upload Area --}}
                                <div id="uploadArea"
                                    class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center transition-all duration-300 hover:border-red-400 hover:bg-red-50 cursor-pointer">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Klik atau drag & drop foto di sini
                                    </p>
                                    <p class="text-xs text-gray-500">Format: JPG, PNG, JPEG (Maks. 5MB per gambar)</p>
                                    <input type="file" name="fotos[]" multiple accept="image/*" class="hidden"
                                        id="fileInput" onchange="previewImages(this)">
                                </div>

                                {{-- Image Previews --}}
                                <div id="imagePreviews" class="grid grid-cols-3 gap-3 mt-4 hidden"></div>

                                {{-- Upload Info --}}
                                <div id="uploadInfo" class="flex items-center gap-2 mt-3 text-xs text-gray-500 hidden">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span>Anda dapat mengupload maksimal 5 foto</span>
                                </div>
                            </div>

                            {{-- SUBMIT BUTTON --}}
                            <div class="flex gap-3">
                                <button type="button" id="cancelBtn"
                                    class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-all duration-200">
                                    Batal
                                </button>
                                <button type="submit" id="submitBtn"
                                    class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-medium hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                    <span class="flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        Kirim Ulasan
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- FOOTER --}}
            <div
                class="border-t border-gray-100 bg-gray-50 px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-4">
                <a id="detailOrderLink" href="#"
                    class="text-red-900 font-semibold hover:text-red-700 hover:underline transition">
                    <i class="fa-solid fa-arrow-right mr-2"></i> Lihat Detail Pesanan
                </a>
                <div>
                    <p class="text-gray-500 text-sm">Total Amount</p>
                    <p class="text-3xl font-bold text-red-900" id="modalOrderSubtotal">Rp 0</p>
                </div>
            </div>
        </div>
    </div>
</div>