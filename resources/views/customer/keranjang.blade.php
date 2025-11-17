@extends('layouts.user_app')

@section('title', 'Keranjang')

@section('content')
    <div class="container mx-auto px-2 py-2 md:py-6 md:px-6 mb-4 pt-14 md:pt-6">

        {{-- BACK BUTTON --}}
        <div class="flex justify-end mb-4 mt-4">
            <a href="{{ route('customer.dashboard') }}"
                class="inline-flex items-center gap-2 bg-gray-800 text-white px-3 py-1.5 rounded-lg hover:bg-gray-600 transition text-sm">
                <i class="fa fa-arrow-left text-xs"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="cart-container grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- LEFT: PRODUCT LIST --}}
            <div class="cart-items md:col-span-2 bg-white p-4 rounded-xl shadow-sm border border-gray-100">

                {{-- HEADER --}}
                <div class="cart-header flex justify-between items-center mb-3 sticky top-0 bg-white z-10 pb-2 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">Keranjang Belanja</h2>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        <label for="select-all" class="text-gray-700 text-sm cursor-pointer font-medium">Pilih Semua</label>
                    </div>
                </div>

                {{-- DAFTAR PRODUK SCROLLABLE --}}
                <div class="overflow-y-auto max-h-[450px] pr-1 space-y-3">
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

                        <div class="item-keranjang flex gap-3 p-3 rounded-lg border border-gray-200 hover:border-gray-300 transition-all duration-200 bg-white hover:bg-gray-50"
                            data-id="{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}">

                            {{-- CHECKBOX PRODUK --}}
                            <input type="checkbox" class="select-item w-4 h-4 text-blue-600 border-gray-300 mt-4 focus:ring-blue-500"
                                data-keranjang="{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}"
                                data-nama="{{ $produk->nama_produk }}" data-warna="{{ $warna }}" data-ukuran="{{ $ukuran }}"
                                data-harga="{{ $hargaFinal }}" data-jumlah="{{ $jumlah }}">

                            {{-- GAMBAR PRODUK --}}
                            <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center border border-gray-200">
                                @if($foto)
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Produk" class="object-cover w-full h-full">
                                @else
                                    <span class="text-gray-400 italic text-xs">No image</span>
                                @endif
                            </div>

                            {{-- INFORMASI PRODUK --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-800 truncate">{{ $produk->nama_produk }}</h3>
                                        <p class="text-gray-500 text-xs mt-0.5 line-clamp-1">{{ $produk->deskripsi }}</p>
                                    </div>
                                    
                                    {{-- HARGA --}}
                                    <div class="flex flex-col items-end ml-2">
                                        @if($diskon > 0)
                                            <p class="line-through text-gray-400 text-xs">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                                            <p class="font-bold text-red-600 text-sm">Rp{{ number_format($hargaFinal, 0, ',', '.') }}</p>
                                        @else
                                            <p class="font-bold text-gray-800 text-sm">Rp{{ number_format($hargaFinal, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- WARNA & UKURAN --}}
                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <span class="font-medium">Warna:</span>
                                        <span class="font-semibold text-gray-800">{{ $warna }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="font-medium">Ukuran:</span>
                                        <span class="font-semibold text-gray-800">{{ $ukuran }}</span>
                                    </div>
                                </div>

                                {{-- QUANTITY --}}
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center gap-1">
                                        <button
                                            onclick="updateQuantity('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}', -1)"
                                            class="w-6 h-6 flex items-center justify-center bg-gray-100 rounded hover:bg-gray-200 transition text-gray-700 text-sm">-</button>

                                        <span id="qty-{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}"
                                            class="w-8 h-6 flex items-center justify-center border border-gray-300 rounded text-gray-700 text-sm">{{ $jumlah }}</span>

                                        <button
                                            onclick="updateQuantity('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}', 1)"
                                            class="w-6 h-6 flex items-center justify-center bg-gray-100 rounded hover:bg-gray-200 transition text-gray-700 text-sm">+</button>
                                    </div>
                                    
                                    {{-- DELETE BUTTON --}}
                                    <!-- <button onclick="removeItem('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}')" 
                                        class="text-red-500 hover:text-red-700 transition text-xs font-medium">
                                        Hapus
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fa fa-shopping-cart text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Keranjang belanja Anda kosong</p>
                            <a href="{{ route('customer.dashboard') }}" class="inline-block mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT: ORDER INFORMATION --}}
            <div class="summary bg-white p-4 rounded-xl shadow-sm border border-gray-100 sticky top-4">
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Ringkasan Pesanan</h3>

                <div class="space-y-2 mb-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span id="subtotal" class="font-medium">Rp0</span>
                    </div>
                    <!-- <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Biaya Layanan</span>
                        <span class="font-medium">Rp0</span>
                    </div> -->
                </div>
                
                <div class="flex justify-between text-base font-bold border-t border-gray-200 pt-3">
                    <span>Total</span>
                    <span id="total" class="text-blue-600">Rp0</span>
                </div>

                <form id="checkout-form" action="{{ route('customer.checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="selected_items" id="selected-items">
                    @auth
                        <button type="submit"
                            class="checkout-btn w-full mt-4 bg-gray-600 text-white py-2.5 rounded-lg hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition font-medium shadow-sm"
                            id="checkout-btn" disabled>
                            <i class="fa fa-shopping-bag mr-2"></i>
                            Checkout
                        </button>
                    @else
                        <button type="button" onclick="openLoginModal()"
                            class="checkout-btn w-full mt-4 bg-gray-600 text-white py-2.5 rounded-lg hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition font-medium shadow-sm"
                            id="checkout-btn" disabled>
                            <i class="fa fa-shopping-bag mr-2"></i>
                            Checkout
                        </button>
                    @endauth
                </form>
                
                <div class="mt-3 text-xs text-gray-500 text-center">
                    <i class="fa fa-lock mr-1"></i>
                    Transaksi aman dan terenkripsi
                </div>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection