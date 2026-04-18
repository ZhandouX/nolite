@extends('layouts.app')

@section('content')
    <div class="p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manajemen Ulasan</h1>

            {{-- Badge jumlah belum dibalas --}}
            <span class="px-3 py-1 bg-red-500 text-white text-sm rounded">
                Belum dibalas: {{ $jumlahBelumDibalas }}
            </span>
        </div>

        {{-- SEARCH + FILTER --}}
        <form method="GET" class="mb-5 grid grid-cols-1 md:grid-cols-4 gap-3">

            {{-- Search --}}
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari user / produk..."
                class="border rounded px-3 py-2 w-full">

            {{-- Filter Rating --}}
            <select name="rating" class="border rounded px-3 py-2">
                <option value="">Semua Rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} ⭐
                    </option>
                @endfor
            </select>

            {{-- Filter Balasan --}}
            <select name="reply" class="border rounded px-3 py-2">
                <option value="">Semua Status</option>
                <option value="belum" {{ request('reply') == 'belum' ? 'selected' : '' }}>Belum dibalas</option>
                <option value="sudah" {{ request('reply') == 'sudah' ? 'selected' : '' }}>Sudah dibalas</option>
            </select>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Terapkan
            </button>
        </form>

        {{-- TABEL ULASAN --}}
        <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">

            <table class="w-full border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-gray-100 border-b text-left">
                        <th class="p-3">User</th>
                        <th class="p-3">Produk</th>
                        <th class="p-3">Rating</th>
                        <th class="p-3">Komentar</th>
                        <th class="p-3">Foto</th>
                        <th class="p-3">Balasan Admin</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ulasans as $ulasan)
                        <tr class="border-b hover:bg-gray-50">

                            {{-- User --}}
                            <td class="p-3">
                                <div class="font-semibold">{{ $ulasan->user->name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $ulasan->created_at->format('d M Y H:i') }}
                                </div>
                            </td>

                            {{-- Produk --}}
                            <td class="p-3">
                                <div class="font-semibold">{{ $ulasan->produk->nama_produk }}</div>
                                <div class="text-sm text-gray-500">
                                    Rp {{ number_format($ulasan->produk->harga, 0, ',', '.') }}
                                </div>
                            </td>

                            {{-- Rating --}}
                            <td class="p-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $ulasan->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </td>

                            {{-- Komentar --}}
                            <td class="p-3">
                                {{ $ulasan->komentar ?: '-' }}
                            </td>

                            {{-- Foto Ulasan --}}
                            <td class="p-3">
                                <div class="flex gap-2">
                                    @foreach ($ulasan->fotos as $foto)
                                        <img src="{{ asset('storage/' . $foto->foto) }}"
                                            class="w-16 h-16 object-cover rounded cursor-pointer border hover:opacity-75"
                                            onclick="openPreview('{{ asset('storage/' . $foto->foto) }}')">
                                    @endforeach
                                </div>
                            </td>

                            {{-- Balasan Admin --}}
                            <td class="p-3">
                                @if ($ulasan->admin_reply)
                                    <div class="p-3 bg-blue-50 border-l-4 border-blue-400 rounded">
                                        {{ $ulasan->admin_reply }}
                                    </div>
                                @else
                                    <span class="text-red-500 text-sm">Belum dibalas</span>
                                @endif
                            </td>

                            <td class="p-3">
                                <a href="{{ route('admin.ulasan.show', $ulasan->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow hover:bg-blue-700 transition duration-200">
                                    <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                                    Detail
                                </a>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-5 text-gray-500">
                                Tidak ada ulasan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $ulasans->links() }}
            </div>

        </div>
    </div>

    {{-- Modal Preview Foto --}}
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-70 hidden justify-center items-center z-50">
        <img id="previewImage" class="max-w-[90%] max-h-[90%] rounded shadow-lg">
    </div>

    <script>
        function openPreview(src) {
            const modal = document.getElementById('imagePreviewModal');
            const img = document.getElementById('previewImage');

            img.src = src;
            modal.classList.remove('hidden');

            modal.onclick = () => modal.classList.add('hidden');
        }
    </script>

@endsection
