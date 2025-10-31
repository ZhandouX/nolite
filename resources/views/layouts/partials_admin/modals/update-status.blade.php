<div id="modal-{{ $order->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="bg-white w-11/12 md:w-1/3 rounded-xl p-6 relative">
        <button onclick="toggleModal({{ $order->id }})"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">✕</button>
        <h3 class="text-lg font-semibold mb-4">Ubah Status Order #{{ $order->id }}</h3>

        <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" class="space-y-3">
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
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Simpan</button>
            </div>
        </form>
    </div>
</div>