@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb & Header -->
            <div class="mb-8">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('admin.produk.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200">
                                <i class="fa-solid fa-shirt mr-1"></i>
                                Produk
                            </a>
                        </li>
                        <li class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-400 text-xs mx-2"></i>
                            <span class="text-gray-700 dark:text-gray-300 font-medium">Detail Produk</span>
                        </li>
                    </ol>
                </nav>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="shrink-0 h-12 w-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-eye text-white text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Detail Produk
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Informasi lengkap tentang produk
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300">
                <div class="grid md:grid-cols-5 gap-8 p-6 sm:p-8">
                    <!-- Galeri Foto -->
                    <div class="md:col-span-2">
                        <div class="sticky top-8 space-y-6">
                            <!-- Main Image -->
                            @if($produk->fotos->isNotEmpty())
                                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}" 
                                         alt="{{ $produk->nama_produk }}"
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                                         id="mainImage">
                                </div>

                                <!-- Thumbnail Gallery -->
                                @if($produk->fotos->count() > 1)
                                    <div class="grid grid-cols-4 gap-3">
                                        @foreach($produk->fotos as $index => $foto)
                                            <button type="button" 
                                                    class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 hover:border-primary-500 dark:hover:border-primary-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 {{ $index === 0 ? 'border-primary-500 dark:border-primary-500' : '' }}"
                                                    onclick="changeMainImage('{{ asset('storage/' . $foto->foto) }}', this)">
                                                <img src="{{ asset('storage/' . $foto->foto) }}" 
                                                     alt="{{ $produk->nama_produk }} - {{ $index + 1 }}"
                                                     class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <!-- Empty State -->
                                <div class="aspect-square rounded-xl bg-gray-100 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center">
                                    <div class="text-center p-6">
                                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <i class="fa-solid fa-image text-gray-400 dark:text-gray-500 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                            Belum ada foto
                                        </h3>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            Produk ini belum memiliki gambar
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi Produk -->
                    <div class="md:col-span-3 space-y-8">
                        <!-- Header & Harga -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <div class="flex items-start justify-between mb-4">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-white pr-4">
                                    {{ $produk->nama_produk }}
                                </h1>

                                <!-- Status Stok -->
                                <div class="shrink-0">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $produk->jumlah > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                        <i class="fa-solid {{ $produk->jumlah > 0 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1.5"></i>
                                        {{ $produk->jumlah > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Harga -->
                            <div class="flex items-baseline gap-4 flex-wrap">
                                @if($produk->diskon && $produk->diskon > 0)
                                    @php
                                        $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon / 100);
                                        $hemat = $produk->harga - $hargaDiskon;
                                    @endphp
                                    <div class="space-y-2">
                                        <!-- Harga Asli -->
                                        <div class="text-gray-400 dark:text-gray-500 line-through text-lg font-medium">
                                            IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                        </div>

                                        <!-- Harga Setelah Diskon -->
                                        <div class="flex items-baseline gap-3">
                                            <span class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                                                IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                -{{ $produk->diskon }}%
                                            </span>
                                        </div>

                                        <!-- Info Hemat -->
                                        <div class="text-sm text-green-600 dark:text-green-400 font-medium">
                                            <i class="fa-solid fa-piggy-bank mr-1"></i>
                                            Hemat IDR {{ number_format($hemat, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @else
                                    <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">
                                        IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                    </div>
                                @endif

                                <!-- Stok Info -->
                                <div class="text-gray-500 dark:text-gray-400 text-sm bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded-lg">
                                    <i class="fa-solid fa-boxes-stacked mr-1.5"></i>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $produk->jumlah }}</span> unit tersedia
                                </div>
                            </div>
                        </div>

                        <!-- Spesifikasi -->
                        <div class="space-y-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <i class="fa-solid fa-list-check text-primary-500 mr-2"></i>
                                Spesifikasi Produk
                            </h2>

                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 space-y-4">
                                <!-- Jenis -->
                                <div class="flex items-center py-3 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                    <div class="w-32 flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                        <i class="fa-solid fa-tag mr-2"></i>
                                        Jenis
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $produk->jenis }}</span>
                                    </div>
                                </div>

                                <!-- Warna -->
                                <div class="flex items-start py-3 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                    <div class="w-32 flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                        <i class="fa-solid fa-palette mr-2"></i>
                                        Warna
                                    </div>
                                    <div class="flex-1">
                                        @if(is_array($produk->warna))
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($produk->warna as $warna)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 border border-primary-200 dark:border-primary-800">
                                                        {{ $warna }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-900 dark:text-white font-medium">{{ $produk->warna ?? '-' }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Ukuran -->
                                <div class="flex items-start py-3 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                    <div class="w-32 flex items-center text-gray-600 dark:text-gray-400 text-sm">
                                        <i class="fa-solid fa-ruler mr-2"></i>
                                        Ukuran
                                    </div>
                                    <div class="flex-1">
                                        @if(is_array($produk->ukuran))
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($produk->ukuran as $ukuran)
                                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium text-sm bg-white dark:bg-gray-800">
                                                        {{ $ukuran }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-900 dark:text-white font-medium">{{ $produk->ukuran ?? '-' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        @if($produk->deskripsi)
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                    <i class="fa-solid fa-align-left text-primary-500 mr-2"></i>
                                    Deskripsi Produk
                                </h2>
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">{{ $produk->deskripsi }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Metadata -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-info-circle text-primary-500 mr-2"></i>
                                Informasi Tambahan
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fa-solid fa-calendar-plus mr-3 text-gray-400"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-300 mr-2">Dibuat:</span>
                                    {{ $produk->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-400">
                                    <i class="fa-solid fa-calendar-check mr-3 text-gray-400"></i>
                                    <span class="font-medium text-gray-700 dark:text-gray-300 mr-2">Diupdate:</span>
                                    {{ $produk->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="bg-gray-50 dark:bg-gray-700/80 px-6 sm:px-8 py-4 border-t border-gray-200 dark:border-gray-600 flex flex-col sm:flex-row items-center gap-3 transition-colors duration-200">
                    <a href="{{ route('admin.produk.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 w-full sm:w-auto order-2 sm:order-1">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>

                    <div class="flex items-center gap-3 ml-auto order-1 sm:order-2 w-full sm:w-auto justify-between sm:justify-start">
                        <a href="{{ route('admin.produk.edit', $produk->id) }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition-colors duration-200 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 flex-1 sm:flex-none">
                            <i class="fa-solid fa-pen-to-square mr-2"></i>
                            Edit Produk
                        </a>

                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" 
                              method="POST" 
                              class="flex-1 sm:flex-none"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini beserta semua fotonya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200 font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-trash mr-2"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function changeMainImage(imageSrc, element) {
        // Update main image
        document.getElementById('mainImage').src = imageSrc;

        // Remove active class from all thumbnails
        document.querySelectorAll('button[onclick^="changeMainImage"]').forEach(btn => {
            btn.classList.remove('border-primary-500', 'dark:border-primary-500');
            btn.classList.add('border-gray-200', 'dark:border-gray-600');
        });

        // Add active class to clicked thumbnail
        element.classList.remove('border-gray-200', 'dark:border-gray-600');
        element.classList.add('border-primary-500', 'dark:border-primary-500');
    }

    // Add fade-in animation to images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.classList.add('opacity-0');
            setTimeout(() => {
                img.classList.add('transition-opacity', 'duration-500');
                img.classList.remove('opacity-0');
            }, 100);
        });
    });
    </script>

    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection