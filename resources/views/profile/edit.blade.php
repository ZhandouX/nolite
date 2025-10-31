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
                    class="border border-red-900 text-red-900 px-4 py-2 rounded-lg hover:bg-gray-600 hover:text-white transition">
                    <i class="fa-solid fa-gear mr-2"></i>
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
                <div id="orders" class="tab-content block">

                    @if($orders->isEmpty())
                        <div class="flex flex-col items-center justify-center py-16 px-4">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-12 text-center max-w-md">
                                <div
                                    class="w-20 h-20 mx-auto mb-6 bg-white rounded-full flex items-center justify-center shadow-sm">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No orders"
                                        class="w-10 h-10 opacity-40">
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Orders Yet</h3>
                                <p class="text-gray-500 text-sm mb-6">Start shopping to see your orders here</p>
                                <a href="{{ route('customer.allProduk') }}"
                                    class="inline-flex items-center gap-2 bg-red-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-800 transition-all duration-200 shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Browse Products
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Header Section -->
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">My Orders</h2>
                            <p class="text-gray-500 text-sm">Track and manage your purchases</p>
                        </div>

                        <!-- Scrollable Orders Grid -->
                        <div id="ordersGrid"
                            class="max-h-[600px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                                @foreach($orders as $order)
                                    <div class="order-card group bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer transform hover:-translate-y-1"
                                        data-status="{{ strtolower($order->status) }}" onclick="openOrderModal({{ $order->id }})">

                                        {{-- Info produk pertama --}}
                                        @php
                                            $firstItem = $order->items->first();
                                            $foto = $firstItem->produk->fotos->first()->foto ?? null;
                                        @endphp

                                        {{-- Image Section --}}
                                        <div
                                            class="relative w-full h-52 bg-gradient-to-br from-gray-100 to-gray-50 overflow-hidden">
                                            @if($foto)
                                                <img src="{{ asset('storage/' . $foto) }}" alt="{{ $firstItem->nama_produk }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                                        class="w-20 h-20 object-contain opacity-30">
                                                </div>
                                            @endif

                                            {{-- Status Badge --}}
                                            <div class="absolute top-3 right-3">
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full backdrop-blur-sm
                                                {{ $order->status === 'completed' ? 'bg-green-500/90 text-white' : '' }}
                                                {{ $order->status === 'pending' ? 'bg-yellow-500/90 text-white' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-500/90 text-white' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-500/90 text-white' : '' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>

                                            {{-- Item Count Badge --}}
                                            <div class="absolute bottom-3 left-3">
                                                <span
                                                    class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-medium rounded-full shadow-sm">
                                                    {{ $order->items->count() }} {{ $order->items->count() > 1 ? 'items' : 'item' }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Content Section --}}
                                        <div class="p-5">
                                            <div class="flex items-center justify-between mb-3">
                                                <h3 class="font-bold text-gray-800 text-base">Order #{{ $order->id }}</h3>
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-900 transition-colors"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>

                                            <div class="space-y-2">
                                                <div class="flex items-baseline gap-1">
                                                    <span class="text-2xl font-bold text-red-900">
                                                        {{ number_format($order->subtotal, 0, ',', '.') }}
                                                    </span>
                                                    <span class="text-sm font-medium text-gray-500">IDR</span>
                                                </div>

                                                <p class="text-xs text-gray-500">
                                                    {{ $firstItem->nama_produk }}
                                                    @if($order->items->count() > 1)
                                                        <span class="font-medium">+{{ $order->items->count() - 1 }} more</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Hidden Data --}}
                                        <div class="order-data hidden" data-id="{{ $order->id }}" data-status="{{ $order->status }}"
                                            data-subtotal="{{ $order->subtotal }}" data-items='@json($order->items)'>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Modal -->
                    <div id="orderModal"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                        <div
                            class="bg-white w-full max-w-3xl max-h-[85vh] rounded-2xl shadow-2xl overflow-hidden flex flex-col animate-fadeIn">

                            {{-- Modal Header --}}
                            <div
                                class="bg-gradient-to-r from-red-900 to-red-800 text-white px-6 py-5 flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold">Order #<span id="modalOrderId"></span></h2>
                                    <p class="text-red-100 text-sm mt-1">Status: <span id="modalOrderStatus"
                                            class="font-semibold"></span></p>
                                </div>
                                <button onclick="closeOrderModal()"
                                    class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/20 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Modal Body --}}
                            <div class="flex-1 overflow-y-auto p-6">
                                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Order Items
                                </h3>
                                <div id="modalOrderItems" class="space-y-3"></div>
                            </div>

                            {{-- Modal Footer --}}
                            <div class="border-t border-gray-200 bg-gray-50 px-6 py-5">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 font-medium">Total Amount</span>
                                    <div class="text-right">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl font-bold text-red-900" id="modalOrderSubtotal"></span>
                                            <span class="text-sm font-medium text-gray-500">IDR</span>
                                        </div>
                                    </div>
                                </div>
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
                                        <div class="relative">
                                            <a href="{{ route('produk.detail', $item->produk->id) }}" class="block">
                                                @if($item->produk->fotos->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $item->produk->fotos->first()->foto) }}"
                                                        alt="{{ $item->produk->nama_produk }}"
                                                        class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                                @else
                                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                                        class="w-full h-48 object-contain p-4">
                                                @endif
                                            </a>

                                            {{-- Tombol hapus wishlist (pojok kanan atas gambar) --}}
                                            <button type="button" data-id="{{ $item->id }}"
                                                class="remove-wishlist w-10 h-10 absolute bottom-2 right-2 bg-white/80 backdrop-blur-sm rounded-full shadow hover:scale-110 transition">
                                                <i class="fa-solid fa-heart text-red-500 mt-1 text-2xl"></i>
                                            </button>
                                        </div>

                                        {{-- Info produk --}}
                                        <div class="p-4 text-center">
                                            <h3 class="font-semibold text-gray-800 text-sm truncate">
                                                {{ $item->produk->nama_produk }}
                                            </h3>
                                            <p class="text-red-600 font-bold mt-1">
                                                IDR {{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </p>
                                        </div>
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

@push('style')
    <style>
        /* Custom scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
@endpush

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
            const orderDiv = document.querySelector(`.order-data[data-id='${orderId}']`);
            if (!orderDiv) return console.error('Order data not found');

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
                            <div class="flex items-center border rounded-md p-3">
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
                            </div>
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