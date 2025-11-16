@extends('layouts.user_app')

@section('title', 'Checkout Berhasil')

@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-20 px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center">
            <div class="text-green-500 text-6xl mb-4">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h1 class="text-2xl font-semibold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
            <p class="text-gray-600 text-sm mb-6">Pesanan kamu telah kami terima dan sedang diproses.</p>

            <div class="text-left text-sm border-t border-b py-4 mb-6">
                <p><strong>Kode Pesanan:</strong> #{{ $order->id }}</p>
                <p><strong>Nama Penerima:</strong> {{ $order->nama_penerima }}</p>
                <p><strong>Total Pembayaran:</strong> Rp{{ number_format($order['subtotal'], 0, ',', '.') }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran }}</p>
                <p><strong>Status:</strong> <span class="text-yellow-600">{{ $order->status }}</span></p>
            </div>

            <h3 class="text-sm font-semibold text-gray-800 mb-3">Detail Produk</h3>
            <ul class="text-sm text-gray-600 mb-6 space-y-2">
                @foreach($order->items as $item)
                    <li class="border rounded-md p-3">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">{{ $item->nama_produk }}</p>
                                <p class="text-xs text-gray-500">Warna: {{ $item->warna }} | Ukuran: {{ $item->ukuran }}</p>
                            </div>
                            <span class="font-semibold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            <a href="{{ route('customer.dashboard') }}"
                class="inline-block bg-gray-700 hover:bg-gray-500 text-white px-6 py-2 rounded-md font-semibold text-sm transition-all">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection