@extends('layouts.admin_app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h3 class="text-2xl font-semibold mb-2">Detail Produk</h3>
        <nav class="text-sm text-gray-500" aria-label="breadcrumb">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.produk.index') }}" class="text-blue-600 hover:underline">Produk</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">{{ $produk->nama_produk }}</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h4 class="text-xl font-bold mb-4">{{ $produk->nama_produk }}</h4>

        <div class="md:flex md:gap-6">
            {{-- Foto Produk --}}
            <div class="md:w-1/3 mb-4 md:mb-0">
                @if($produk->fotos->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach($produk->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto->foto) }}" 
                                 class="w-32 h-32 object-cover rounded border shadow-sm">
                        @endforeach
                    </div>
                @else
                    <span class="text-gray-400 italic">Belum ada foto</span>
                @endif
            </div>

            {{-- Detail Produk --}}
            <div class="md:w-2/3">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Nama Produk</th>
                                <td class="py-2 px-4">{{ $produk->nama_produk }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Harga</th>
                                <td class="py-2 px-4">IDR {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Jumlah</th>
                                <td class="py-2 px-4">{{ $produk->jumlah }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Jenis</th>
                                <td class="py-2 px-4">{{ $produk->jenis }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Warna</th>
                                <td class="py-2 px-4">{{ is_array($produk->warna) ? implode(', ', $produk->warna) : ($produk->warna ?? '-') }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Ukuran</th>
                                <td class="py-2 px-4">{{ is_array($produk->ukuran) ? implode(', ', $produk->ukuran) : ($produk->ukuran ?? '-') }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Deskripsi</th>
                                <td class="py-2 px-4">{{ $produk->deskripsi }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Dibuat</th>
                                <td class="py-2 px-4">{{ $produk->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th class="text-left py-2 px-4 font-medium">Diupdate</th>
                                <td class="py-2 px-4">{{ $produk->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-6 flex flex-wrap gap-2">
            <a href="{{ route('admin.produk.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 flex items-center gap-1">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 flex items-center gap-1">
                <i class="mdi mdi-pencil"></i> Edit
            </a>
            <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus produk ini beserta semua fotonya?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 flex items-center gap-1">
                    <i class="mdi mdi-delete"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
