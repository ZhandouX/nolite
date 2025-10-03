@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <h2>Tambah Produk</h2>

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

        <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Kiri --}}
                <div class="col-md-6">
                    {{-- Nama Produk --}}
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk"
                            class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}"
                            required>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" id="harga"
                            class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah"
                            class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis --}}
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select name="jenis" id="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Elektronik" {{ old('jenis') == 'Elektronik' ? 'selected' : '' }}>Elektronik
                            </option>
                            <option value="Pakaian" {{ old('jenis') == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                            <option value="Makanan" {{ old('jenis') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Other" {{ old('jenis') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="jenis_lain_container" style="display: none;">
                        <label for="jenis_lain" class="form-label">Jenis Lain</label>
                        <input type="text" name="jenis_lain" id="jenis_lain"
                            class="form-control @error('jenis_lain') is-invalid @enderror" value="{{ old('jenis_lain') }}"
                            placeholder="Masukkan jenis lain">
                        @error('jenis_lain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Warna --}}
                    <div class="mb-3">
                        <label for="warna" class="form-label">Warna</label>
                        <select name="warna" id="warna" class="form-control @error('warna') is-invalid @enderror" required>
                            <option value="">-- Pilih Warna --</option>
                            <option value="Merah" {{ old('warna') == 'Merah' ? 'selected' : '' }}>Merah</option>
                            <option value="Biru" {{ old('warna') == 'Biru' ? 'selected' : '' }}>Biru</option>
                            <option value="Hijau" {{ old('warna') == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                            <option value="Other" {{ old('warna') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('warna')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="warna_lain_container" style="display: none;">
                        <label for="warna_lain" class="form-label">Warna Lain</label>
                        <input type="text" name="warna_lain" id="warna_lain"
                            class="form-control @error('warna_lain') is-invalid @enderror" value="{{ old('warna_lain') }}"
                            placeholder="Masukkan warna lain">
                        @error('warna_lain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Kanan --}}
                <div class="col-md-6">
                    {{-- Foto Produk --}}
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Produk (boleh lebih dari 1)</label>
                        <input type="file" name="foto[]" id="foto"
                            class="form-control @error('foto.*') is-invalid @enderror" multiple>
                        @error('foto.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="preview-container" class="mt-3 d-flex flex-wrap"></div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi"
                            class="form-control @error('deskripsi') is-invalid @enderror" rows="8"
                            required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-success w-100"><i class="mdi mdi-content-save"></i> Simpan</button>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-danger w-100">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Script toggle & preview --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectWarna = document.getElementById("warna");
            const warnaLainContainer = document.getElementById("warna_lain_container");
            const selectJenis = document.getElementById("jenis");
            const jenisLainContainer = document.getElementById("jenis_lain_container");
            const inputFoto = document.getElementById("foto");
            const previewContainer = document.getElementById("preview-container");

            function toggleInput(select, container) {
                container.style.display = (select.value === "Other") ? "block" : "none";
            }

            // toggle warna & jenis
            selectWarna.addEventListener("change", () => toggleInput(selectWarna, warnaLainContainer));
            selectJenis.addEventListener("change", () => toggleInput(selectJenis, jenisLainContainer));

            toggleInput(selectWarna, warnaLainContainer);
            toggleInput(selectJenis, jenisLainContainer);

            // preview foto
            inputFoto.addEventListener("change", function () {
                previewContainer.innerHTML = "";
                for (let file of this.files) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.classList.add("me-2", "mb-2");
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