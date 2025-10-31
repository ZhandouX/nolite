@extends('layouts.admin_app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Breadcrumb -->
        <nav class="mb-6" aria-label="breadcrumb">
            <ol class="flex items-center gap-2 text-sm text-gray-600">
                <li><a href="{{ route('admin.produk.index') }}" class="hover:text-blue-600 transition">Produk</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-900 font-medium">{{ $produk->nama_produk }}</li>
            </ol>
        </nav>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid md:grid-cols-5 gap-8 p-8">
                <!-- Galeri Foto -->
                <div class="md:col-span-2">
                    <div class="sticky top-8">
                        @if($produk->fotos->isNotEmpty())
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($produk->fotos as $foto)
                                    <div class="aspect-square rounded-lg overflow-hidden bg-gray-50 border border-gray-200">
                                        <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $produk->nama_produk }}"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="aspect-square rounded-lg bg-gray-50 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="mdi mdi-image-outline text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-gray-500 text-sm">Belum ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Produk -->
                <div class="md:col-span-3 space-y-6">
                    <!-- Header -->
                    <div class="border-b border-gray-200 pb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $produk->nama_produk }}</h1>
                        <div class="flex items-baseline gap-2">
                            <p class="text-sm">
                                @if($produk->diskon && $produk->diskon > 0)
                                    {{-- Harga asli dicoret --}}
                                    <span class="text-gray-400 line-through text-lg">
                                        IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <br>
                                    {{-- Harga diskon --}}
                                    <span class="text-3xl font-bold text-blue-600">
                                        IDR
                                        {{ number_format($produk->harga - ($produk->harga * $produk->diskon / 100), 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-3xl font-bold text-blue-600">
                                        IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                @endif
                            </p>
                            <span class="text-gray-500">· Stok: <span
                                    class="font-semibold text-gray-700">{{ $produk->jumlah }}</span></span>
                        </div>
                    </div>

                    <!-- Spesifikasi -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-900">Spesifikasi</h2>
                        <div class="grid gap-3">
                            <div class="flex py-3 border-b border-gray-100">
                                <span class="w-32 text-gray-600 text-sm">Jenis</span>
                                <span class="flex-1 text-gray-900 font-medium">{{ $produk->jenis }}</span>
                            </div>
                            <div class="flex py-3 border-b border-gray-100">
                                <span class="w-32 text-gray-600 text-sm">Warna</span>
                                <span
                                    class="flex-1 text-gray-900">{{ is_array($produk->warna) ? implode(', ', $produk->warna) : ($produk->warna ?? '-') }}</span>
                            </div>
                            <div class="flex py-3 border-b border-gray-100">
                                <span class="w-32 text-gray-600 text-sm">Ukuran</span>
                                <span
                                    class="flex-1 text-gray-900">{{ is_array($produk->ukuran) ? implode(', ', $produk->ukuran) : ($produk->ukuran ?? '-') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    @if($produk->deskripsi)
                        <div class="space-y-3">
                            <h2 class="text-lg font-semibold text-gray-900">Deskripsi</h2>
                            <p class="text-gray-700 leading-relaxed">{{ $produk->deskripsi }}</p>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div class="flex gap-6 text-xs text-gray-500 pt-4 border-t border-gray-100">
                        <div>
                            <span class="font-medium">Dibuat:</span> {{ $produk->created_at->format('d M Y, H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">Diupdate:</span> {{ $produk->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.produk.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    <i class="mdi mdi-arrow-left"></i>
                    Kembali
                </a>
                <a href="{{ route('admin.produk.edit', $produk->id) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="mdi mdi-pencil"></i>
                    Edit Produk
                </a>
                <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="ml-auto"
                    onsubmit="return confirm('Yakin hapus produk ini beserta semua fotonya?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <i class="mdi mdi-delete"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection