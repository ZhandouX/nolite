@extends('layouts.user_app')

@section('content')
    <div class="min-h-screen bg-gray-100 py-20 px-8 md:py-20 md:px-20">
        <div class="max-w-10xl md:max-w-6xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-red-900 to-red-800 text-white px-6 py-5">
                <h1 class="text-2xl font-bold">Detail Pesanan #{{ $order->id }}</h1>
                <p class="text-red-100 mt-1">Status:
                    <span class="font-semibold capitalize">{{ $order->status }}</span>
                </p>
            </div>

            <!-- Body -->
            <div class="p-6">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- ==================== KIRI ==================== -->
                    <div class="space-y-8">
                        <!-- Informasi Penerima -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl shadow-sm p-5">
                            <h2 class="font-bold text-center text-gray-700 text-lg mb-4 bg-blue-100/70 rounded-md py-2">
                                Informasi Penerima
                            </h2>

                            <div class="grid grid-cols-[160px_1fr] gap-y-2 text-gray-700">
                                <p><strong>Nama Penerima</strong></p>
                                <p>: {{ $order->nama_penerima }}</p>

                                <p><strong>No HP</strong></p>
                                <p>: {{ $order->no_hp }}</p>

                                <p><strong>Email</strong></p>
                                <p>: {{ $order->email ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Alamat Pengiriman -->
                        <div class="bg-green-50 border border-green-200 rounded-xl shadow-sm p-5">
                            <h2
                                class="font-semibold text-center text-gray-700 text-lg mb-4 bg-green-100/70 rounded-md py-2">
                                Alamat Pengiriman
                            </h2>

                            <div class="grid grid-cols-[160px_1fr] gap-y-2 text-gray-700">
                                <p><strong>Provinsi</strong></p>
                                <p>: {{ $order->provinsi }}</p>

                                <p><strong>Kota</strong></p>
                                <p>: {{ $order->kota }}</p>

                                <p><strong>Alamat Detail</strong></p>
                                <p>: {{ $order->alamat_detail }}</p>

                                <p><strong>Latitude</strong></p>
                                <p>: {{ $order->latitude ?? '-' }}</p>

                                <p><strong>Longitude</strong></p>
                                <p>: {{ $order->longitude ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== KANAN ==================== -->
                    <div class="space-y-8">
                        <!-- Pembayaran -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl shadow-sm p-5">
                            <h2
                                class="font-semibold text-center text-gray-700 text-lg mb-4 bg-yellow-100/70 rounded-md py-2">
                                Pembayaran
                            </h2>

                            <div class="grid grid-cols-[160px_1fr] gap-y-2 text-gray-700">
                                <p><strong>Metode Pembayaran</strong></p>
                                <p>: {{ $order->metode_pembayaran ?? '-' }}</p>

                                <p><strong>Total Pembayaran</strong></p>
                                <p>:
                                    <span class="text-red-800 font-semibold">
                                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Produk yang Dipesan -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl shadow-sm p-5">
                            <h2 class="font-semibold text-center text-gray-700 text-lg mb-4 bg-gray-100 rounded-md py-2">
                                Produk Dipesan
                            </h2>

                            <div class="space-y-4" id="productList">
                                @foreach($order->items->take(3) as $item)
                                    @php
                                        $produk = $item->produk;
                                        $foto = $produk->fotos->isNotEmpty()
                                            ? asset('storage/' . $produk->fotos->first()->foto)
                                            : asset('assets/images/no-image.png');
                                    @endphp

                                    <div
                                        class="flex bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                                        <a href="{{ route('produk.detail', $produk->id) }}" class="block">
                                            <img src="{{ $foto }}" alt="{{ $produk->nama_produk }}"
                                                class="w-28 h-28 object-cover">
                                        </a>
                                        <div class="flex-1 p-4">
                                            <a href="{{ route('produk.detail', $produk->id) }}" class="hover:underline">
                                                <h3 class="font-semibold text-gray-800">{{ $produk->nama_produk }}</h3>
                                            </a>
                                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $produk->deskripsi }}</p>

                                            <div class="flex justify-between items-center mt-3">
                                                @if($produk->diskon && $produk->diskon > 0)
                                                    @php
                                                        $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon / 100);
                                                    @endphp
                                                    <div class="flex flex-col">
                                                        <span class="text-gray-400 text-sm line-through">
                                                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                                        </span>
                                                        <span class="text-red-800 font-bold">
                                                            Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-red-800 font-bold">
                                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                                    </span>
                                                @endif

                                                <span class="text-sm text-gray-600">x{{ $item->jumlah }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($order->items->count() > 3)
                                <div class="mt-3 text-center">
                                    <button id="showMoreBtn" class="text-red-800 font-semibold hover:underline">
                                        Lihat lainnya ({{ $order->items->count() - 3 }})
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <!-- Footer -->
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 flex justify-end">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    @if($order->items->count() > 3)
        <!-- Modal Lihat Lainnya -->
        <div id="moreModal" class="fixed z-[9999] inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto p-6 relative">
                <button onclick="toggleModal(false)" class="absolute top-3 right-4 text-gray-500 text-xl">&times;</button>
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Semua Produk Dipesan</h2>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        @php
                            $produk = $item->produk;
                            $foto = $produk->fotos->isNotEmpty()
                                ? asset('storage/' . $produk->fotos->first()->foto)
                                : asset('assets/images/no-image.png');
                        @endphp

                        <div class="flex bg-gray-50 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
                            <a href="{{ route('produk.detail', $produk->id) }}" class="block">
                                <img src="{{ $foto }}" alt="{{ $produk->nama_produk }}" class="w-28 h-28 object-cover">
                            </a>

                            <div class="flex-1 p-4">
                                <a href="{{ route('produk.detail', $produk->id) }}" class="hover:underline">
                                    <h3 class="font-semibold text-gray-800">{{ $produk->nama_produk }}</h3>
                                </a>

                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $produk->deskripsi }}</p>

                                <div class="flex justify-between items-center mt-3">
                                    @if($produk->diskon && $produk->diskon > 0)
                                        @php
                                            $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon / 100);
                                        @endphp
                                        <div class="flex flex-col">
                                            <span class="text-gray-400 text-sm line-through">
                                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                            </span>
                                            <span class="text-red-800 font-bold">
                                                Rp {{ number_format($hargaDiskon, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-red-800 font-bold">
                                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        </span>
                                    @endif

                                    <span class="text-sm text-gray-600">x{{ $item->jumlah }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            const modal = document.getElementById('moreModal');
            const showMoreBtn = document.getElementById('showMoreBtn');
            showMoreBtn.addEventListener('click', () => toggleModal(true));

            function toggleModal(show) {
                modal.classList.toggle('hidden', !show);
                modal.classList.toggle('flex', show);
            }
        </script>
    @endif
@endsection