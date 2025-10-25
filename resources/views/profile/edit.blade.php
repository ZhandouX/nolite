@extends('layouts.user_app')

@section('title', 'My Account')

@section('content')
    <div class="bg-gray-100 text-gray-800 min-h-screen py-10 px-4 flex justify-center items-start pt-24">
        <div class="w-full max-w-3xl">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold">
                    Hi {{ Auth::user()->name ?? 'User' }}
                </h1>
                <a href="{{ route('profile.settings') }}"
                    class="border border-red-900 text-red-900 px-4 py-2 rounded hover:bg-red-900 hover:text-white transition">
                    Settings
                </a>
            </div>

            <!-- Vouchers Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6 hover:shadow-md transition">
                <h3 class="text-xl font-semibold text-center mb-4">My Vouchers</h3>
                <div class="text-center text-gray-500">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No vouchers"
                        class="mx-auto w-14 mb-3 opacity-60">
                    <p>No vouchers available</p>
                    <small>You don't have any vouchers at the moment</small>
                </div>
            </div>

            <!-- Orders/Wishlist Card -->
            <div class="bg-white rounded-lg shadow-sm p-6 relative hover:shadow-md transition">

                <!-- Dropdown top right -->
                <div class="absolute top-6 right-6">
                    <select id="statusFilter" class="border border-gray-300 rounded px-3 py-1 text-sm">
                        <option value="all">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Tabs -->
                <div class="flex justify-center border-b border-gray-200 mb-5">
                    <div class="tab cursor-pointer px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-black hover:border-gray-400 active-tab"
                        data-tab="orders">
                        Orders
                    </div>
                    <div class="tab cursor-pointer px-4 py-2 text-sm font-medium text-gray-600 border-b-2 border-transparent hover:text-black hover:border-gray-400"
                        data-tab="wishlist">
                        Wishlist
                    </div>
                </div>

                <!-- Orders Content -->
                <div id="orders" class="tab-content block text-gray-700">

                    @if($orders->isEmpty())
                        <div class="text-center text-gray-500">
                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No orders"
                                class="mx-auto w-14 mb-3 opacity-60">
                            <p>No Orders Found</p>
                            <small>Place an order to see it listed here.</small>
                            <br><br>
                            <a href="{{ route('customer.allProduk') }}" class="text-red-900 font-medium hover:underline">
                                Find your Orders
                            </a>
                        </div>
                    @else
                        <!-- Scrollable Orders Grid -->
                        <div id="ordersGrid" class="max-h-96 overflow-y-auto pr-2">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                @foreach($orders as $order)
                                    <div class="order-card border rounded-xl bg-white shadow-sm hover:shadow-md transition overflow-hidden p-4 cursor-pointer"
                                        data-status="{{ strtolower($order->status) }}" onclick="openOrderModal({{ $order->id }})">

                                        {{-- Info produk pertama --}}
                                        @php
                                            $firstItem = $order->items->first();
                                            $foto = $firstItem->produk->fotos->first()->foto ?? null;
                                        @endphp

                                        <div
                                            class="w-full h-48 rounded-md overflow-hidden bg-gray-100 mb-3 flex items-center justify-center">
                                            @if($foto)
                                                <img src="{{ asset('storage/' . $foto) }}" alt="{{ $firstItem->nama_produk }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                                    class="w-full h-full object-contain p-4">
                                            @endif
                                        </div>

                                        <div class="text-center">
                                            <h3 class="font-semibold text-gray-800 text-sm truncate">Order #{{ $order->id }}</h3>
                                            <p class="text-gray-500 text-xs mt-1">{{ $order->items->count() }} item(s)</p>
                                            <p class="text-red-600 font-bold mt-1">
                                                IDR {{ number_format($order->subtotal, 0, ',', '.') }}
                                            </p>
                                            <p class="text-sm mt-1">Status:
                                                <span class="capitalize">{{ $order->status }}</span>
                                            </p>
                                        </div>

                                        {{-- Simpan data order di HTML sebagai data attributes --}}
                                        <div class="order-data hidden" data-id="{{ $order->id }}" data-status="{{ $order->status }}"
                                            data-subtotal="{{ $order->subtotal }}" data-items='@json($order->items)'>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Modal -->
                    <div id="orderModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
                        <div class="bg-white w-11/12 md:w-2/3 max-h-[80vh] overflow-y-auto rounded-xl p-6 relative">
                            <button onclick="closeOrderModal()"
                                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">✕</button>

                            <h2 class="text-xl font-semibold mb-4">Order #<span id="modalOrderId"></span></h2>
                            <p class="text-sm text-gray-500 mb-4">Status: <span id="modalOrderStatus"></span></p>

                            <h3 class="font-semibold mb-2 text-gray-800">Produk dalam Order</h3>
                            <div id="modalOrderItems" class="space-y-4"></div>

                            <div class="flex justify-between font-semibold text-gray-800 mt-4 pt-2 border-t">
                                <span>Total Bayar</span>
                                <span>IDR<span id="modalOrderSubtotal"></span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Content -->
                <div id="wishlist" class="tab-content hidden text-gray-700">
                    @if($wishlists->isEmpty())
                        <div class="text-center text-gray-500">
                            <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" alt="No wishlist"
                                class="mx-auto w-14 mb-3 opacity-60">
                            <p>No items in Wishlist</p>
                            <small>Add products to your wishlist to view them here.</small>
                            <br><br>
                            <a href="{{ route('customer.allProduk') }}" class="text-red-900 font-medium hover:underline">
                                Browse Products
                            </a>
                        </div>
                    @else
                        <!-- Scrollable Wishlist Grid -->
                        <div class="max-h-96 overflow-y-auto pr-2">
                            <div id="wishlist-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                @foreach($wishlists as $item)
                                    <div id="wishlist-item-{{ $item->id }}"
                                        class="border rounded-xl bg-white shadow-sm hover:shadow-md transition overflow-hidden group relative">
                                        {{-- Gambar produk --}}
                                        <a href="{{ route('produk.detail', $item->produk->id) }}" class="block relative">
                                            @if($item->produk->fotos->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->produk->fotos->first()->foto) }}"
                                                    alt="{{ $item->produk->nama_produk }}"
                                                    class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                            @else
                                                <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                                    class="w-full h-48 object-contain p-4">
                                            @endif
                                        </a>

                                        {{-- Info produk --}}
                                        <div class="p-4 text-center">
                                            <h3 class="font-semibold text-gray-800 text-sm truncate">
                                                {{ $item->produk->nama_produk }}
                                            </h3>
                                            <p class="text-red-600 font-bold mt-1">
                                                IDR {{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        {{-- Tombol hapus wishlist (AJAX) --}}
                                        <button type="button" data-id="{{ $item->id }}"
                                            class="remove-wishlist bg-transparent p-2 rounded-full shadow hover:scale-110 transition absolute top-3 right-3">
                                            <i class="fa-solid fa-heart text-red-500"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Filter status pesanan -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const statusFilter = document.getElementById('statusFilter');
            const orderCards = document.querySelectorAll('.order-card');

            statusFilter.addEventListener('change', () => {
                const selected = statusFilter.value;

                orderCards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    card.style.display = (selected === 'all' || status === selected) ? 'block' : 'none';
                });
            });
        });
    </script>

    <!-- Hapus wishlist tanpa reload -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = '{{ csrf_token() }}';

            document.querySelectorAll('.remove-wishlist').forEach(button => {
                button.addEventListener('click', async function () {
                    const id = this.dataset.id;
                    const itemElement = document.getElementById(`wishlist-item-${id}`);

                    // Konfirmasi sebelum hapus
                    const confirmation = await Swal.fire({
                        title: 'Hapus dari Wishlist?',
                        text: 'Produk ini akan dihapus dari daftar wishlist kamu.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    });

                    if (confirmation.isConfirmed) {
                        const response = await fetch(`/wishlist/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                        });

                        if (response.ok) {
                            // Efek animasi hapus
                            if (itemElement) {
                                itemElement.classList.add('opacity-0', 'scale-90', 'transition', 'duration-300');
                                setTimeout(() => itemElement.remove(), 300);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Produk berhasil dihapus dari wishlist.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus wishlist.',
                            });
                        }
                    }
                });
            });
        });
    </script>

    <!-- Tabs navigasi -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const tabs = document.querySelectorAll('.tab');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = tab.getAttribute('data-tab');

                    tabs.forEach(t => t.classList.remove('border-black', 'text-black', 'active-tab'));
                    tab.classList.add('border-black', 'text-black', 'active-tab');

                    contents.forEach(c => c.classList.add('hidden'));
                    document.getElementById(target).classList.remove('hidden');
                });
            });
        });
    </script>

    <!-- Modal order -->
    <script>
        function openOrderModal(orderId) {
            const orderDiv = document.querySelector(`.order - data[data - id='${orderId}']`);
            const items = JSON.parse(orderDiv.getAttribute('data-items'));
            const status = orderDiv.getAttribute('data-status');
            const subtotal = orderDiv.getAttribute('data-subtotal');

            document.getElementById('modalOrderId').textContent = orderId;
            document.getElementById('modalOrderStatus').textContent = status;
            document.getElementById('modalOrderSubtotal').textContent = Number(subtotal).toLocaleString('id-ID');

            const itemsContainer = document.getElementById('modalOrderItems');
            itemsContainer.innerHTML = '';

            items.forEach(item => {
                const foto = item.produk.fotos.length
                    ? '{{ asset('storage') }}/' + item.produk.fotos[0].foto
                    : '{{ asset('assets/images/no-image.png') }}';

                itemsContainer.innerHTML += `
                    <div class="flex items-center border rounded-md p-3" >
                                <div class="w-20 h-20 rounded-md overflow-hidden bg-gray-100 flex items-center justify-center mr-4">
                                    <img src="${foto}" class="w-full h-full object-cover" alt="">
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">${item.nama_produk}</p>
                                    <p class="text-sm text-gray-500">Warna: ${item.warna} • Ukuran: ${item.ukuran}</p>
                                    <p class="text-sm text-gray-500">Jumlah: ${item.jumlah}</p>
                                </div>
                                <div class="font-semibold text-gray-800">
                                    Rp${Number(item.subtotal).toLocaleString('id-ID')}
                                </div>
                            </div >
                        `;
            });

            document.getElementById('orderModal').classList.remove('hidden');
            document.getElementById('orderModal').classList.add('flex');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
            document.getElementById('orderModal').classList.remove('flex');
        }

        document.getElementById('orderModal').addEventListener('click', function (e) {
            if (e.target === this) closeOrderModal();
        });
    </script>
@endpush