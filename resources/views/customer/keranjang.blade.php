@extends('layouts.user_app')

@section('title', 'Keranjang')

@push('style')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@section('content')
    <div class="container mx-auto py-10 mt-12">

        {{-- BACK BUTTON --}}
        <div class="flex justify-end mb-6">
            <a href="{{ route('customer.dashboard') }}"
                class="inline-flex items-center gap-2 bg-gray-800 text-white px-4 py-2 rounded-xl hover:bg-gray-500 transition">
                <i class="fa fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="cart-container grid md:grid-cols-3 gap-8">

            {{-- LEFT: PRODUCT LIST --}}
            <div class="cart-items md:col-span-2 bg-white p-6 rounded-2xl shadow border-gray-300">
                <div class="cart-header flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Keranjang</h2>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 rounded border-gray-300">
                        <label for="select-all" class="text-gray-700 text-sm cursor-pointer">Pilih Semua</label>
                    </div>
                </div>

                @forelse($keranjang as $key => $item)
                    {{-- SESSION CART (GUEST & LOGIN) --}}
                    @php
                        if ($item instanceof \App\Models\Keranjang) {
                            $produk = $item->produk;
                            $foto = $produk?->fotos?->first()?->foto ?? null;
                            $warna = $item->warna;
                            $ukuran = $item->ukuran;
                            $jumlah = $item->jumlah;
                        } else {
                            $produk = (object) [
                                'nama_produk' => $item['nama_produk'] ?? 'Produk tidak ditemukan',
                                'harga' => $item['harga'] ?? 0,
                                'deskripsi' => $item['deskripsi'] ?? '-',
                            ];
                            $foto = $item['foto'] ?? null;
                            $warna = $item['warna'] ?? '-';
                            $ukuran = $item['ukuran'] ?? '-';
                            $jumlah = $item['jumlah'] ?? 1;
                        }
                    @endphp

                    <div class="item-keranjang flex gap-4 border-b pb-5 mb-5 items-start"
                        data-id="{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}">
                        {{-- PRODUCT CHECKBOX --}}
                        <input type="checkbox" class="select-item w-4 h-4 text-blue-600 border-gray-300 mt-3"
                            data-keranjang="{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}"
                            data-nama="{{ $produk->nama_produk }}" data-warna="{{ $warna }}" data-ukuran="{{ $ukuran }}"
                            data-harga="{{ $produk->harga }}" data-jumlah="{{ $jumlah }}">

                        {{-- PRODUCT IMAGE --}}
                        <div
                            class="w-28 h-28 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                            @if($foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="Produk" class="object-cover w-full h-full">
                            @else
                                <span class="text-gray-400 italic text-sm">Belum ada foto</span>
                            @endif
                        </div>

                        {{-- PRODUCT INFORMATION --}}
                        <div class="flex-1">
                            <h3 class="font-bold text-xl text-black-800">{{ $produk->nama_produk }}</h3>
                            <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $produk->deskripsi }}</p>

                            <div class="text-gray-500 text-sm mt-2">
                                Warna: <span class="font-medium">{{ $warna }}</span>,
                                Ukuran: <span class="font-medium">{{ $ukuran }}</span>
                            </div>

                            <div class="text-blue-700 font-bold mt-2 text-lg">
                                IDR {{ number_format($produk->harga, 0, ',', '.') }}
                            </div>

                            <div class="text-sm text-gray-600 mt-1">
                                Jumlah: {{ $jumlah }}
                            </div>
                            <!-- Tombol Hapus -->
                            <button onclick="hapusKeranjang('{{ $item instanceof \App\Models\Keranjang ? $item->id : $key }}')"
                                class="btn-delete px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition transform hover:scale-105">
                                Hapus
                            </button>

                            <!-- Toast Notification -->
                            <div id="toast"
                                class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg opacity-0 transition-opacity duration-500">
                                Produk berhasil dihapus!
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">Keranjang kosong</p>
                @endforelse
            </div>

            {{-- RIGHT: ORDER INFORMATION --}}
            <div class="summary bg-white p-6 rounded-2xl shadow">
                <h3 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h3>

                <div class="flex justify-between mb-2">
                    <span>Subtotal</span>
                    <span id="subtotal">IDR 0</span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t pt-4">
                    <span>Total</span>
                    <span id="total">IDR 0</span>
                </div>

                {{-- CHECKOUT FORM --}}
                <form id="checkout-form" action="{{ route('customer.checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="selected_items" id="selected-items">
                    <button type="submit"
                        class="checkout-btn w-full mt-5 bg-gray-600 text-white py-2.5 rounded-2xl hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="checkout-btn" disabled>
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.select-item');
            const subtotalEl = document.getElementById('subtotal');
            const totalEl = document.getElementById('total');
            const checkoutBtn = document.getElementById('checkout-btn');
            const selectedItemsInput = document.getElementById('selected-items');
            const checkoutForm = document.getElementById('checkout-form');

            function formatIDR(angka) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })
                    .format(angka)
                    .replace('Rp', 'IDR');
            }

            function updateTotal() {
                let total = 0;
                const selected = [];

                checkboxes.forEach(cb => {
                    if (cb.checked) {
                        const harga = parseFloat(cb.dataset.harga);
                        const qty = parseInt(cb.dataset.jumlah);
                        total += harga * qty;
                        selected.push(cb.dataset.keranjang);
                    }
                });

                subtotalEl.textContent = formatIDR(total);
                totalEl.textContent = formatIDR(total);
                checkoutBtn.disabled = selected.length === 0;
                selectedItemsInput.value = JSON.stringify(selected);
            }

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
                updateTotal();
            });

            checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
            updateTotal();

            checkoutForm.addEventListener('submit', function (e) {
                const selected = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.keranjang);

                if (selected.length === 0) {
                    e.preventDefault();
                    alert('Pilih produk terlebih dahulu untuk checkout!');
                    return;
                }

                selectedItemsInput.value = JSON.stringify(selected);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JS: CART --}}
    <script>
        function hapusKeranjang(id) {
            Swal.fire({
                title: 'Hapus item ini?',
                text: "Produk akan dihapus dari keranjangmu.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                buttonsStyling: true,
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('keranjang') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                    toast: true,
                                    position: 'top-end'
                                });

                                // Hapus item dari DOM dengan fade-out
                                const itemEl = document.querySelector(`.item-keranjang[data-id='${id}']`);
                                if (itemEl) {
                                    itemEl.classList.add('transition-opacity', 'duration-500', 'opacity-0');
                                    setTimeout(() => itemEl.remove(), 500);
                                }

                                // Update total keranjang
                                const checkboxes = document.querySelectorAll('.select-item');
                                let total = 0;
                                checkboxes.forEach(cb => {
                                    if (cb.checked) {
                                        const harga = parseFloat(cb.dataset.harga);
                                        const qty = parseInt(cb.dataset.jumlah);
                                        total += harga * qty;
                                    }
                                });
                                const subtotalEl = document.getElementById('subtotal');
                                const totalEl = document.getElementById('total');
                                subtotalEl.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total).replace('Rp', 'IDR');
                                totalEl.textContent = subtotalEl.textContent;

                                // --- UPDATE NAVBAR BADGE ---
                                const badge = document.getElementById('cartBadge');
                                if (badge) {
                                    let currentCount = parseInt(badge.textContent) || 0;
                                    currentCount = currentCount - 1;
                                    if (currentCount > 0) {
                                        badge.textContent = currentCount;
                                        badge.classList.remove('hidden');
                                    } else {
                                        badge.classList.add('hidden');
                                    }
                                }

                                // --- UPDATE CART POPUP ---
                                updateCartPopup(); // fungsi existing untuk refresh popup
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message,
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan!',
                                text: 'Tidak dapat menghapus item dari keranjang.',
                            });
                        });
                }
            });
        }
    </script>
@endpush