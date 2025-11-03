@extends('layouts.user_app')

@section('title', 'Keranjang')

@section('content')
    <div class="container mx-auto px-10 py-10 mt-12">

        {{-- BACK BUTTON --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('customer.dashboard') }}"
                class="inline-flex items-center gap-2 bg-gray-800 text-white px-4 py-2 rounded-xl hover:bg-gray-500 transition">
                <i class="fa fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="cart-container grid md:grid-cols-3 gap-8">

            {{-- LEFT: PRODUCT LIST --}}
            <div class="cart-items md:col-span-2 bg-white p-6 rounded-2xl shadow border-gray-300">

                {{-- HEADER TETAP --}}
                <div
                    class="cart-header flex justify-between items-center mb-4 sticky top-0 bg-white z-10 pb-2 border-b border-gray-200">
                    <h2 class="text-2xl font-bold">Keranjang</h2>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 rounded border-gray-300">
                        <label for="select-all" class="text-gray-700 text-sm cursor-pointer">Pilih Semua</label>
                    </div>
                </div>

                {{-- DAFTAR PRODUK SCROLLABLE --}}
                <div
                    class="overflow-y-auto max-h-[500px] pr-2 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100">
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

                        <div class="item-keranjang flex gap-4 border-b pb-5 mb-5 items-start"
                            data-id="{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}">

                            {{-- CHECKBOX PRODUK --}}
                            <input type="checkbox" class="select-item w-4 h-4 text-blue-600 border-gray-300 mt-3"
                                data-keranjang="{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}"
                                data-nama="{{ $produk->nama_produk }}" data-warna="{{ $warna }}" data-ukuran="{{ $ukuran }}"
                                data-harga="{{ $hargaFinal }}" data-jumlah="{{ $jumlah }}">

                            {{-- GAMBAR PRODUK --}}
                            <div
                                class="w-28 h-28 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                @if($foto)
                                    <img src="{{ asset('storage/' . $foto) }}" alt="Produk" class="object-cover w-full h-full">
                                @else
                                    <span class="text-gray-400 italic text-sm">Belum ada foto</span>
                                @endif
                            </div>

                            {{-- INFORMASI PRODUK --}}
                            <div class="flex-1">
                                <h3 class="font-bold text-xl text-black-800">{{ $produk->nama_produk }}</h3>
                                <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $produk->deskripsi }}</p>

                                <div class="text-gray-500 text-sm mt-2">
                                    Warna: <span class="font-medium font-bold text-gray-900">{{ $warna }}</span>,
                                    Ukuran: <span class="font-medium font-bold text-gray-900">{{ $ukuran }}</span>
                                </div>

                                {{-- HARGA --}}
                                @if($diskon > 0)
                                    <div class="flex items-center gap-2 text-lg mt-2">
                                        <p class="line-through text-gray-400">IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                        </p>
                                        <p class="font-bold text-red-800">IDR {{ number_format($hargaFinal, 0, ',', '.') }}</p>
                                    </div>
                                @else
                                    <p class="text-lg font-bold mt-2">IDR {{ number_format($hargaFinal, 0, ',', '.') }}</p>
                                @endif

                                {{-- QUANTITY --}}
                                <div class="flex items-center mt-2 gap-2">
                                    <button
                                        onclick="updateQuantity('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}', -1)"
                                        class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 transition font-bold text-lg">-</button>

                                    <span id="qty-{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}"
                                        class="px-3 py-1 border rounded text-gray-700">{{ $jumlah }}</span>

                                    <button
                                        onclick="updateQuantity('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}', 1)"
                                        class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 transition font-bold text-lg">+</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">Keranjang kosong</p>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT: ORDER INFORMATION --}}
            <div class="summary bg-white p-6 rounded-2xl shadow">
                <h3 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h3>

                <div class="flex justify-between mb-2">
                    <span>Subtotal</span>
                    <span id="subtotal">IDR 0</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t pt-4">
                    <span>Total</span>
                    <span id="total">IDR 0</span>
                </div>

                <form id="checkout-form" action="{{ route('customer.checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="selected_items" id="selected-items">
                    @auth
                        <button type="submit"
                            class="checkout-btn w-full mt-5 bg-gray-600 text-white py-2.5 rounded-2xl hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="checkout-btn" disabled>
                            Checkout
                        </button>
                    @else
                        <button type="button" onclick="openLoginModal()"
                            class="checkout-btn w-full mt-5 bg-gray-600 text-white py-2.5 rounded-2xl hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="checkout-btn" disabled>
                            Checkout
                        </button>
                    @endauth
                </form>
            </div>
        </div>
    </div>
@endsection