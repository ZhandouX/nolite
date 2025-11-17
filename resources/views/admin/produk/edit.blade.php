@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-screen mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="shrink-0 h-12 w-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-edit text-white text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Edit Produk
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Perbarui informasi produk <span class="text-gray-700 dark:text-gray-300 font-bold bg-primary-500/20 rounded-lg px-3 py-1">{{ old('nama_produk', $produk->nama_produk) }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Error Global -->
            @if ($errors->any())
                <div
                    class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-400">
                                Oops! Ada beberapa masalah dengan input Anda:
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <ul class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Container -->
            <div
                class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 transition-all duration-300 overflow-hidden">
                <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <!-- Kolom Kiri -->
                    <div class="space-y-8">
                        <!-- Informasi Dasar -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 transition-colors duration-200">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-info-circle text-primary-500 mr-2"></i>
                                Informasi Dasar Produk
                            </h3>

                            <!-- Nama Produk -->
                            <div class="mb-6">
                                <label for="nama_produk"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="nama_produk" id="nama_produk"
                                        value="{{ old('nama_produk', $produk->nama_produk) }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                        placeholder="Masukkan nama produk" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fa-solid fa-tag text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Harga & Jumlah -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Harga -->
                                <div>
                                    <label for="harga"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Harga <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                        </div>
                                        <input type="number" name="harga" id="harga"
                                            value="{{ old('harga', $produk->harga) }}"
                                            class="w-full pl-14 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                            placeholder="0" required>
                                    </div>
                                </div>

                                <!-- Jumlah -->
                                <div>
                                    <label for="jumlah"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Stok <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="jumlah" id="jumlah"
                                            value="{{ old('jumlah', $produk->jumlah) }}"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                            placeholder="Jumlah stok" required>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fa-solid fa-boxes-stacked text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="mt-6">
                                <label for="kategori_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="relative flex items-center gap-2 mb-3">
                                    @php
                                        $kategoris = \App\Models\Kategori::all();
                                    @endphp

                                    {{-- Custom dropdown (Alpine.js) --}}
                                    <div x-data="kategoriDropdown()" x-init="init()" x-cloak class="relative w-full">
                                        {{-- Hidden input yang dikirim ke server --}}
                                        <input type="hidden" name="kategori_id" :value="selectedId">

                                        {{-- Tombol utama --}}
                                        <button type="button" @click="open = !open" @keydown.escape="open = false"
                                            aria-haspopup="listbox" :aria-expanded="open.toString()"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200">
                                            <span x-text="selectedText"></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 ml-3"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>

                                        {{-- Panel dropdown --}}
                                        <div x-show="open" x-transition.opacity @click.outside="open = false"
                                            class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-700 rounded-xl shadow-lg max-h-56 overflow-auto border border-gray-200 dark:border-gray-600"
                                            style="display: none;" role="listbox" :aria-activedescendant="activeDescendant">
                                            {{-- Optional: search input inside dropdown --}}
                                            <div class="px-3 py-2">
                                                <input type="text" x-model="query" placeholder="Cari kategori..."
                                                    class="w-full px-3 py-2 text-gray-700 dark:text-gray-200 rounded-md border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 text-sm focus:outline-none focus:ring-1 focus:ring-primary-500">
                                            </div>

                                            {{-- List items --}}
                                            <ul class="divide-y divide-gray-100 dark:divide-gray-600" tabindex="-1">
                                                @foreach($kategoris as $kategori)
                                                    <li x-show="filterMatch('{{ addslashes($kategori->nama_kategori) }}')"
                                                        x-on:click.prevent="select('{{ $kategori->id }}', '{{ addslashes($kategori->nama_kategori) }}')"
                                                        @mouseenter="setActive('{{ $kategori->id }}')"
                                                        @mouseleave="setActive(null)" :id="'item-{{ $kategori->id }}'"
                                                        class="px-4 py-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-900 dark:text-white"
                                                        role="option" aria-selected="false">
                                                        {{ $kategori->nama_kategori }}
                                                    </li>
                                                @endforeach

                                                {{-- jika tidak ada yang cocok --}}
                                                <li x-show="filteredCount === 0"
                                                    class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300">
                                                    Tidak ada kategori ditemukan.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                @error('kategori_id')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-1 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
                                <div class="flex gap-3">
                                    <button type="button" id="btnTambahKategori"
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                        <i class="fa-solid fa-plus text-sm"></i>
                                        <span class="text-sm font-semibold">Tambah Kategori</span>
                                    </button>

                                    <button type="button" id="btnDaftarKategori"
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-500 hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                        <i class="fa-solid fa-list text-sm"></i>
                                        <span class="text-sm font-semibold">Daftar Kategori</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Variasi Produk -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 transition-colors duration-200">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-palette text-primary-500 mr-2"></i>
                                Variasi Produk
                            </h3>

                            <!-- Warna -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                                    Pilih Warna <span class="text-red-500">*</span>
                                </label>

                                @php
                                    $warnaOptions = [
                                        'Putih' => 'bg-white border-gray-300',
                                        'Hitam' => 'bg-black border-gray-700',
                                        'Abu-abu' => 'bg-gray-400 border-gray-400',
                                        'Merah' => 'bg-red-600 border-red-600',
                                        'Biru' => 'bg-blue-600 border-blue-600',
                                        'Hijau' => 'bg-green-600 border-green-600',
                                        'Kuning' => 'bg-yellow-400 border-yellow-400',
                                        'Orange' => 'bg-orange-500 border-orange-500',
                                        'Coklat' => 'bg-yellow-800 border-yellow-800',
                                        'Ungu' => 'bg-purple-600 border-purple-600',
                                        'Pink' => 'bg-pink-500 border-pink-500',
                                        'Beige' => 'bg-yellow-200 border-yellow-200',
                                        'Maroon' => 'bg-red-800 border-red-800',
                                        'Navy' => 'bg-blue-800 border-blue-800',
                                        'Olive' => 'bg-green-800 border-green-800',
                                        'Turquoise' => 'bg-teal-400 border-teal-400',
                                        'Lavender' => 'bg-purple-300 border-purple-300',
                                        'Coral' => 'bg-pink-300 border-pink-300',
                                        'Mint' => 'bg-green-200 border-green-200',
                                        'Other' => 'bg-gradient-to-r from-gray-100 to-gray-200 border-gray-300'
                                    ];
                                    $oldWarna = collect(old('warna', is_array($produk->warna) ? $produk->warna : [$produk->warna]));
                                @endphp

                                <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-4">
                                    @foreach ($warnaOptions as $warna => $warnaClass)
                                        <label class="flex flex-col items-center cursor-pointer group">
                                            <input type="checkbox" name="warna[]" value="{{ $warna }}"
                                                class="sr-only peer warna-checkbox" {{ $oldWarna->contains($warna) ? 'checked' : '' }}>

                                            <span
                                                class="w-10 h-10 rounded-full border-2 border-gray-300 dark:border-gray-600
                                                                                                                                             transition-all duration-200 peer-checked:scale-110 peer-checked:border-primary-500 peer-checked:ring-2 peer-checked:ring-primary-200
                                                                                                                                             hover:scale-105 hover:shadow-md flex items-center justify-center shadow-sm
                                                                                                                                             {{ $warnaClass }}">
                                                @if($warna === 'Other')
                                                    <span class="text-xs text-gray-700 font-bold">+</span>
                                                @endif
                                            </span>

                                            <span
                                                class="mt-2 text-xs text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white text-center font-medium transition-colors duration-200">
                                                {{ $warna }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>

                                <!-- Input Warna Lain -->
                                <div id="warna-lain-wrapper"
                                    class="mt-4 {{ $oldWarna->contains('Other') ? '' : 'hidden' }}">
                                    <label for="warna-lain"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Warna Lainnya
                                    </label>
                                    <input type="text" name="warna_lain" id="warna-lain" value="{{ old('warna_lain') }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                        placeholder="Masukkan warna khusus lainnya">
                                </div>
                            </div>

                            <!-- Ukuran -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                                    Pilih Ukuran <span class="text-red-500">*</span>
                                </label>
                                @php
                                    $selectedUkuran = collect(old('ukuran', is_array($produk->ukuran) ? $produk->ukuran : [$produk->ukuran]));
                                @endphp
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $uk)
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="ukuran[]" value="{{ $uk }}" class="sr-only peer" {{ $selectedUkuran->contains($uk) ? 'checked' : '' }}>

                                            <span
                                                class="inline-flex items-center justify-center w-full py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600
                                                                                                                                             text-gray-700 dark:text-gray-300 font-medium text-sm transition-all duration-200
                                                                                                                                             peer-checked:bg-primary-500 peer-checked:text-white peer-checked:border-primary-500
                                                                                                                                             hover:border-primary-400 hover:bg-primary-50 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white
                                                                                                                                             bg-white dark:bg-gray-700">
                                                {{ $uk }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-8">
                        <!-- Foto Produk -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 transition-colors duration-200">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-images text-primary-500 mr-2"></i>
                                Foto Produk
                            </h3>

                            <!-- Foto Lama -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Foto Saat Ini
                                </label>
                                @if($produk->fotos->isNotEmpty())
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                        @foreach($produk->fotos as $foto)
                                            <div class="relative group">
                                                <div
                                                    class="aspect-square rounded-xl overflow-hidden border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700">
                                                    <img src="{{ asset('storage/' . $foto->foto) }}"
                                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                        alt="Foto Produk">
                                                </div>
                                                <button type="button"
                                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs delete-old-foto shadow-lg transition-colors duration-200"
                                                    data-id="{{ $foto->id }}" title="Hapus foto">
                                                    <i class="fa-solid fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="text-center py-6 bg-white dark:bg-gray-700 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                        <i class="fa-solid fa-image text-gray-400 text-2xl mb-2"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Upload Foto Baru -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    Tambah Foto Baru
                                </label>

                                <!-- Upload Area -->
                                <div id="upload-area"
                                    class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center cursor-pointer transition-all duration-300 hover:border-primary-500 hover:bg-primary-50/20 dark:hover:bg-primary-900/10 bg-white dark:bg-gray-700">
                                    <input type="file" name="foto[]" id="foto" class="hidden" multiple accept="image/*">
                                    <div id="upload-placeholder" class="space-y-4">
                                        <div class="flex justify-center">
                                            <div
                                                class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center">
                                                <i
                                                    class="fa-solid fa-cloud-arrow-up text-primary-600 dark:text-primary-400 text-2xl"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Klik atau seret gambar ke sini
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                                Format: PNG, JPG, JPEG (maksimal 5MB per gambar)
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Maksimal 5 gambar
                                            </p>
                                        </div>
                                        <button type="button" id="browse-btn"
                                            class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                            <i class="fa-solid fa-folder-open mr-2"></i>
                                            Pilih File
                                        </button>
                                    </div>
                                </div>

                                <!-- Preview Container -->
                                <div id="preview-container" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4"></div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 transition-colors duration-200">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-align-left text-primary-500 mr-2"></i>
                                Deskripsi Produk
                            </h3>

                            <div>
                                <label for="deskripsi"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="deskripsi" id="deskripsi" rows="8"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 resize-none"
                                    placeholder="Jelaskan detail produk, bahan, keunggulan, dan informasi lainnya..."
                                    required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-save mr-2"></i>
                                Update Produk
                            </button>
                            <a href="{{ route('admin.produk.index') }}"
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-times mr-2"></i>
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
                <!-- MODAL TAMBAH & EDIT -->
                <div id="modalKategori"
                    class="modal-kategori fixed inset-0 bg-black/60 backdrop-blur-sm hidden flex justify-center items-center z-50 transition-all duration-300">
                    <div
                        class="modal-content bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 id="modalKategoriTitle" class="text-xl font-bold text-gray-800 dark:text-white">Tambah
                                Kategori</h3>
                            <button id="closeModalKategori"
                                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-xl transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form id="formKategori" enctype="multipart/form-data"
                            class="p-6 space-y-4 overflow-y-auto custom-scrollbar">
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
                                        <div id="uploadPlaceholder"
                                            class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-semibold">Klik untuk upload</span></p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Daftar Kategori</h2>
                            <p class="text-gray-600 dark:text-gray-400">Kelola kategori yang tersedia di sistem</p>
                        </div>

                        <div id="kategoriList"
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[70vh] overflow-y-auto custom-scrollbar">
                            @foreach(\App\Models\Kategori::all() as $kategori)
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
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Modal Animation */
        .modal-kategori.show .modal-content,
        .modal-daftar.show .modal-content {
            transform: scale(1);
        }

        /* Input File Styling */
        #foto_sampul+label {
            transition: all 0.3s ease;
        }

        #foto_sampul:focus+label {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // === Toggle Warna Lain ===
            const otherCheckbox = document.querySelector('input.warna-checkbox[value="Other"]');
            const warnaLainWrapper = document.getElementById('warna-lain-wrapper');
            const warnaLainInput = document.getElementById('warna-lain');

            if (otherCheckbox) {
                otherCheckbox.addEventListener('change', () => {
                    if (otherCheckbox.checked) {
                        warnaLainWrapper.classList.remove('hidden');
                        setTimeout(() => {
                            warnaLainInput.focus();
                        }, 100);
                    } else {
                        warnaLainWrapper.classList.add('hidden');
                        warnaLainInput.value = '';
                    }
                });
            }

            // === Upload Foto Functionality ===
            const inputFoto = document.getElementById("foto");
            const uploadArea = document.getElementById("upload-area");
            const previewContainer = document.getElementById("preview-container");
            const uploadPlaceholder = document.getElementById("upload-placeholder");
            const browseBtn = document.getElementById("browse-btn");

            let filesArray = [];
            const MAX_FILES = 5;
            const MAX_SIZE_MB = 5;

            // Click to browse
            uploadArea.addEventListener("click", (e) => {
                if (e.target !== browseBtn && !e.target.closest('.delete-btn')) {
                    inputFoto.click();
                }
            });

            browseBtn.addEventListener("click", (e) => {
                e.stopPropagation();
                inputFoto.click();
            });

            // Drag & Drop events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, e => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, () => {
                    uploadArea.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, () => {
                    uploadArea.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
                });
            });

            uploadArea.addEventListener('drop', (e) => handleFiles(e.dataTransfer.files));
            inputFoto.addEventListener("change", (e) => handleFiles(e.target.files));

            function handleFiles(files) {
                let validFiles = [];

                Array.from(files).forEach(file => {
                    if (file.size / 1024 / 1024 > MAX_SIZE_MB) {
                        showNotification(`File "${file.name}" melebihi ${MAX_SIZE_MB}MB!`, 'error');
                    } else if (filesArray.length + validFiles.length >= MAX_FILES) {
                        showNotification(`Maksimal ${MAX_FILES} gambar yang diizinkan!`, 'error');
                    } else {
                        validFiles.push(file);
                    }
                });

                filesArray = [...filesArray, ...validFiles].slice(0, MAX_FILES);
                updatePreview();
            }

            function updatePreview() {
                previewContainer.innerHTML = "";
                uploadPlaceholder.classList.toggle('hidden', filesArray.length > 0);

                filesArray.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const wrapper = document.createElement("div");
                        wrapper.className = "relative group animate-fade-in";
                        wrapper.innerHTML = `
                                                                <div class="relative aspect-square rounded-xl overflow-hidden border-2 border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-300 bg-white dark:bg-gray-700">
                                                                    <img src="${e.target.result}" 
                                                                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" 
                                                                         alt="Preview ${index + 1}"
                                                                         loading="lazy">
                                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center">
                                                                        <button type="button" 
                                                                                data-index="${index}" 
                                                                                class="delete-btn opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition-all duration-300 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg">
                                                                            <i class="fa-solid fa-trash text-sm"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="absolute top-2 left-2 bg-primary-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                                                                        ${index + 1}
                                                                    </div>
                                                                </div>
                                                            `;
                        previewContainer.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });

                // Update file input
                const dataTransfer = new DataTransfer();
                filesArray.forEach(f => dataTransfer.items.add(f));
                inputFoto.files = dataTransfer.files;
            }

            // Delete new image
            previewContainer.addEventListener('click', (e) => {
                const deleteBtn = e.target.closest('.delete-btn');
                if (!deleteBtn) return;

                const index = parseInt(deleteBtn.dataset.index);
                filesArray.splice(index, 1);
                updatePreview();
            });

            // === Delete Foto Lama ===
            document.querySelectorAll('.delete-old-foto').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;

                    if (!confirm('Yakin ingin menghapus foto ini?')) return;

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

                    try {
                        const response = await fetch(`/admin/produk/foto/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        });

                        if (response.ok) {
                            // Remove the image container with animation
                            const container = btn.closest('.relative.group');
                            container.classList.add('opacity-0', 'scale-95', 'transition-all', 'duration-300');
                            setTimeout(() => {
                                container.remove();
                                showNotification('Foto berhasil dihapus', 'success');
                            }, 300);
                        } else {
                            throw new Error('Gagal menghapus foto');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan saat menghapus foto', 'error');
                        btn.innerHTML = '<i class="fa-solid fa-times"></i>';
                    } finally {
                        btn.disabled = false;
                    }
                });
            });

            // Notification Function
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${type === 'error' ? 'bg-red-500 text-white' :
                    type === 'success' ? 'bg-green-500 text-white' :
                        'bg-blue-500 text-white'
                    }`;
                notification.innerHTML = `
                                                        <div class="flex items-center">
                                                            <i class="fa-solid ${type === 'error' ? 'fa-exclamation-circle' :
                        type === 'success' ? 'fa-check-circle' :
                            'fa-info-circle'
                    } mr-2"></i>
                                                            <span>${message}</span>
                                                        </div>
                                                    `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('opacity-0', 'translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            // Auto-hide error messages after 5 seconds
            setTimeout(() => {
                const errorMessages = document.querySelectorAll('.text-red-500, .text-red-400');
                errorMessages.forEach(error => {
                    if (error.textContent.includes('Oops!')) {
                        error.closest('.bg-red-50')?.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                        setTimeout(() => {
                            error.closest('.bg-red-50')?.remove();
                        }, 500);
                    }
                });
            }, 5000);
        });

        // Animasi CSS
        const style = document.createElement('style');
        style.textContent = `
                                                /* Custom scrollbar */
                                                textarea::-webkit-scrollbar {
                                                    width: 6px;
                                                }
                                                textarea::-webkit-scrollbar-track {
                                                    background: transparent;
                                                }
                                                textarea::-webkit-scrollbar-thumb {
                                                    background: #cbd5e1;
                                                    border-radius: 3px;
                                                }
                                                .dark textarea::-webkit-scrollbar-thumb {
                                                    background: #475569;
                                                }
                                            `;
        document.head.appendChild(style);
    </script>

    <script>
        // Add fade-in animation to elements
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
            elements.forEach((el, index) => {
                el.classList.add('fade-in');
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

    <!-- SCRIPT MODAL -->
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

                // EDIT
                if (e.target.classList.contains('editKategoriBtn')) {
                    const card = e.target.closest('[data-id]');
                    modalTitle.textContent = "Edit Kategori";

                    kategoriIdInput.value = card.dataset.id;
                    namaInput.value = card.dataset.nama;

                    modalDaftar.classList.add('hidden');
                    modalKategori.classList.remove('hidden');
                }

                // DELETE
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
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {

                        if (data.status !== "success") return alert("Gagal menyimpan!");

                        const k = data.kategori;

                        // UPDATE UI kalau edit
                        if (id) {
                            const card = kategoriList.querySelector(`[data-id="${id}"]`);
                            card.dataset.nama = k.nama_kategori;
                            card.querySelector("h3").textContent = k.nama_kategori;

                            if (k.foto_sampul) {
                                card.querySelector("img").src = "/storage/" + k.foto_sampul;
                            }

                        } else {
                            // Tambah baru ke DOM
                            const item = document.createElement('div');
                            item.className = "bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group";
                            item.dataset.id = k.id;
                            item.dataset.nama = k.nama_kategori;

                            item.innerHTML = `
                                                <div class="relative overflow-hidden">
                                                    <img src="${k.foto_sampul ? '/storage/' + k.foto_sampul : 'https://via.placeholder.com/400x200?text=' + k.nama_kategori}"
                                                        class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                </div>
                                                <div class="p-4 flex justify-between items-center">
                                                    <h3 class="font-semibold text-gray-800 dark:text-white">${k.nama_kategori}</h3>
                                                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                        <button class="editKategoriBtn bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-sm px-3 py-2 rounded-lg hover:from-blue-600 hover:to-indigo-600 shadow-sm hover:shadow-md transition-all duration-200">Edit</button>
                                                        <button class="hapusKategoriBtn bg-gradient-to-r from-red-500 to-pink-500 text-white text-sm px-3 py-2 rounded-lg hover:from-red-600 hover:to-pink-600 shadow-sm hover:shadow-md transition-all duration-200">Hapus</button>
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

            const fileInput = document.getElementById('foto_sampul');
            const previewImage = document.getElementById('previewImage');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');

            fileInput.addEventListener('change', function () {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
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

    {{-- Alpine component script (masukkan di bawah body atau di file JS yang dieksekusi) --}}
    <script>
        function kategoriDropdown() {
            return {
                open: false,
                query: '',
                selectedId: '{{ old('kategori_id', $produk->kategori_id ?? '') }}',
                // inisialisasi text awal (tampilkan nama kategori jika ada, atau placeholder)
                selectedText: {!! json_encode(optional($produk->kategori)->nama_kategori ?? 'Pilih Kategori Produk') !!},
                activeDescendant: null,
                filteredCount: 0,

                init() {
                    // hitung filteredCount awal
                    this.$nextTick(() => { this.updateFilteredCount(); });
                },

                // dipanggil saat user pilih item
                select(id, text) {
                    this.selectedId = id;
                    this.selectedText = text;
                    this.open = false;
                    this.query = '';
                    this.updateFilteredCount();
                },

                setActive(id) {
                    this.activeDescendant = id ? 'item-' + id : null;
                },

                // filter match untuk x-show: gunakan lowercase compare
                filterMatch(name) {
                    const q = this.query.trim().toLowerCase();
                    const matches = q === '' ? true : name.toLowerCase().includes(q);
                    // Update filteredCount lazily: but we can't loop Blade items here; so compute via DOM each time
                    // For performance, update count using DOM when dropdown open or query changes
                    if (this.open) this.$nextTick(() => this.updateFilteredCount());
                    return matches;
                },

                updateFilteredCount() {
                    // hitung jumlah elemen li yang currently visible
                    const panel = this.$root.querySelector('div[role="listbox"]');
                    if (!panel) {
                        this.filteredCount = 0;
                        return;
                    }
                    const lis = Array.from(panel.querySelectorAll('ul > li'));
                    // visible = not hidden by x-show -> elements with style display:none get filtered
                    this.filteredCount = lis.filter(li => {
                        // ignore the 'Tidak ada kategori' placeholder
                        if (li.textContent.trim() === 'Tidak ada kategori ditemukan.') return false;
                        return window.getComputedStyle(li).display !== 'none';
                    }).length;
                }
            }
        }
    </script>
@endpush