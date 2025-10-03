@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Detail Produk </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $produk->nama_produk }}</h4>

                <div class="row">
                    {{-- Foto Produk --}}
                    <div class="col-md-5 mb-3">
                        @if($produk->fotos->isNotEmpty())
                            <div class="d-flex flex-wrap">
                                @foreach($produk->fotos as $foto)
                                    <img src="{{ asset('storage/' . $foto->foto) }}" 
                                         class="me-2 mb-2 rounded border"
                                         style="width: 140px; height: 140px; object-fit: cover;">
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted fst-italic">Belum ada foto</span>
                        @endif
                    </div>

                    {{-- Detail Produk --}}
                    <div class="col-md-7">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th width="160">Nama Produk</th>
                                    <td>{{ $produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $produk->jumlah }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis</th>
                                    <td>{{ $produk->jenis }}</td>
                                </tr>
                                <tr>
                                    <th>Warna</th>
                                    <td>{{ $produk->warna ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $produk->deskripsi }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>{{ $produk->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diupdate</th>
                                    <td>{{ $produk->updated_at->format('d M Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="mt-4">
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">
                        <i class="mdi mdi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Yakin hapus produk ini beserta semua fotonya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="mdi mdi-delete"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
