@extends('layouts.admin_app')

@section('content')
<div class="container">
    <h2>Edit Produk</h2>

    {{-- Error global --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada beberapa masalah:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            {{-- Kiri --}}
            <div class="col-md-6">
                {{-- Nama Produk --}}
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk"
                           class="form-control @error('nama_produk') is-invalid @enderror"
                           value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                    @error('nama_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" name="harga" id="harga"
                           class="form-control @error('harga') is-invalid @enderror"
                           value="{{ old('harga', $produk->harga) }}" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah"
                           class="form-control @error('jumlah') is-invalid @enderror"
                           value="{{ old('jumlah', $produk->jumlah) }}" required>
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis --}}
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis" id="jenis"
                            class="form-control @error('jenis') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Kaos" {{ old('jenis', $produk->jenis) == 'Kaos' ? 'selected' : '' }}>Kaos</option>
                        <option value="Kemeja" {{ old('jenis', $produk->jenis) == 'Kemeja' ? 'selected' : '' }}>Kemeja</option>
                        <option value="Jaket" {{ old('jenis', $produk->jenis) == 'Jaket' ? 'selected' : '' }}>Jaket</option>
                        <option value="Celana" {{ old('jenis', $produk->jenis) == 'Celana' ? 'selected' : '' }}>Celana</option>
                        <option value="Other" {{ !in_array(old('jenis', $produk->jenis), ['Kaos','Kemeja','Jaket','Celana']) ? 'selected' : '' }}>Other</option>
                    </select>
                    <input type="text" name="jenis_lain" id="jenis_lain"
                           class="form-control mt-2 {{ !in_array(old('jenis', $produk->jenis), ['Kaos','Kemeja','Jaket','Celana']) ? '' : 'd-none' }}"
                           value="{{ !in_array(old('jenis', $produk->jenis), ['Kaos','Kemeja','Jaket','Celana']) ? old('jenis', $produk->jenis) : '' }}"
                           placeholder="Masukkan jenis lain">
                    @error('jenis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Warna --}}
                <div class="mb-3">
                    <label for="warna" class="form-label">Warna</label>
                    <select name="warna" id="warna"
                            class="form-control @error('warna') is-invalid @enderror" required>
                        <option value="">-- Pilih Warna --</option>
                        <option value="Merah" {{ old('warna', $produk->warna) == 'Merah' ? 'selected' : '' }}>Merah</option>
                        <option value="Biru" {{ old('warna', $produk->warna) == 'Biru' ? 'selected' : '' }}>Biru</option>
                        <option value="Hitam" {{ old('warna', $produk->warna) == 'Hitam' ? 'selected' : '' }}>Hitam</option>
                        <option value="Putih" {{ old('warna', $produk->warna) == 'Putih' ? 'selected' : '' }}>Putih</option>
                        <option value="Other" {{ !in_array(old('warna', $produk->warna), ['Merah','Biru','Hitam','Putih']) ? 'selected' : '' }}>Other</option>
                    </select>
                    <input type="text" name="warna_lain" id="warna_lain"
                           class="form-control mt-2 {{ !in_array(old('warna', $produk->warna), ['Merah','Biru','Hitam','Putih']) ? '' : 'd-none' }}"
                           value="{{ !in_array(old('warna', $produk->warna), ['Merah','Biru','Hitam','Putih']) ? old('warna', $produk->warna) : '' }}"
                           placeholder="Masukkan warna lain">
                    @error('warna')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Kanan --}}
            <div class="col-md-6">
                {{-- Foto lama --}}
                <div class="mb-3">
                    <label class="form-label">Foto Produk Lama</label>
                    @if($produk->fotos->isNotEmpty())
                        <div class="d-flex flex-wrap mb-2">
                            @foreach($produk->fotos as $foto)
                                <div class="position-relative me-2 mb-2">
                                    <img src="{{ asset('storage/' . $foto->foto) }}" 
                                         class="rounded border" style="width:100px;height:100px;object-fit:cover;">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted fst-italic">Belum ada foto</p>
                    @endif

                    {{-- Upload baru --}}
                    <input type="file" name="foto[]" id="foto"
                           class="form-control mt-2 @error('foto.*') is-invalid @enderror" multiple>
                    @error('foto.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="preview-container" class="mt-3 d-flex flex-wrap"></div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              rows="8">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

{{-- Script toggle & preview --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    const selectWarna = document.getElementById("warna");
    const warnaLainContainer = document.getElementById("warna_lain");
    const selectJenis = document.getElementById("jenis");
    const jenisLainContainer = document.getElementById("jenis_lain");
    const inputFoto = document.getElementById("foto");
    const previewContainer = document.getElementById("preview-container");

    function toggleInput(select, input) {
        input.classList.toggle("d-none", select.value !== "Other");
    }

    selectWarna.addEventListener("change", () => toggleInput(selectWarna, warnaLainContainer));
    selectJenis.addEventListener("change", () => toggleInput(selectJenis, jenisLainContainer));

    toggleInput(selectWarna, warnaLainContainer);
    toggleInput(selectJenis, jenisLainContainer);

    inputFoto.addEventListener("change", function() {
        previewContainer.innerHTML = "";
        for (let file of this.files) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.classList.add("me-2","mb-2");
                img.style.width = "120px";
                img.style.height = "120px";
                img.style.objectFit = "cover";
                img.style.borderRadius = "8px";
                img.style.boxShadow = "0 2px 6px rgba(0,0,0,0.2)";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
