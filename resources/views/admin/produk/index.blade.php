@extends('layouts.admin_app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Produk</h2>
            <a href="{{ route('admin.produk.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 flex items-center gap-2 transition">
                <i class="mdi mdi-plus"></i> Tambah Produk
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg shadow-md border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-black text-white">
                    <tr class="text-center">
                        <th class="px-4 py-3 text-sm font-medium uppercase">Nama Produk</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Warna</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Ukuran</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Harga</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Diskon (%)</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Diskon (IDR)</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Jenis</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Foto</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($produks as $produk)
                        <tr class="text-center text-gray-700 hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $produk->nama_produk }}</td>
                            <td class="px-4 py-3">
                                @if(is_array($produk->warna))
                                    {{ implode(', ', $produk->warna) }}
                                @else
                                    {{ $produk->warna }}
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if(is_array($produk->ukuran))
                                    {{ implode(', ', $produk->ukuran) }}
                                @else
                                    {{ $produk->ukuran }}
                                @endif
                            </td>
                            <td class="px-4 py-3">IDR {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">{{ $produk->diskon ?? 0 }}%</td>
                            <td class="px-4 py-3 text-center">
                                {{ $produk->diskon ? number_format($produk->harga * $produk->diskon / 100, 0, ',', '.') : 0 }}
                            </td>
                            <td class="px-4 py-3">{{ $produk->jumlah }}</td>
                            <td class="px-4 py-3">{{ $produk->jenis }}</td>
                            <td class="px-4 py-3">
                                @if($produk->fotos->isNotEmpty())
                                    <div class="flex flex-wrap justify-center gap-2">
                                        @foreach($produk->fotos as $foto)
                                            <img src="{{ asset('storage/' . $foto->foto) }}"
                                                class="w-20 h-20 object-cover rounded border shadow-sm hover:scale-105 transition-transform duration-200">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 italic text-sm">Belum ada foto</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 relative">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white hover:text-white rounded-lg shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                                    onclick="toggleDropdown({{ $produk->id }})">
                                    Aksi
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $produk->id }}"
                                    class="absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10">
                                    <a href="{{ route('admin.produk.show', $produk->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat</a>
                                    <a href="{{ route('admin.produk.edit', $produk->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                    <a href="#"
                                        onclick="openDiscountModal({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->diskon ?? 0 }})"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Beri Diskon</a>
                                    <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus produk ini beserta semua fotonya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full text-center bg-gray-100 px-4 py-2 text-sm text-red-600 hover:bg-gray-150">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-400 italic">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="discountModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg w-96 p-6 relative">
            <h3 class="text-lg font-bold mb-4">Beri Diskon</h3>
            <form id="discountForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="produk_id" id="discountProdukId">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Diskon (%)</label>
                    <input type="number" name="diskon" id="discountPercent" min="0" max="100"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Opsional, kosongkan jika tidak ada">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400"
                        onclick="closeDiscountModal()">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
            <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold"
                onclick="closeDiscountModal()">×</button>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown-' + id);
            const allDropdowns = document.querySelectorAll('[id^=dropdown-]');
            allDropdowns.forEach(d => { if (d !== dropdown) d.classList.add('hidden'); });
            dropdown.classList.toggle('hidden');
        }

        // Klik di luar dropdown untuk menutup
        window.addEventListener('click', function (e) {
            document.querySelectorAll('[id^=dropdown-]').forEach(d => {
                if (!d.contains(e.target) && !d.previousElementSibling.contains(e.target)) {
                    d.classList.add('hidden');
                }
            });
        });
    </script>

    <script>
        function openDiscountModal(id, nama, diskon) {
            document.getElementById('discountProdukId').value = id;
            document.getElementById('discountPercent').value = diskon;
            document.getElementById('discountModal').classList.remove('hidden');
        }

        function closeDiscountModal() {
            document.getElementById('discountModal').classList.add('hidden');
        }

        // Submit via PATCH
        document.getElementById('discountForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('discountProdukId').value;
            const diskon = document.getElementById('discountPercent').value || 0;

            fetch(`/admin/produk/${id}/diskon`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ diskon })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Diskon berhasil diperbarui!');
                        location.reload(); // reload agar kolom diskon update
                    } else {
                        alert('Gagal memperbarui diskon.');
                    }
                });
        });
    </script>
@endsection