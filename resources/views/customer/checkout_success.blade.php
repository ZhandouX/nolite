@extends('layouts.user_app')

@section('title', 'Checkout Berhasil')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-20 px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center">

            <div class="text-green-500 text-6xl mb-4">
                <i class="fa-solid fa-circle-check"></i>
            </div>

            <h1 class="text-2xl font-semibold text-gray-800 mb-2">
                Pembayaran Berhasil!
            </h1>

            <p class="text-gray-600 text-sm mb-6">
                Pesanan kamu telah kami terima dan sedang diproses.
            </p>

            {{-- DETAIL ORDER --}}
            <div class="text-left text-sm border-t border-b py-4 mb-6">
                <p><strong>Kode Pesanan:</strong> #{{ $order->id }}</p>
                <p><strong>Nama Penerima:</strong> {{ $order->nama_penerima }}</p>
                <p><strong>Total Pembayaran:</strong> Rp{{ number_format($order['subtotal'], 0, ',', '.') }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran }}</p>
                <p><strong>Status:</strong> <span class="text-yellow-600">{{ $order->status }}</span></p>
            </div>

            {{-- DETAIL PRODUK --}}
            <h3 class="text-sm font-semibold text-gray-800 mb-3">
                Detail Produk
            </h3>

            <ul class="text-sm text-gray-600 mb-6 space-y-2">
                @foreach ($order->items as $item)
                    <li class="border rounded-md p-3">

                        <div class="flex items-start gap-4">

                            {{-- IMAGE MAIN + GRID THUMB --}}
                            <div class="w-32">

                                @php
                                    $fotos = $item->produk?->fotos ?? collect();
                                    $main = $fotos->first();
                                @endphp

                                {{-- MAIN IMAGE --}}
                                @if ($main)
                                    <img id="main-img-{{ $item->id }}" src="{{ asset('storage/' . $main->foto) }}"
                                        class="w-full h-28 object-cover rounded-lg border shadow">
                                @else
                                    <img src="{{ asset('assets/images/no-image.png') }}"
                                        class="w-full h-28 object-cover rounded-lg border shadow">
                                @endif

                                {{-- GRID THUMBNAILS --}}
                                @if ($fotos->count() > 1)
                                    <div class="grid grid-cols-4 gap-2 mt-2">

                                        @foreach ($fotos->take(5) as $index => $foto)
                                            <button type="button"
                                                onclick="document.getElementById('main-img-{{ $item->id }}').src='{{ asset('storage/' . $foto->foto) }}'"
                                                class="aspect-square rounded-md overflow-hidden bg-gray-100 border hover:border-orange-500 transition">

                                                <img src="{{ asset('storage/' . $foto->foto) }}"
                                                    class="w-full h-full object-cover" alt="thumb {{ $index + 1 }}">
                                            </button>
                                        @endforeach

                                    </div>
                                @endif

                            </div>

                            {{-- INFO --}}
                            <div class="flex-1">
                                <div class="flex justify-between">

                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ $item->nama_produk }}
                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">
                                            Warna: {{ $item->warna }} | Ukuran: {{ $item->ukuran }}
                                        </p>
                                    </div>

                                    <span class="font-semibold text-gray-800">
                                        Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>

                                </div>
                            </div>

                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- ACTION BUTTON --}}
            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-2">

                <a href="{{ route('customer.orders.show', $order->id) }}"
                    class="w-full sm:w-auto bg-transparent hover:text-orange-500 text-gray-700 px-5 py-2 rounded-md font-semibold text-sm transition-all">
                    <i class="fa-solid fa-receipt mr-0"></i>
                    Detail Pesanan
                </a>

                <a href="{{ route('customer.invoice.download', $order->id) }}"
                    class="w-full sm:w-auto bg-transparent hover:text-green-500 text-blue-600 px-5 py-2 rounded-md font-semibold text-sm transition-all">
                    <i class="fa-solid fa-download mr-2"></i>
                    Download
                </a>

            </div>

            {{-- BACK --}}
            <a href="{{ route('customer.dashboard') }}"
                class="inline-block mt-6 bg-gray-700 hover:bg-gray-500 text-white px-6 py-2 rounded-md font-semibold text-sm transition-all">
                Kembali ke Dashboard
            </a>

        </div>
    </div>
@endsection
