@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Daftar Produk</h2>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-success btn-lg">
            <i class="mdi mdi-plus"></i> Tambah Produk
        </a>

        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Nama Produk</th>
                    <th>Warna</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Jenis</th>
                    <th>Foto</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $produk)
                    <tr>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->warna }}</td>
                        <td>IDR {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->jumlah }}</td>
                        <td>{{ $produk->jenis }}</td>
                        <td>
                            @if($produk->fotos->isNotEmpty())
                                <div class="d-flex flex-wrap">
                                    @foreach($produk->fotos as $foto)
                                        <img src="{{ asset('storage/' . $foto->foto) }}" class="me-2 mb-2 rounded border"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted fst-italic">Belum ada foto</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-purple dropdown-toggle" type="button"
                                    id="dropdownMenu{{ $produk->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $produk->id }}">
                                    {{-- Lihat --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.produk.show', $produk->id) }}">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </li>

                                    {{-- Edit --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.produk.edit', $produk->id) }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    </li>

                                    {{-- Hapus --}}
                                    <li>
                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus produk ini beserta semua fotonya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted fst-italic">
                            Belum ada produk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection