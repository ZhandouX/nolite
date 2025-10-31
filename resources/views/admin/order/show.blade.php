@extends('layouts.admin_app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="min-h-screen bg-gray-50 py-10 px-4">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-8 relative">

            {{-- KEMBALI --}}
            <a href="{{ route('admin.order.index') }}"
                class="absolute top-4 left-4 text-gray-500 hover:text-gray-700 flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>

            {{-- HEADER --}}
            <div class="text-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Detail Pesanan</h1>
                <p class="text-gray-500 mt-1">#{{ $order->id }}</p>
            </div>

            {{-- INFORMASI PELANGGAN --}}
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-700">Informasi Penerima</h2>
                    <div class="space-y-1 text-gray-600">
                        <p><span class="font-medium">Nama:</span> {{ $order->nama_penerima ?? '-' }}</p>
                        <p><span class="font-medium">Telepon:</span> {{ $order->no_hp ?? '-' }}</p>
                        <p><span class="font-medium">Alamat:</span> {{ $order->provinsi ?? '-' }},
                            {{ $order->kota ?? '-' }}, {{ $order->alamat_detail ?? '-' }}
                        </p>
                        <!-- <p><span class="font-medium">Detail Alamat:</span> {{ $order->alamat_detail ?? '-' }}</p> -->
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2 text-gray-700">Status Pesanan</h2>
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 rounded-full text-sm font-medium 
                                            @if($order->status == 'menunggu') bg-yellow-100 text-yellow-700
                                            @elseif($order->status == 'diproses') bg-blue-100 text-blue-700
                                            @elseif($order->status == 'dikirim') bg-purple-100 text-purple-700
                                            @else bg-green-100 text-green-700 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                        <p class="text-gray-500 text-sm">
                            {{ $order->created_at->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- DAFTAR PRODUK --}}
            <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Daftar Produk</h2>

            <div class="divide-y divide-gray-200">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-center space-x-4">
                            @if ($item->produk->fotos->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->produk->fotos->first()->foto) }}"
                                    class="w-16 h-16 rounded-lg object-cover border" alt="Foto Produk">
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif

                            <div>
                                <p class="font-medium text-gray-800">{{ $item->produk->nama_produk ?? 'Produk tidak tersedia' }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $item->jumlah }} pcs × IDR
                                    {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- HARGA PRODUK --}}
                        <div class="mt-1">
                            @if(!empty($item->diskon) && $item->diskon > 0)
                                <div class="flex flex-col">
                                    <span class="text-gray-400 text-sm line-through">
                                        IDR {{ number_format($item->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-red-600 font-semibold">
                                        IDR {{ number_format($item->harga_diskon, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-green-600 font-medium mt-0.5">
                                        -{{ $item->diskon }}%
                                    </span>
                                </div>
                            @else
                                <span class="font-semibold text-gray-800">
                                    IDR {{ number_format($item->harga_diskon, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- TOTAL PEMBAYARAN --}}
            <div class="mt-6 text-right border-t pt-4">
                <p class="text-gray-700 text-lg font-semibold">
                    Total Pembayaran:
                    <span class="text-red-900">
                        IDR {{ number_format($order->subtotal, 0, ',', '.') }}
                    </span>
                </p>
                <hr class="w-full mt-2 mb-2">
                <p class="text-gray-700 text-lg font-semibold">
                    Metode Pembayaran:
                    <span class="text-blue-600">
                        {{ $order->metode_pembayaran }}
                    </span>
                </p>
            </div>

            {{-- AKSI --}}
            <div class="flex justify-end mt-8 space-x-3">
                <a href="{{ route('admin.order.index') }}"
                    class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                    <i class="fa-solid fa-list mr-1"></i> Semua Pesanan
                </a>

                <button onclick="toggleModal({{ $order->id }})"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition">
                    <i class="fa-solid fa-rotate-right mr-1"></i> Ubah Status
                </button>
            </div>

            <!-- MODAL UPDATE STATUS -->
            @include('layouts.partials_admin.modals.update-status')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    </script>
@endpush