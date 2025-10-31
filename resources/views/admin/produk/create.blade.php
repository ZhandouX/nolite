@extends('layouts.admin_app')

@section('content')
<div class="max-w-6xl mx-auto p-4 sm:p-6">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 sm:mb-8 text-gray-800 border-b pb-3">Tambah Produk</h2>

    {{-- ERROR GLOBAL --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
            <strong>Oops!</strong> Ada beberapa masalah:
            <ul class="list-disc ml-6 mt-2 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 bg-white p-6 sm:p-8 rounded-2xl shadow-lg border border-gray-100">
        @csrf

        {{-- KOLOM KIRI --}}
        <div class="space-y-5 sm:space-y-6">
            {{-- NAMA PRODUK --}}
            <div>
                <label for="nama_produk" class="block text-sm font-semibold text-gray-700">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk"
                    class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10"
                    value="{{ old('nama_produk') }}" required>
                @error('nama_produk')
                    <p class="text-xs sm:text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- HARGA --}}
            <div>
                <label for="harga" class="block text-sm font-semibold text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga"
                    class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10"
                    value="{{ old('harga') }}" required>
                @error('harga')
                    <p class="text-xs sm:text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- JUMLAH --}}
            <div>
                <label for="jumlah" class="block text-sm font-semibold text-gray-700">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah"
                    class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10"
                    value="{{ old('jumlah') }}" required>
                @error('jumlah')
                    <p class="text-xs sm:text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- JENIS --}}
            <div>
                <label for="jenis" class="block text-sm font-semibold text-gray-700">Jenis</label>
                <select name="jenis" id="jenis"
                    class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10" required>
                    <option value="">Pilih Kategori Produk</option>
                    <option value="T-Shirt" {{ old('jenis') == 'T-Shirt' ? 'selected' : '' }}>T-Shirt</option>
                    <option value="Hoodie" {{ old('jenis') == 'Hoodie' ? 'selected' : '' }}>Hoodie</option>
                    <option value="Jersey" {{ old('jenis') == 'Jersey' ? 'selected' : '' }}>Jersey</option>
                </select>
                @error('jenis')
                    <p class="text-xs sm:text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- WARNA --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>

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
                        'Other' => 'bg-gray-100 border-gray-300'
                    ];
                    $oldWarna = collect(old('warna', []));
                @endphp

                <div class="grid grid-cols-5 sm:grid-cols-7 gap-3 mt-2">
                    @foreach ($warnaOptions as $warna => $warnaClass)
                        <label class="flex flex-col items-center cursor-pointer group">
                            <input type="checkbox" name="warna[]" value="{{ $warna }}" 
                                   class="sr-only peer warna-checkbox" {{ $oldWarna->contains($warna) ? 'checked' : '' }}>

                            <span class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border-2 border-gray-300
                                         transition-all duration-200 peer-checked:scale-110 peer-checked:border-blue-500
                                         hover:scale-105 hover:brightness-90 flex items-center justify-center
                                         {{ $warnaClass }}">
                                @if($warna === 'Other')
                                    <span class="text-xs text-gray-700">+</span>
                                @endif
                            </span>

                            <span class="mt-1 text-[10px] sm:text-xs text-gray-700 group-hover:text-gray-900 text-center">{{ $warna }}</span>
                        </label>
                    @endforeach
                </div>

                <div id="warna-lain-wrapper" class="mt-2 {{ $oldWarna->contains('Other') ? '' : 'hidden' }}">
                    <input type="text" name="warna_lain" id="warna-lain"
                           class="w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10 px-3"
                           placeholder="Masukkan warna lain (jika pilih Other)" value="{{ old('warna_lain') }}">
                </div>

                @error('warna')
                    <p class="text-xs sm:text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- UKURAN --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran</label>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 sm:gap-3">
                    @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $uk)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="ukuran[]" value="{{ $uk }}"
                                   class="sr-only peer" {{ collect(old('ukuran'))->contains($uk) ? 'checked' : '' }}>
                            
                            <span class="inline-flex items-center justify-center w-full py-2 sm:py-3 rounded-lg border-2 border-gray-300
                                         text-gray-700 font-medium text-sm sm:text-base transition-all duration-200
                                         peer-checked:bg-blue-600 peer-checked:text-white
                                         hover:border-blue-500 hover:bg-blue-100 hover:text-gray-900">
                                {{ $uk }}
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('ukuran')
                    <p class="text-xs sm:text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="space-y-5 sm:space-y-6">
            {{-- FOTO PRODUK --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Produk</label>
                <div id="upload-area" class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer transition-all duration-300 hover:border-blue-500 hover:bg-blue-50/50 bg-gradient-to-br from-gray-50 to-white">
                    <input type="file" name="foto[]" id="foto" class="hidden" multiple accept="image/*">
                    <div id="upload-placeholder" class="space-y-2 sm:space-y-3">
                        <div class="flex justify-center">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs sm:text-sm font-semibold text-gray-700">Klik atau seret gambar ke sini</p>
                        <p class="text-[9px] sm:text-xs text-gray-500 mt-1">PNG, JPG, JPEG hingga 5MB (maksimal 5 gambar)</p>
                        <button type="button" id="browse-btn"
                                class="inline-flex items-center px-3 py-1 sm:px-4 sm:py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Pilih File
                        </button>
                    </div>
                </div>
                <div id="preview-container" class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>
                <p id="file-error" class="text-xs sm:text-sm text-red-500 mt-1 hidden"></p>
            </div>

            {{-- DESKRIPSI --}}
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="6"
                    class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                    required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-xs sm:text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-3 sm:pt-4 border-t">
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg shadow hover:bg-green-700 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.produk.index') }}"
                    class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg shadow hover:bg-red-700 transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>

{{-- JS Upload Foto --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
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
        if (e.target !== browseBtn && !e.target.closest('.delete-btn')) inputFoto.click();
    });
    browseBtn.addEventListener("click", (e) => { e.stopPropagation(); inputFoto.click(); });

    // Drag & Drop events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, e => { e.preventDefault(); e.stopPropagation(); }, false);
    });
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => uploadArea.classList.add('border-blue-500', 'bg-blue-50'));
    });
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => uploadArea.classList.remove('border-blue-500', 'bg-blue-50'));
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
                wrapper.className = "relative group";
                wrapper.innerHTML = `
                    <div class="relative aspect-square rounded-lg overflow-hidden border-2 border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview ${index+1}">
                        <div class="absolute inset-0 bg-black/0 bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 flex items-center justify-center">
                            <button type="button" data-index="${index}" 
                                    class="delete-btn opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition-all duration-200 bg-red-500 hover:bg-red-600 text-white rounded-full p-3 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded-full shadow">
                            ${index + 1}
                        </div>
                    </div>
                `;
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });

        const dataTransfer = new DataTransfer();
        filesArray.forEach(f => dataTransfer.items.add(f));
        inputFoto.files = dataTransfer.files;
    }

    previewContainer.addEventListener('click', (e) => {
        const deleteBtn = e.target.closest('.delete-btn');
        if (!deleteBtn) return;
        const index = parseInt(deleteBtn.dataset.index);
        filesArray.splice(index, 1);
        updatePreview();
    });
});
</script>

{{-- JS Warna Other --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const otherCheckbox = document.querySelector('input.warna-checkbox[value="Other"]');
    const warnaLainWrapper = document.getElementById('warna-lain-wrapper');
    const warnaLainInput = document.getElementById('warna-lain');

    if (otherCheckbox) {
        otherCheckbox.addEventListener('change', () => {
            if (otherCheckbox.checked) {
                warnaLainWrapper.classList.remove('hidden');
                warnaLainInput.focus();
            } else {
                warnaLainWrapper.classList.add('hidden');
                warnaLainInput.value = '';
            }
        });
    }
});
</script>
@endsection
