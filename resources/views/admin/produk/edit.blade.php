@extends('layouts.admin_app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk</h2>

    {{-- Error global --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <strong>Oops!</strong> Ada beberapa masalah:
            <ul class="list-disc list-inside text-sm mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Kiri --}}
            <div class="space-y-6">
                {{-- Nama Produk --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}"
                        class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10" required>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Harga</label>
                    <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}"
                        class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10" required>
                </div>

                {{-- Jumlah --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', $produk->jumlah) }}"
                        class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10" required>
                </div>

                {{-- Jenis --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Jenis</label>
                    <select name="jenis" class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500 h-10" required>
                        <option class="text-muted" value="">Pilih Kategori Produk</option>
                        <option value="T-Shirt" {{ old('jenis', $produk->jenis)=='T-Shirt' ? 'selected' : '' }}>T-Shirt</option>
                        <option value="Hoodie" {{ old('jenis', $produk->jenis)=='Hoodie' ? 'selected' : '' }}>Hoodie</option>
                        <option value="Jersey" {{ old('jenis', $produk->jenis)=='Jersey' ? 'selected' : '' }}>Jersey</option>
                    </select>
                </div>

                {{-- Warna --}}
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
                        $oldWarna = collect(old('warna', is_array($produk->warna) ? $produk->warna : [$produk->warna]));
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
                </div>

                {{-- Ukuran --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran</label>
                    @php
                        $selectedUkuran = collect(old('ukuran', is_array($produk->ukuran) ? $produk->ukuran : [$produk->ukuran]));
                    @endphp
                    <div class="flex flex-wrap gap-3 mt-2">
                        @foreach(['XS','S','M','L','XL','XXL'] as $uk)
                            <label class="flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-lg border-2 border-gray-300
                                         peer-checked:border-blue-300 transition-all duration-200 cursor-pointer">
                                <input type="checkbox" name="ukuran[]" value="{{ $uk }}"
                                       class="sr-only peer" {{ $selectedUkuran->contains($uk) ? 'checked' : '' }}>
                                <span class="text-gray-700 font-medium">{{ $uk }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kanan --}}
            <div class="space-y-6">
                {{-- Foto Lama --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Foto Produk Lama</label>
                    @if($produk->fotos->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($produk->fotos as $foto)
                                <img src="{{ asset('storage/' . $foto->foto) }}" class="w-24 h-24 rounded-lg object-cover border">
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic mt-1">Belum ada foto</p>
                    @endif

                    {{-- Upload Baru --}}
                    <div id="upload-area" class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer transition-all duration-300 hover:border-blue-500 hover:bg-blue-50/50 mt-3">
                        <input type="file" name="foto[]" id="foto" class="hidden" multiple accept="image/*">
                        <div id="upload-placeholder">
                            <p class="text-gray-700">Klik atau seret gambar ke sini</p>
                            <button type="button" id="browse-btn" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Pilih File</button>
                        </div>
                    </div>
                    <div id="preview-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mt-3"></div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" rows="6"
                              class="mt-2 w-full rounded-lg border-2 border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col gap-3 mt-6">
                    <button type="submit"
                        class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Update
                    </button>
                    <a href="{{ route('admin.produk.index') }}"
                        class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-center">
                        Batal
                    </a>
                </div>
            </div>
        </div> 
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Toggle warna lain
    const otherCheckbox = document.querySelector('input.warna-checkbox[value="Other"]');
    const warnaLainWrapper = document.getElementById('warna-lain-wrapper');
    const warnaLainInput = document.getElementById('warna-lain');
    if(otherCheckbox){
        otherCheckbox.addEventListener('change', () => {
            if(otherCheckbox.checked){
                warnaLainWrapper.classList.remove('hidden');
                warnaLainInput.focus();
            } else {
                warnaLainWrapper.classList.add('hidden');
                warnaLainInput.value = '';
            }
        });
    }

    // Upload & preview foto
    const inputFoto = document.getElementById("foto");
    const uploadArea = document.getElementById("upload-area");
    const previewContainer = document.getElementById("preview-container");
    const uploadPlaceholder = document.getElementById("upload-placeholder");
    const browseBtn = document.getElementById("browse-btn");
    let filesArray = [];
    const MAX_FILES = 5;
    const MAX_SIZE_MB = 5;

    uploadArea.addEventListener("click", (e) => {
        if(e.target !== browseBtn) inputFoto.click();
    });
    browseBtn.addEventListener("click", e => { e.stopPropagation(); inputFoto.click(); });

    inputFoto.addEventListener("change", e => handleFiles(e.target.files));

    function handleFiles(files){
        let validFiles = [];
        Array.from(files).forEach(file => {
            if(file.size / 1024 / 1024 > MAX_SIZE_MB) return;
            validFiles.push(file);
        });
        filesArray = [...filesArray, ...validFiles].slice(0, MAX_FILES);
        updatePreview();
    }

    function updatePreview(){
        previewContainer.innerHTML = "";
        uploadPlaceholder.classList.toggle('hidden', filesArray.length > 0);
        filesArray.forEach((file, index)=>{
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.className = "relative group";
                wrapper.innerHTML = `
                    <div class="relative aspect-square rounded-lg overflow-hidden border-2 border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-opacity-40 flex items-center justify-center transition-all duration-200">
                            <button type="button" data-index="${index}" class="delete-btn opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 bg-red-500 hover:bg-red-600 text-white rounded-full p-2">
                                &times;
                            </button>
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

    previewContainer.addEventListener('click', e => {
        const btn = e.target.closest('.delete-btn');
        if(!btn) return;
        const index = parseInt(btn.dataset.index);
        filesArray.splice(index,1);
        updatePreview();
    });
});
</script>
@endsection
