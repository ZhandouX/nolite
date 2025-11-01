@extends('layouts.admin_app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fa-solid fa-shirt mr-2"></i> Daftar Produk
            </h2>
            <a href="{{ route('admin.produk.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 flex items-center gap-2 transition">
                <i class="mdi mdi-plus"></i> Tambah Produk
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg border">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr class="text-center">
                        <th class="px-4 py-3 text-sm font-medium uppercase">Produk</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Warna & Ukuran</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Harga</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Foto</th>
                        <th class="px-4 py-3 text-sm font-medium uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($produks as $produk)
                        <tr class="text-center text-gray-700 hover:bg-gray-50 transition">
                            {{-- PRODUK --}}
                            <td class="px-4 py-4 text-left">
                                <p class="font-semibold text-gray-900">{{ $produk->nama_produk }}</p>
                                <p class="text-sm text-gray-500">Jenis: {{ $produk->jenis }}</p>
                                <p class="text-sm text-gray-500">Stok: {{ $produk->jumlah }}</p>
                            </td>

                            {{-- WARNA & UKURAN --}}
                            <td class="px-4 py-4 text-sm">
                                <p>
                                    <span class="font-medium text-gray-700">Warna:</span>
                                    {{ is_array($produk->warna) ? implode(', ', $produk->warna) : $produk->warna }}
                                </p>
                                <p>
                                    <span class="font-medium text-gray-700">Ukuran:</span>
                                    {{ is_array($produk->ukuran) ? implode(', ', $produk->ukuran) : $produk->ukuran }}
                                </p>
                            </td>

                            {{-- HARGA --}}
                            <td class="px-4 py-4 text-sm text-gray-800">
                                @if($produk->diskon && $produk->diskon > 0)
                                    @php
                                        $hargaDiskon = $produk->harga - ($produk->harga * $produk->diskon / 100);
                                    @endphp
                                    <p class="text-gray-400 font-bold line-through">
                                        IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                    </p>
                                    <p class="text-red-600 font-bold">
                                        IDR {{ number_format($hargaDiskon, 0, ',', '.') }}
                                    </p>
                                @else
                                    <p class="font-semibold text-gray-900">
                                        IDR {{ number_format($produk->harga, 0, ',', '.') }}
                                    </p>
                                @endif

                                <p class="text-gray-500">
                                    Diskon: <span class="font-semibold text-blue-600">{{ $produk->diskon ?? 0 }}%</span>
                                </p>
                                <p class="text-gray-500">
                                    Potongan: <span class="font-semibold text-red-600">
                                        IDR
                                        {{ $produk->diskon ? number_format($produk->harga * $produk->diskon / 100, 0, ',', '.') : '0' }}
                                    </span>
                                </p>
                            </td>

                            {{-- FOTO --}}
                            <td class="px-4 py-4">
                                @if($produk->fotos->isNotEmpty())
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        @foreach($produk->fotos as $foto)
                                            <img src="{{ asset('storage/' . $foto->foto) }}"
                                                class="w-16 h-16 object-cover rounded-md border shadow-sm hover:scale-105 transition-transform duration-200">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 italic text-sm">Belum ada foto</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-4 relative text-center">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 focus:outline-none transition"
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
<<<<<<< HEAD
                                    <a href="#" onclick="openDiscountModal({{ $produk->id }}, {{ $produk->diskon ?? 0 }})"
=======
                                    <a href="#"
                                        onclick="openDiscountModal({{ $produk->id }}, {{ $produk->diskon ?? 0 }})"
>>>>>>> ddc90c490ada53271f5745efbe6d1e9a9ada3545
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
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400 italic">Belum ada produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL DISKON --}}
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
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // === Dropdown ===
        function toggleDropdown(id) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
            const el = document.getElementById(`dropdown-${id}`);
            if (!el) return;
            el.classList.toggle('hidden');
        }

        document.addEventListener('click', function (e) {
            const isActionButton = e.target.closest('[onclick^="toggleDropdown("]') !== null;
            const isInsideDropdown = e.target.closest('[id^="dropdown-"]') !== null;
            if (!isActionButton && !isInsideDropdown) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(drop => drop.classList.add('hidden'));
            }
        });

        // === Modal Diskon ===
        function openDiscountModal(id, nama = '', diskon = 0) {
            document.getElementById('discountProdukId').value = id;
            document.getElementById('discountPercent').value = diskon;
            document.getElementById('discountModal').classList.remove('hidden');
            document.getElementById('discountPercent').focus();
        }

        function closeDiscountModal() {
            document.getElementById('discountModal').classList.add('hidden');
        }

        // === PATCH via Fetch ===
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
                .then(async res => {
                    let data;
                    try { data = await res.json(); } catch (err) { data = null; }

                    if (res.ok && data && data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Diskon produk berhasil diperbarui.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => location.reload());
                    } else {
                        const msg = (data && data.message) ? data.message : 'Gagal memperbarui diskon.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: msg
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Jaringan',
                        text: 'Terjadi kesalahan jaringan. Coba lagi nanti.'
                    });
                });
        });

        // Tutup modal bila klik di luar
        document.getElementById('discountModal').addEventListener('click', function (e) {
            if (e.target === this) closeDiscountModal();
        });
    </script>
@endpush
