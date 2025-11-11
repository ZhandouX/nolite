@extends('layouts.user_app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8 mt-10 md:mt-0">
        <div class="max-w-[1100px] mx-auto">
            <!-- Header dengan gradien yang lebih menarik -->
            <div class="mb-10">
                <div class="flex flex-row sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div class="space-y-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Pesanan #{{ $order->id }}</h1>
                        <div class="flex items-center gap-1 md:gap-3">
                            <span class="text-gray-600 font-medium">Status:</span>

                            @php
                                $statusColors = [
                                    'menunggu' => 'bg-yellow-500 text-white',
                                    'diproses' => 'bg-blue-500 text-white',
                                    'dikirim' => 'bg-purple-500 text-white',
                                    'selesai' => 'bg-green-600 text-white',
                                    'batal' => 'bg-red-600 text-white',
                                ];

                                $colorClass = $statusColors[$order->status] ?? 'bg-gray-600 text-white';
                            @endphp

                            <span class="px-3 py-1 rounded-full text-sm font-semibold capitalize {{ $colorClass }}">
                                {{ $order->status }}
                            </span>
                        </div>

                    </div>
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 mt-[20px] md:mt-0 rounded-full md:rounded-lg bg-gray-700 text-white hover:bg-gray-600 transition-all duration-200 shadow-sm hover:shadow-md self-start">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                        Kembali
                    </a>
                </div>
                <div class="h-1 bg-gradient-to-r from-gray-700 to-gray-400 rounded-full"></div>
            </div>

            <!-- Grid layout responsif -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Kolom Kiri -->
                <div class="space-y-8">
                    <!-- Informasi Penerima -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-5 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-user"></i>
                                Informasi Penerima
                            </h2>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">Nama Penerima</span>
                                <span class="text-gray-800 font-semibold flex-1">{{ $order->nama_penerima }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">No HP</span>
                                <span class="text-gray-800 font-semibold flex-1">{{ $order->no_hp }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">Email</span>
                                <span class="text-gray-800 font-semibold flex-1">{{ $order->email ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-5 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-location-dot"></i>
                                Alamat Pengiriman
                            </h2>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">Provinsi</span>
                                <span class="text-gray-800 font-semibold flex-1">{{ $order->provinsi }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">Kota</span>
                                <span class="text-gray-800 font-semibold flex-1">{{ $order->kota }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">Alamat Detail</span>
                                <span class="text-gray-800 font-semibold flex-1">{{ $order->alamat_detail }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-8">
                    <!-- Pembayaran -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-5 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-credit-card"></i>
                                Pembayaran
                            </h2>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">Metode Pembayaran</span>
                                <span
                                    class="text-gray-800 font-semibold flex-1">{{ $order->metode_pembayaran ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <span class="text-gray-500 font-medium w-40 mb-1 sm:mb-0">Total Pembayaran</span>
                                <span class="text-gray-800 font-bold text-xl flex-1">
                                    IDR {{ number_format($order->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Produk yang Dipesan -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-5 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-box"></i>
                                Produk Dipesan
                            </h2>
                        </div>
                        <div class="p-5">
                            <div class="space-y-4" id="productList">
                                @foreach($order->items->take(3) as $item)
                                    @php
                                        $produk = $item->produk;
                                        $foto = $produk->fotos->isNotEmpty()
                                            ? asset('storage/' . $produk->fotos->first()->foto)
                                            : asset('assets/images/no-image.png');
                                    @endphp

                                    <div
                                        class="flex bg-gray-50 rounded-lg border border-gray-200 overflow-hidden transition-all duration-200 hover:shadow-sm">

                                        <!-- FOTO PRODUK -->
                                        <a href="{{ route('produk.detail', $produk->id) }}" class="relative flex-shrink-0">
                                            <img src="{{ $foto }}" alt="{{ $produk->nama_produk }}"
                                                class="w-[100px] h-full sm:w-[120px] object-cover">

                                            <!-- JUMLAH ITEM (pojok kanan bawah foto) -->
                                            <span
                                                class="absolute bottom-1 right-1 bg-white/90 text-gray-800 text-[10px] sm:text-xs font-semibold px-2 py-1 rounded-full shadow">
                                                x{{ $item->jumlah }}
                                            </span>
                                        </a>

                                        <!-- INFO PRODUK -->
                                        <div class="flex-1 p-3 sm:p-4">
                                            <a href="{{ route('produk.detail', $produk->id) }}"
                                                class="hover:text-gray-600 transition-colors">
                                                <h3 class="font-semibold text-gray-800 text-sm sm:text-base line-clamp-1">
                                                    {{ $produk->nama_produk }}
                                                </h3>
                                            </a>
                                            <p class="text-xs sm:text-sm text-gray-500 m1-1 line-clamp-1">
                                                {{ $produk->deskripsi }}
                                            </p>

                                            <div class="flex justify-between items-center mt-3">
                                                @if($produk->diskon && $produk->diskon > 0)
                                                    @php
                                                        $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon / 100);
                                                    @endphp
                                                    <div class="flex flex-col">
                                                        <span class="text-gray-400 text-xs line-through">
                                                            IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                                        </span>
                                                        <span class="text-red-900 font-bold text-sm sm:text-base">
                                                            IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-gray-800 font-bold text-sm sm:text-base">
                                                        IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($order->items->count() > 3)
                                <div class="mt-5 text-center">
                                    <button id="showMoreBtn"
                                        class="text-gray-700 font-semibold hover:text-gray-900 transition-colors flex items-center justify-center gap-2 mx-auto">
                                        Lihat semua produk ({{ $order->items->count() }})
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($order->items->count() > 3)
        <!-- Modal Lihat Lainnya -->
        <div id="moreModal" class="fixed z-[9999] inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                <div class="bg-gradient-to-r from-gray-700 to-gray-600 px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">Semua Produk Dipesan</h2>
                    <button onclick="toggleModal(false)"
                        class="text-white hover:text-gray-200 text-2xl font-light leading-none transition-colors">&times;</button>
                </div>
                <div class="overflow-y-auto p-6">
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            @php
                                $produk = $item->produk;
                                $foto = $produk->fotos->isNotEmpty()
                                    ? asset('storage/' . $produk->fotos->first()->foto)
                                    : asset('assets/images/no-image.png');
                            @endphp

                            <div
                                class="flex max-h-[120px] bg-gray-50 rounded-lg border border-gray-200 overflow-hidden transition-all duration-200 hover:shadow-sm">
                                <a href="{{ route('produk.detail', $produk->id) }}" class="flex-shrink-0">
                                    <img src="{{ $foto }}" alt="{{ $produk->nama_produk }}"
                                        class="w-[100px] h-full sm:w-24 object-cover">
                                </a>

                                <div class="flex-1 p-4">
                                    <a href="{{ route('produk.detail', $produk->id) }}"
                                        class="hover:text-gray-600 transition-colors">
                                        <h3 class="font-semibold text-gray-800 text-sm sm:text-base line-clamp-1">{{ $produk->nama_produk }}</h3>
                                    </a>

                                    <p class="text-xs sm:text-sm text-gray-500 mt-1 line-clamp-1">{{ $produk->deskripsi }}</p>

                                    <div class="flex justify-between items-center mt-3">
                                        @if($produk->diskon && $produk->diskon > 0)
                                            @php
                                                $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon / 100);
                                            @endphp
                                            <div class="flex flex-col">
                                                <span class="text-gray-400 text-xs line-through">
                                                    IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                                </span>
                                                <span class="text-gray-800 font-bold text-sm sm:text-base">
                                                    IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-gray-800 font-bold text-sm sm:text-base">
                                                IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                            </span>
                                        @endif

                                        <span
                                            class="text-xs sm:text-sm text-white bg-gray-600 px-2 py-1 rounded-full border border-gray-200">x{{ $item->jumlah }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                document.body.style.overflow = show ? 'hidden' : 'auto';
            }

            // Tutup modal dengan menekan ESC
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    toggleModal(false);
                }
            });
        </script>
    @endif
@endsection