@extends('layouts.user_app')

@section('title', 'Keranjang')

@section('content')
    <div class="container mx-auto px-4 py-8 lg:py-10 lg:px-10 mb-4 pt-[70px] lg:pt-6">

        {{-- BACK BUTTON --}}
        <!-- <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Keranjang Belanja</h1>
            <a href="{{ route('customer.dashboard') }}"
                class="inline-flex items-center gap-2 bg-gray-800 text-white px-4 py-2.5 rounded-lg hover:bg-gray-700 transition-all duration-300 shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i>
                <span class="font-medium">Kembali</span>
            </a>
        </div> -->

        <div class="cart-container grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT: PRODUCT LIST --}}
            <div class="cart-items lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">

                {{-- HEADER --}}
                <div class="cart-header flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Item di Keranjang</h2>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <label for="select-all" class="text-gray-700 text-sm font-medium cursor-pointer">Pilih Semua</label>
                    </div>
                </div>

                {{-- DAFTAR PRODUK SCROLLABLE --}}
                <div class="space-y-4 overflow-y-auto max-h-[500px] pr-2 scrollbar-thin">
                    @forelse($keranjang as $key => $item)
                        @php
                            if ($item instanceof \App\Models\Keranjang) {
                                $produk = $item->produk;
                                $foto = $produk?->fotos?->first()?->foto ?? null;
                                $warna = $item->warna;
                                $ukuran = $item->ukuran;
                                $jumlah = $item->jumlah;
                            } else {
                                $produk = (object) [
                                    'nama_produk' => $item['nama_produk'] ?? 'Produk tidak ditemukan',
                                    'harga' => $item['harga'] ?? 0,
                                    'diskon' => $item['diskon'] ?? 0,
                                    'deskripsi' => $item['deskripsi'] ?? '-',
                                ];
                                $foto = $item['foto'] ?? null;
                                $warna = $item['warna'] ?? '-';
                                $ukuran = $item['ukuran'] ?? '-';
                                $jumlah = $item['jumlah'] ?? 1;
                            }

                            $diskon = $produk->diskon ?? 0;
                            $hargaFinal = $diskon > 0 ? $produk->harga - ($produk->harga * $diskon / 100) : $produk->harga;
                        @endphp

                        <div class="item-card flex gap-4 p-4 rounded-lg border border-gray-200 bg-white items-start relative">

                            {{-- CHECKBOX PRODUK --}}
                            <div class="flex items-start pt-1">
                                <input type="checkbox" class="select-item w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    data-keranjang="{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}"
                                    data-nama="{{ $produk->nama_produk }}" data-warna="{{ $warna }}" data-ukuran="{{ $ukuran }}"
                                    data-harga="{{ $hargaFinal }}" data-jumlah="{{ $jumlah }}">
                            </div>

                            {{-- GAMBAR PRODUK --}}
                            <div class="w-20 h-20 md:w-24 md:h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                @if($foto)
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Produk" class="object-cover w-full h-full">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 text-xs italic">Belum ada foto</span>
                                    </div>
                                @endif
                            </div>

                            {{-- INFORMASI PRODUK --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-800 truncate">{{ $produk->nama_produk }}</h3>
                                <p class="text-gray-500 text-sm mt-1 line-clamp-1 md:line-clamp-2">{{ $produk->deskripsi }}</p>

                                <div class="flex flex-wrap gap-2 mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Warna: {{ $warna }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Ukuran: {{ $ukuran }}
                                    </span>
                                </div>

                                {{-- HARGA --}}
                                <div class="flex items-center mt-3">
                                    @if($diskon > 0)
                                        <span class="font-bold text-lg text-red-600">IDR {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                                        <span class="ml-2 text-sm text-gray-500 line-through">IDR {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                        <span class="ml-2 text-xs font-medium bg-red-100 text-red-800 px-1.5 py-0.5 rounded">{{ $diskon }}%</span>
                                    @else
                                        <span class="font-bold text-lg text-gray-800">IDR {{ number_format($hargaFinal, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                {{-- QUANTITY --}}
                                <div class="flex items-center mt-3">
                                    <button
                                        onclick="updateQuantity('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}', -1)"
                                        class="quantity-btn w-8 h-8 flex items-center justify-center bg-gray-100 rounded-l-md hover:bg-gray-200 transition font-medium text-gray-700">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>

                                    <span id="qty-{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}"
                                        class="w-10 h-8 flex items-center justify-center bg-white border-y border-gray-200 text-gray-700 text-sm font-medium">
                                        {{ $jumlah }}
                                    </span>

                                    <button
                                        onclick="updateQuantity('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}', 1)"
                                        class="quantity-btn w-8 h-8 flex items-center justify-center bg-gray-100 rounded-r-md hover:bg-gray-200 transition font-medium text-gray-700">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 mb-2">Keranjang Belanja Kosong</h3>
                            <p class="text-gray-500 mb-6">Silakan tambahkan produk ke keranjang Anda.</p>
                            <a href="{{ route('customer.dashboard') }}" 
                               class="inline-flex items-center gap-2 bg-gray-800 text-white px-5 py-2.5 rounded-lg hover:bg-gray-700 transition-all duration-300">
                                <i class="fas fa-store"></i>
                                <span>Mulai Belanja</span>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT: ORDER INFORMATION --}}
            <div class="summary bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit sticky top-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-5">Ringkasan Pesanan</h3>

                <div class="space-y-3 mb-5">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span id="subtotal" class="font-medium text-gray-800">IDR 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Layanan</span>
                        <span class="font-medium text-gray-800">IDR 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pengiriman</span>
                        <span class="font-medium text-gray-800">Gratis</span>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-4 mb-5">
                    <div class="flex justify-between text-lg font-semibold">
                        <span class="text-gray-800">Total</span>
                        <span id="total" class="text-gray-900">IDR 0</span>
                    </div>
                </div>

                <form id="checkout-form" action="{{ route('customer.checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="selected_items" id="selected-items">
                    @auth
                        <button type="submit"
                            class="checkout-btn w-full mt-2 bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium"
                            id="checkout-btn" disabled>
                            <i class="fas fa-credit-card mr-2"></i>
                            Checkout
                        </button>
                    @else
                        <button type="button" onclick="openLoginModal()"
                            class="checkout-btn w-full mt-2 bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium"
                            id="checkout-btn" disabled>
                            <i class="fas fa-credit-card mr-2"></i>
                            Checkout
                        </button>
                    @endauth
                </form>
                
                <div class="mt-4 text-center text-sm text-gray-500">
                    <p><i class="fas fa-lock mr-1"></i> Pembayaran aman dan terenkripsi</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk mengupdate quantity produk
        function updateQuantity(itemId, change) {
            const qtyElement = document.getElementById(`qty-${itemId}`);
            let currentQty = parseInt(qtyElement.textContent);
            let newQty = currentQty + change;
            
            if (newQty < 1) newQty = 1;
            
            qtyElement.textContent = newQty;
            
            // Update data-jumlah pada checkbox jika produk ini dipilih
            const checkbox = document.querySelector(`.select-item[data-keranjang="${itemId}"]`);
            if (checkbox) {
                checkbox.dataset.jumlah = newQty;
            }
            
            // Hitung ulang total jika produk ini dipilih
            if (checkbox && checkbox.checked) {
                calculateTotal();
            }
        }
        
        // Fungsi untuk menghitung total
        function calculateTotal() {
            let subtotal = 0;
            const selectedItems = [];
            
            document.querySelectorAll('.select-item:checked').forEach(checkbox => {
                const harga = parseFloat(checkbox.dataset.harga);
                const jumlah = parseInt(checkbox.dataset.jumlah);
                subtotal += harga * jumlah;
                
                selectedItems.push(checkbox.dataset.keranjang);
            });
            
            document.getElementById('subtotal').textContent = 'IDR ' + formatNumber(subtotal);
            document.getElementById('total').textContent = 'IDR ' + formatNumber(subtotal);
            document.getElementById('selected-items').value = selectedItems.join(',');
            
            // Enable/disable tombol checkout
            const checkoutBtn = document.getElementById('checkout-btn');
            checkoutBtn.disabled = selectedItems.length === 0;
        }
        
        // Fungsi untuk format angka dengan pemisah ribuan
        function formatNumber(num) {
            return num.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        // Event listener untuk checkbox produk
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-item').forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotal);
            });
            
            // Event listener untuk checkbox "Pilih Semua"
            document.getElementById('select-all').addEventListener('change', function() {
                const isChecked = this.checked;
                document.querySelectorAll('.select-item').forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                calculateTotal();
            });
            
            // Fungsi untuk modal login (placeholder)
            window.openLoginModal = function() {
                alert('Silakan login untuk melanjutkan checkout.');
            };
        });
    </script>
@endsection