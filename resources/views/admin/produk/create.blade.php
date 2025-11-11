@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="shrink-0 h-12 w-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-plus text-white text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Tambah Produk Baru
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Isi informasi produk baru untuk ditambahkan ke katalog
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
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 sm:p-8">
                    @csrf

                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
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
                                    <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                        placeholder="Masukkan nama produk" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fa-solid fa-tag text-gray-400"></i>
                                    </div>
                                </div>
                                @error('nama_produk')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-1 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
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
                                            <span class="text-gray-500 dark:text-gray-400">IDR</span>
                                        </div>
                                        <input type="number" name="harga" id="harga" value="{{ old('harga') }}"
                                            class="w-full pl-14 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                            placeholder="0" required>
                                    </div>
                                    @error('harga')
                                        <p class="text-sm text-red-500 dark:text-red-400 mt-1 flex items-center">
                                            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Jumlah -->
                                <div>
                                    <label for="jumlah"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Stok <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                                            placeholder="Jumlah stok" required>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fa-solid fa-boxes-stacked text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('jumlah')
                                        <p class="text-sm text-red-500 dark:text-red-400 mt-1 flex items-center">
                                            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis -->
                            <div class="mt-6">
                                <label for="jenis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="jenis" id="jenis"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 appearance-none"
                                        required>
                                        <option value="">Pilih Kategori Produk</option>
                                        <option value="T-Shirt" {{ old('jenis') == 'T-Shirt' ? 'selected' : '' }}>T-Shirt
                                        </option>
                                        <option value="Hoodie" {{ old('jenis') == 'Hoodie' ? 'selected' : '' }}>Hoodie
                                        </option>
                                        <option value="Jersey" {{ old('jenis') == 'Jersey' ? 'selected' : '' }}>Jersey
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fa-solid fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('jenis')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-1 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
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
                                    $oldWarna = collect(old('warna', []));
                                @endphp

                                <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-4">
                                    @foreach ($warnaOptions as $warna => $warnaClass)
                                        <label class="flex flex-col items-center cursor-pointer group">
                                            <input type="checkbox" name="warna[]" value="{{ $warna }}"
                                                class="sr-only peer warna-checkbox" {{ $oldWarna->contains($warna) ? 'checked' : '' }}>

                                            <span class="w-10 h-10 rounded-full border-2 border-gray-300 dark:border-gray-600
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

                                @error('warna')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-3 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Ukuran -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
                                    Pilih Ukuran <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                                    @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $uk)
                                        <label class="cursor-pointer">
                                            <input type="checkbox" name="ukuran[]" value="{{ $uk }}" class="sr-only peer" {{ collect(old('ukuran'))->contains($uk) ? 'checked' : '' }}>

                                            <span class="inline-flex items-center justify-center w-full py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600
                                                                     text-gray-700 dark:text-gray-300 font-medium text-sm transition-all duration-200
                                                                     peer-checked:bg-primary-500 peer-checked:text-white peer-checked:border-primary-500
                                                                     hover:border-primary-400 hover:bg-primary-50 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white
                                                                     bg-white dark:bg-gray-700">
                                                {{ $uk }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('ukuran')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-3 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Upload Foto -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 transition-colors duration-200">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-images text-primary-500 mr-2"></i>
                                Foto Produk
                            </h3>

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

                            <!-- Error Message -->
                            <p id="file-error" class="text-sm text-red-500 dark:text-red-400 mt-2 hidden"></p>

                            <!-- Preview Container -->
                            <div id="preview-container" class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4"></div>

                            @error('foto')
                                <p class="text-sm text-red-500 dark:text-red-400 mt-2 flex items-center">
                                    <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                </p>
                            @enderror
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
                                    required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <p class="text-sm text-red-500 dark:text-red-400 mt-1 flex items-center">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-check mr-2"></i>
                                Simpan Produk
                            </button>
                            <a href="{{ route('admin.produk.index') }}"
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-times mr-2"></i>
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // === Upload Foto Functionality ===
            const inputFoto = document.getElementById("foto");
            const uploadArea = document.getElementById("upload-area");
            const previewContainer = document.getElementById("preview-container");
            const uploadPlaceholder = document.getElementById("upload-placeholder");
            const browseBtn = document.getElementById("browse-btn");
            const fileError = document.getElementById("file-error");

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
                fileError.classList.add('hidden');
                let validFiles = [];

                Array.from(files).forEach(file => {
                    if (file.size / 1024 / 1024 > MAX_SIZE_MB) {
                        fileError.textContent = `File "${file.name}" melebihi ${MAX_SIZE_MB}MB!`;
                        fileError.classList.remove('hidden');
                    } else if (filesArray.length + validFiles.length >= MAX_FILES) {
                        fileError.textContent = `Maksimal ${MAX_FILES} gambar yang diizinkan!`;
                        fileError.classList.remove('hidden');
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

            // Delete image
            previewContainer.addEventListener('click', (e) => {
                const deleteBtn = e.target.closest('.delete-btn');
                if (!deleteBtn) return;

                const index = parseInt(deleteBtn.dataset.index);
                filesArray.splice(index, 1);
                updatePreview();
            });

            // === Warna Other Functionality ===
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
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fadeIn 0.3s ease-out;
            }

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
@endpush