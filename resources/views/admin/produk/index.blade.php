@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-transparent dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-screen mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center">
                        <div
                            class="shrink-0 h-12 w-12 rounded-tl-xl rounded-br-xl bg-primary-500 flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-shirt text-white text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Manajemen Produk dan Kategori
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Kelola Produk dan Kategori <strong>Nolite Aspiciens</strong>
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">

                        <!-- Tombol Tambah Kategori (Biru) -->
                        <a href="#" id="btnTambahKategori"
                            class="inline-flex items-center justify-center px-3 py-2
        bg-blue-600 hover:bg-blue-700
        dark:bg-blue-500 dark:hover:bg-blue-600
        text-white text-sm font-medium rounded-xl transition duration-200
        shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
        focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-plus mr-1 text-xs"></i>
                            Tambah Kategori
                        </a>

                        <!-- Tombol Daftar Kategori (Abu Tua) -->
                        <a href="#" id="btnDaftarKategori"
                            class="inline-flex items-center justify-center px-3 py-2
        bg-gray-700 hover:bg-gray-800
        dark:bg-gray-600 dark:hover:bg-gray-700
        text-white text-sm font-medium rounded-xl transition duration-200
        shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500
        focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-list mr-1 text-xs"></i>
                            Daftar Kategori
                        </a>

                        <!-- Tombol Tambah Produk (Hijau) -->
                        <a href="{{ route('admin.produk.create') }}"
                            class="inline-flex items-center justify-center px-3 py-2
        bg-green-600 hover:bg-green-700
        dark:bg-green-500 dark:hover:bg-green-600
        text-white text-sm font-medium rounded-xl transition duration-200
        shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500
        focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-plus mr-1 text-xs"></i>
                            Tambah Produk
                        </a>

                    </div>


                </div>
            </div>

            <!-- Card Container -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-all duration-300">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-blue-100 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-list text-primary-500 mr-3"></i>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Semua Produk
                            </h4>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $produks->count() }} produk ditemukan
                        </span>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-800 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Produk
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Warna & Ukuran
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Foto
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($produks as $produk)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 group">
                                    <!-- Produk -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-3">
                                            @if ($produk->fotos->isNotEmpty())
                                                <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}"
                                                    class="w-12 h-12 rounded-lg object-cover border border-gray-200 dark:border-gray-600 shadow-sm"
                                                    alt="{{ $produk->nama_produk }}">
                                            @else
                                                <div
                                                    class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                                                    <i class="fa-solid fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                                    {{ $produk->nama_produk }}
                                                </h4>
                                                <div class="mt-1 flex flex-wrap gap-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                        <i class="fa-solid fa-tag mr-1"></i>
                                                        {{ $produk->kategori?->nama_kategori ?? '-' }}
                                                    </span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $produk->jumlah > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                                        <i class="fa-solid fa-boxes-stacked mr-1"></i>
                                                        {{ $produk->jumlah }} stok
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Warna & Ukuran -->
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            <div>
                                                <span
                                                    class="text-xs font-medium text-gray-500 dark:text-gray-400">Warna:</span>
                                                <div class="mt-1 flex flex-wrap gap-1">
                                                    @if (is_array($produk->warna))
                                                        @foreach ($produk->warna as $warna)
                                                            <span
                                                                class="inline-block px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                                {{ $warna }}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span
                                                            class="inline-block px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                            {{ $produk->warna }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-xs font-medium text-gray-500 dark:text-gray-400">Ukuran:</span>
                                                <div class="mt-1 flex flex-wrap gap-1">
                                                    @if (is_array($produk->ukuran))
                                                        @foreach ($produk->ukuran as $ukuran)
                                                            <span
                                                                class="inline-block px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                                                {{ $ukuran }}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span
                                                            class="inline-block px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                                            {{ $produk->ukuran }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Harga -->
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @if ($produk->diskon && $produk->diskon > 0)
                                                @php
                                                    $hargaDiskon =
                                                        $produk->harga - ($produk->harga * $produk->diskon) / 100;
                                                    $potongan = ($produk->harga * $produk->diskon) / 100;
                                                    $hemat = $produk->harga - $hargaDiskon;
                                                    $persentaseHemat = ($hemat / $produk->harga) * 100;
                                                    $tingkatDiskon =
                                                        $persentaseHemat >= 50
                                                            ? 'bg-red-500'
                                                            : ($persentaseHemat >= 25
                                                                ? 'bg-orange-500'
                                                                : 'bg-green-500');
                                                    $warnaDiskon =
                                                        $persentaseHemat >= 50
                                                            ? 'text-red-100'
                                                            : ($persentaseHemat >= 25
                                                                ? 'text-orange-100'
                                                                : 'text-green-100');
                                                    $warnaBadge =
                                                        $persentaseHemat >= 50
                                                            ? 'bg-red-500'
                                                            : ($persentaseHemat >= 25
                                                                ? 'bg-orange-500'
                                                                : 'bg-green-500');
                                                    $warnaBadgeText =
                                                        $persentaseHemat >= 50
                                                            ? 'text-red-100'
                                                            : ($persentaseHemat >= 25
                                                                ? 'text-orange-100'
                                                                : 'text-green-100');
                                                    $warnaText =
                                                        $persentaseHemat >= 50
                                                            ? 'text-red-600'
                                                            : ($persentaseHemat >= 25
                                                                ? 'text-orange-600'
                                                                : 'text-green-600');
                                                @endphp
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                        Rp{{ number_format($hargaDiskon, 0, ',', '.') }}
                                                    </span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ $warnaBadge }} {{ $warnaBadgeText }}">
                                                        -{{ $produk->diskon }}%
                                                    </span>
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 line-through">
                                                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                                </div>
                                                <div class="text-xs {{ $warnaText }} font-medium">
                                                    Hemat Rp{{ number_format($potongan, 0, ',', '.') }}
                                                </div>
                                            @else
                                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    Tanpa diskon
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Foto -->
                                    <td class="px-6 py-4">
                                        @if ($produk->fotos->isNotEmpty())
                                            <div class="flex -space-x-2">
                                                @foreach ($produk->fotos->take(3) as $index => $foto)
                                                    <img src="{{ asset('storage/' . $foto->foto) }}"
                                                        class="w-10 h-10 rounded-lg border-2 border-white dark:border-gray-800 object-cover shadow-sm hover:z-10 hover:scale-110 transition-transform duration-200"
                                                        alt="Foto {{ $index + 1 }}" title="{{ $produk->nama_produk }}">
                                                @endforeach
                                                @if ($produk->fotos->count() > 3)
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-primary-500 border-2 border-white dark:border-gray-800 flex items-center justify-center text-xs font-medium text-white shadow-sm">
                                                        +{{ $produk->fotos->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                <i class="fa-solid fa-image mr-1"></i>
                                                Tidak ada foto
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end space-x-2">
                                            <!-- Tombol Aksi Utama -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open"
                                                    class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                                    Aksi
                                                    <i class="fa-solid fa-chevron-down ml-1 text-xs"></i>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div x-show="open" @click.away="open = false"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-10">
                                                    <div class="py-1" role="menu">
                                                        <a href="{{ route('admin.produk.show', $produk->id) }}"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150"
                                                            role="menuitem">
                                                            <i data-lucide="eye" class="w-5 h-5 mr-2 text-blue-500"></i>
                                                            Lihat Detail
                                                        </a>
                                                        <a href="{{ route('admin.produk.edit', $produk->id) }}"
                                                            class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150"
                                                            role="menuitem">
                                                            <i data-lucide="square-pen"
                                                                class="w-5 h-5 mr-2 text-blue-500"></i>
                                                            Edit Produk
                                                        </a>
                                                        <button
                                                            onclick="openDiscountModal({{ $produk->id }}, {{ $produk->diskon ?? 0 }})"
                                                            class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150"
                                                            role="menuitem">
                                                            <i data-lucide="percent"
                                                                class="w-5 h-5 mr-2 text-purple-500"></i>
                                                            Beri Diskon
                                                        </button>
                                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Hapus produk ini beserta semua fotonya?')"
                                                            class="border-t border-gray-200 dark:border-gray-600">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-150"
                                                                role="menuitem">
                                                                <i data-lucide="trash-2" class="w-5 h-5 mr-2"></i>
                                                                Hapus Produk
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                                <i class="fa-solid fa-box-open text-gray-400 text-xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                                Belum ada produk
                                            </h3>
                                            <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">
                                                Mulai dengan menambahkan produk pertama Anda untuk mengelola inventory toko.
                                            </p>
                                            <a href="{{ route('admin.produk.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200">
                                                <i class="fa-solid fa-plus mr-2"></i>
                                                Tambah Produk Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Tabel (Pagination) -->
                @if ($produks->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Menampilkan {{ $produks->count() }} dari {{ $produks->total() }} produk
                            </div>
                            <div class="flex space-x-2">
                                @if ($produks->onFirstPage())
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-white dark:bg-gray-700 cursor-not-allowed">
                                        Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $produks->previousPageUrl() }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                        Sebelumnya
                                    </a>
                                @endif

                                @if ($produks->hasMorePages())
                                    <a href="{{ $produks->nextPageUrl() }}"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-500 hover:bg-primary-600 transition-colors duration-200">
                                        Selanjutnya
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-primary-300 dark:bg-primary-800 cursor-not-allowed">
                                        Selanjutnya
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- MODAL TAMBAH & EDIT -->
    <div id="modalKategori"
        class="modal-kategori fixed inset-0 bg-black/60 backdrop-blur-sm hidden flex justify-center items-center z-50 transition-all duration-300">
        <div
            class="modal-content bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 id="modalKategoriTitle" class="text-xl font-bold text-gray-800 dark:text-white">Tambah
                    Kategori</h3>
                <button id="closeModalKategori"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-xl transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="formKategori" enctype="multipart/form-data" class="p-6 space-y-4 overflow-y-auto custom-scrollbar">
                @csrf
                <input type="hidden" id="kategori_id" name="kategori_id">

                <div>
                    <label class="font-semibold text-gray-700 dark:text-gray-300 block mb-2">Nama
                        Kategori</label>
                    <input type="text" id="nama_kategori" name="nama_kategori"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        placeholder="Masukkan nama kategori" required>
                </div>

                <div>
                    <label class="font-semibold text-gray-700 dark:text-gray-300 block mb-2">Foto Sampul</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="foto_sampul"
                            class="flex flex-col items-center justify-center w-full h-38 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                            <img id="previewImage" class="hidden w-48 h-full object-cover rounded-lg" />
                            <div id="uploadPlaceholder" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik
                                        untuk upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG (MAX. 5MB)
                                </p>
                            </div>
                            <input id="foto_sampul" name="foto_sampul" type="file" class="hidden" />
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" id="cancelKategori"
                        class="flex-1 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg py-3 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">Batal</button>
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg py-3 font-medium hover:from-blue-600 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DAFTAR KATEGORI -->
    <div id="modalDaftarKategori"
        class="modal-daftar fixed inset-0 bg-black/50 hidden flex items-center justify-center z-[9999] backdrop-blur-sm transition-all duration-300">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 w-11/12 max-w-4xl relative transform transition-all duration-300 scale-95">
            <button id="closeModalDaftarKategori"
                class="absolute top-4 right-4 text-gray-600 hover:text-black dark:text-gray-400 dark:hover:text-white text-2xl transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Daftar Kategori</h2>
                <p class="text-gray-600 dark:text-gray-400">Kelola kategori yang tersedia di sistem</p>
            </div>

            <div id="kategoriList"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                @foreach (\App\Models\Kategori::all() as $kategori)
                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group"
                        data-id="{{ $kategori->id }}" data-nama="{{ $kategori->nama_kategori }}">

                        <div class="relative overflow-hidden">
                            <img src="{{ $kategori->foto_sampul ? asset('storage/' . $kategori->foto_sampul) : 'https://via.placeholder.com/400x200?text=' . $kategori->nama_kategori }}"
                                class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-4 flex justify-between items-center">
                            <h3 class="font-semibold text-gray-800 dark:text-white">{{ $kategori->nama_kategori }}
                            </h3>

                            <div class="flex gap-2 transition-opacity duration-300">
                                <button
                                    class="editKategoriBtn bg-blue-500 text-white text-sm px-3 py-2 rounded-lg hover:bg-gray-500 shadow-sm hover:shadow-md transition-all duration-200">Edit</button>
                                <button
                                    class="hapusKategoriBtn bg-red-600 text-white text-sm px-3 py-2 rounded-lg hover:bg-gray-500 shadow-sm hover:shadow-md transition-all duration-200">Hapus</button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </div>


    <!-- Modal Diskon -->
    <div id="discountModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6 transform transition-all duration-300 scale-95"
            x-data="{ diskon: 0 }" x-init="$watch('diskon', value => {
                if (value > 100) diskon = 100;
                if (value < 0) diskon = 0;
            })">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fa-solid fa-percent text-purple-500 mr-2"></i>
                    Beri Diskon Produk
                </h3>
                <button onclick="closeDiscountModal()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                    <i class="fa-solid fa-times text-xl"></i>
                </button>
            </div>

            <form id="discountForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="produk_id" id="discountProdukId">

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Persentase Diskon (%)
                    </label>
                    <div class="relative">
                        <input type="number" name="diskon" id="discountPercent" min="0" max="100"
                            x-model="diskon"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors duration-200"
                            placeholder="Masukkan persentase diskon (0-100)">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-500 dark:text-gray-400 mr-8">%</span>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Masukkan 0 untuk menghapus diskon
                    </div>
                </div>

                <!-- Preview Harga -->
                <div x-show="diskon > 0" x-transition class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview Harga:</h4>
                    <div class="space-y-1">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Harga Asli:</span>
                            <span class="text-gray-900 dark:text-white font-medium" id="originalPricePreview">-</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Diskon (<span x-text="diskon"></span>%):</span>
                            <span class="text-red-600 dark:text-red-400 font-medium" id="discountAmountPreview">-</span>
                        </div>
                        <div
                            class="flex justify-between text-sm font-semibold border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                            <span class="text-gray-700 dark:text-gray-300">Harga Setelah Diskon:</span>
                            <span class="text-green-600 dark:text-green-400" id="finalPricePreview">-</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDiscountModal()"
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Simpan Diskon
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Custom scrollbar untuk tabel */
        .table-scrollbar::-webkit-scrollbar {
            height: 8px;
        }

        .table-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark .table-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Inisialisasi Alpine.js untuk interaktivitas
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                open: false,
                toggle() {
                    this.open = !this.open;
                }
            }));
        });

        // Modal Diskon Functions
        function openDiscountModal(id, diskon = 0) {
            document.getElementById('discountProdukId').value = id;
            document.getElementById('discountPercent').value = diskon;

            // Trigger Alpine.js untuk update nilai
            if (typeof Alpine !== 'undefined') {
                const alpineComponent = document.querySelector('[x-data]').__x;
                if (alpineComponent) {
                    alpineComponent.$data.diskon = diskon;
                }
            }

            document.getElementById('discountModal').classList.remove('hidden');
            setTimeout(() => {
                document.querySelector('#discountModal > div').classList.remove('scale-95');
                document.querySelector('#discountModal > div').classList.add('scale-100');
            }, 10);

            document.getElementById('discountPercent').focus();
        }

        function closeDiscountModal() {
            document.querySelector('#discountModal > div').classList.remove('scale-100');
            document.querySelector('#discountModal > div').classList.add('scale-95');
            setTimeout(() => {
                document.getElementById('discountModal').classList.add('hidden');
            }, 300);
        }

        // PATCH via Fetch untuk diskon
        document.getElementById('discountForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('discountProdukId').value;
            const diskon = document.getElementById('discountPercent').value || 0;

            fetch(`/admin/produk/${id}/diskon`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        diskon
                    })
                })
                .then(async res => {
                    let data;
                    try {
                        data = await res.json();
                    } catch (err) {
                        data = null;
                    }

                    if (res.ok && data && data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Diskon produk berhasil diperbarui.',
                            showConfirmButton: false,
                            timer: 1500,
                            background: document.documentElement.classList.contains('dark') ?
                                '#1f2937' : '#ffffff',
                            color: document.documentElement.classList.contains('dark') ? '#ffffff' :
                                '#000000'
                        }).then(() => location.reload());
                    } else {
                        const msg = (data && data.message) ? data.message : 'Gagal memperbarui diskon.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: msg,
                            background: document.documentElement.classList.contains('dark') ?
                                '#1f2937' : '#ffffff',
                            color: document.documentElement.classList.contains('dark') ? '#ffffff' :
                                '#000000'
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Jaringan',
                        text: 'Terjadi kesalahan jaringan. Coba lagi nanti.',
                        background: document.documentElement.classList.contains('dark') ? '#1f2937' :
                            '#ffffff',
                        color: document.documentElement.classList.contains('dark') ? '#ffffff' :
                            '#000000'
                    });
                });
        });

        // Tutup modal bila klik di luar
        document.getElementById('discountModal').addEventListener('click', function(e) {
            if (e.target === this) closeDiscountModal();
        });

        // Animasi untuk elemen yang baru dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
            elements.forEach((el, index) => {
                el.classList.add('fade-in');
                el.style.animationDelay = `${index * 0.1}s`;
            });

            // Tambahkan class untuk custom scrollbar
            const tableContainer = document.querySelector('.overflow-x-auto');
            if (tableContainer) {
                tableContainer.classList.add('table-scrollbar');
            }
        });

        // Add fade-in animation
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
            elements.forEach((el, index) => {
                el.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => {
                    el.classList.add('transition-all', 'duration-500');
                    el.classList.remove('opacity-0', 'translate-y-4');
                }, index * 100);
            });
        });
    </script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const modalKategori = document.getElementById('modalKategori');
            const modalDaftar = document.getElementById('modalDaftarKategori');

            const btnTambah = document.getElementById('btnTambahKategori');
            const btnDaftar = document.getElementById('btnDaftarKategori');
            const closeModalKategori = document.getElementById('closeModalKategori');
            const closeModalDaftar = document.getElementById('closeModalDaftarKategori');
            const cancelKategori = document.getElementById('cancelKategori');

            const formKategori = document.getElementById('formKategori');
            const modalTitle = document.getElementById('modalKategoriTitle');

            const kategoriIdInput = document.getElementById('kategori_id');
            const namaInput = document.getElementById('nama_kategori');
            const kategoriList = document.getElementById('kategoriList');

            const storeUrl = "{{ route('admin.kategori.store-ajax') }}";
            const baseKategoriUrl = "{{ url('admin/kategori') }}";

            // =========================
            // OPEN ADD MODAL
            // =========================
            btnTambah.addEventListener('click', () => {
                modalTitle.textContent = "Tambah Kategori";
                formKategori.reset();
                kategoriIdInput.value = "";
                modalKategori.classList.remove('hidden');
            });

            // =========================
            // OPEN LIST MODAL
            // =========================
            btnDaftar.addEventListener('click', () => {
                modalDaftar.classList.remove('hidden');
            });

            // =========================
            // CLOSE MODALS
            // =========================
            closeModalKategori.addEventListener('click', () => modalKategori.classList.add('hidden'));
            cancelKategori.addEventListener('click', () => modalKategori.classList.add('hidden'));
            closeModalDaftar.addEventListener('click', () => modalDaftar.classList.add('hidden'));

            // =========================
            // EDIT / DELETE BUTTONS
            // =========================
            kategoriList.addEventListener('click', e => {

                // EDIT KATEGORI
                if (e.target.classList.contains('editKategoriBtn')) {
                    const card = e.target.closest('[data-id]');
                    modalTitle.textContent = "Edit Kategori";

                    kategoriIdInput.value = card.dataset.id;
                    namaInput.value = card.dataset.nama;

                    modalDaftar.classList.add('hidden');
                    modalKategori.classList.remove('hidden');
                }

                // DELETE KATEGORI
                if (e.target.classList.contains('hapusKategoriBtn')) {
                    const card = e.target.closest('[data-id]');
                    const id = card.dataset.id;

                    if (!confirm("Yakin ingin menghapus kategori?")) return;

                    fetch(`${baseKategoriUrl}/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === "success") {
                                card.remove();
                            }
                        });
                }
            });

            // =========================
            // SUBMIT FORM (ADD / EDIT)
            // =========================
            formKategori.addEventListener('submit', e => {
                e.preventDefault();

                const id = kategoriIdInput.value;
                const url = id ? `${baseKategoriUrl}/${id}/update-ajax` : storeUrl;

                const formData = new FormData(formKategori);

                fetch(url, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (data.status !== "success") return alert("Gagal menyimpan!");

                        const k = data.kategori;

                        // =============== UPDATE UI (EDIT) ===============
                        if (id) {
                            const card = kategoriList.querySelector(`[data-id="${id}"]`);
                            card.dataset.nama = k.nama_kategori;
                            card.querySelector("h3").textContent = k.nama_kategori;

                            if (k.foto_sampul) {
                                card.querySelector("img").src = "/storage/" + k.foto_sampul;
                            }
                        }
                        // =============== TAMBAH KATEGORI BARU ===============
                        else {
                            const item = document.createElement('div');
                            item.className =
                                "bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group";
                            item.dataset.id = k.id;
                            item.dataset.nama = k.nama_kategori;

                            item.innerHTML = `
                    <div class="relative overflow-hidden">
                        <img src="${k.foto_sampul ? '/storage/' + k.foto_sampul : 'https://via.placeholder.com/400x200?text=' + k.nama_kategori}"
                            class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800 dark:text-white">${k.nama_kategori}</h3>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="editKategoriBtn bg-blue-500 text-white text-sm px-3 py-2 rounded-lg">Edit</button>
                            <button class="hapusKategoriBtn bg-red-500 text-white text-sm px-3 py-2 rounded-lg">Hapus</button>
                        </div>
                    </div>
                `;
                            kategoriList.prepend(item);
                        }

                        modalKategori.classList.add('hidden');
                        formKategori.reset();
                        kategoriIdInput.value = "";
                    });
            });

            // =========================
            // PREVIEW GAMBAR SAMPUL
            // =========================
            const fileInput = document.getElementById('foto_sampul');
            const previewImage = document.getElementById('previewImage');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        uploadPlaceholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.src = "";
                    previewImage.classList.add('hidden');
                    uploadPlaceholder.classList.remove('hidden');
                }
            });

        });
    </script>
@endpush
