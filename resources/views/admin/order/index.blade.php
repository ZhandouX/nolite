@extends('layouts.admin_app')

@section('title', 'Daftar Order')

@section('content')
    <div class="pt-24 px-4 max-w-7xl mx-auto">

        <h1 class="text-2xl font-semibold mb-6">Daftar Order</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Nama Penerima</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Jumlah Item</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Total</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">{{ $order->id }}</td>
                            <td class="px-4 py-2 border-b">{{ $order->nama_penerima }}</td>
                            <td class="px-4 py-2 border-b">{{ $order->items->count() }}</td>
                            <td class="px-4 py-2 border-b text-red-600 font-semibold">
                                Rp{{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border-b capitalize">{{ $order->status }}</td>
                            <td class="px-4 py-2 border-b">
                                <button onclick="toggleModal({{ $order->id }})"
                                    class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-500">Ubah
                                    Status</button>
                            </td>
                        </tr>

                        <!-- Modal Update Status -->
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
                                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
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

    <script>
        function toggleModal(id) {
            const modal = document.getElementById('modal-' + id);
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    </script>
@endsection