@extends('layouts.admin_app')

@section('title', 'Daftar Order')

@section('content')
    <div class="px-4 max-w-7xl mx-auto">

        <h1 class="text-2xl font-semibold mb-6">
            <i class="fa-solid fa-shopping-cart mr-2"></i> Daftar Order</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="px-4 py-2 border-b text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 border-b text-sm font-medium text-gray-700">Penerima</th>
                        <th class="px-4 py-2 border-b text-sm font-medium text-gray-700">Alamat</th>
                        <th class="px-4 py-2 border-b text-sm font-medium text-gray-700">Pesanan</th>
                        <th class="px-4 py-2 border-b text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2 border-b text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            {{-- ID --}}
                            <td class="px-4 py-2 border-b">{{ $order->id }}</td>

                            {{-- PENERIMA --}}
                            <td class="px-4 py-2 border-b">
                                <p class="font-semibold">{{ $order->nama_penerima }}</p>
                                <p class="text-sm text-gray-500">{{ $order->no_hp }}</p>
                            </td>

                            {{-- ALAMAT --}}
                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                <p>{{ $order->provinsi }}, {{ $order->kota }}</p>
                                <p>{{ $order->alamat_detail }}</p>
                            </td>

                            {{-- PESANAN --}}
                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                @foreach($order->items as $item)
                                    <div class="mb-2 border-b border-gray-200 pb-1">
                                        <p class="font-semibold">{{ $item->produk->nama_produk }}</p>
                                        <p class="text-gray-500 text-sm">Jumlah: {{ $item->jumlah }}</p>
                                        <p class="text-sm">
                                            @if($item->produk->diskon && $item->produk->diskon > 0)
                                                <p class="text-gray-400 text-sm line-through">
                                                    IDR {{ number_format($item->produk->harga, 0, ',', '.') }}
                                                </p>
                                                <p class="text-red-600 font-semibold text-sm">
                                                    IDR
                                                    {{ number_format($item->produk->harga - ($item->produk->harga * $item->produk->diskon / 100), 0, ',', '.') }}
                                                </p>
                                            @else
                                            <p class="text-gray-700 font-semibold text-sm">
                                                IDR {{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </p>
                                        @endif
                                        </p>
                                        <p class="text-gray-700 font-semibold">Subtotal: IDR
                                            {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </td>

                            {{-- STATUS --}}
                            <td class="px-4 py-2 border-b capitalize font-medium">{{ $order->status }}</td>

                            {{-- AKSI --}}
                            <td class="px-4 py-2 border-b relative text-center">
                                <button type="button" onclick="toggleDropdown({{ $order->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500 flex items-center gap-1">
                                    Aksi
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div id="dropdown-{{ $order->id }}"
                                    class="absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10">
                                    <a href="#" onclick="toggleModal({{ $order->id }})"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Update Status</a>
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lihat Pesanan</a>
                                </div>
                            </td>
                        </tr>

                        {{-- MODAL UPDATE STATUS --}}
                        <div id="modal-{{ $order->id }}"
                            class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
                            <div class="bg-white w-11/12 md:w-1/3 rounded-xl p-6 relative">
                                <button onclick="toggleModal({{ $order->id }})"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">✕</button>
                                <h3 class="text-lg font-semibold mb-4">Ubah Status Order #{{ $order->id }}</h3>

                                <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST"
                                    class="space-y-3">
                                    @csrf
                                    <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                                        <option value="menunggu" {{ $order->status == 'menunggu' ? 'selected' : '' }}>Menunggu
                                        </option>
                                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses
                                        </option>
                                        <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim
                                        </option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                    </select>
                                    <div class="flex justify-end space-x-2">
                                        <button type="button" onclick="toggleModal({{ $order->id }})"
                                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle dropdown
        function toggleDropdown(id) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
            const el = document.getElementById('dropdown-' + id);
            if (!el) return;
            el.classList.toggle('hidden');
        }

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function (e) {
            const isActionButton = e.target.closest('[onclick^="toggleDropdown("]') !== null;
            const isInsideDropdown = e.target.closest('[id^="dropdown-"]') !== null;
            if (!isActionButton && !isInsideDropdown) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(drop => drop.classList.add('hidden'));
            }
        });

        // Toggle modal
        function toggleModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    </script>
@endpush