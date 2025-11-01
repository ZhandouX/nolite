@extends('layouts.admin_app')

@section('content')
    <div class="container mx-auto px-4">
        <h4 class="text-xl font-bold mb-4">Kelola Pengguna</h4>

        {{-- Statistik --}}
        <div class="grid grid-cols-4 gap-4 mb-4">
            <div><strong>Total:</strong> {{ $stats['total'] }}</div>
            <div><strong>Aktif:</strong> {{ $stats['aktif'] }}</div>
            <div><strong>Nonaktif:</strong> {{ $stats['nonaktif'] }}</div>
            <div><strong>Diblokir:</strong> {{ $stats['diblokir'] }}</div>
        </div>

        {{-- Form Pencarian --}}
        <form method="GET" class="mb-4">
            <div class="flex">
                <input type="text" name="search" class="border p-2 flex-1" placeholder="Cari pengguna..."
                    value="{{ request('search') }}">
                <button class="bg-blue-500 text-white px-4 py-2 ml-2 rounded">Cari</button>
            </div>
        </form>

        {{-- Tabel Pengguna --}}
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">#</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Tanggal Daftar</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users->where('id', '!=', auth()->id()) as $user)
<tr class="text-center">
                <td class="border p-2">{{ $loop->iteration }}</td>
                <td class="border p-2">{{ $user->name }}</td>
                <td class="border p-2">{{ substr($user->email, 0, 3) . '***' }}</td>
                <td class="border p-2">
                    @if ($user->status == 'aktif')
<span class="bg-green-500 text-white px-2 py-1 rounded">Aktif</span>
@elseif($user->status == 'nonaktif')
<span class="bg-gray-500 text-white px-2 py-1 rounded">Nonaktif</span>
@else
<span class="bg-red-500 text-white px-2 py-1 rounded">Diblokir</span>
@endif
                </td>
                <td class="border p-2">{{ $user->created_at->format('d M Y') }}</td>
                <td class="border p-2 space-x-1">
                    {{-- Tombol Lihat Modal --}}
                    <button onclick="openModal('modal-{{ $user->id }}')" class="bg-blue-500 text-white px-2 py-1 rounded">Lihat</button>

                                    {{-- Blokir / Nonaktif / Aktif --}}
                @if ($user->status == 'aktif')
    <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded">Blokir</button>
                    </form>
                    <form action="{{ route('admin.users.nonaktif', $user->id) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button class="bg-gray-500 text-white px-2 py-1 rounded">Nonaktifkan</button>
                    </form>
@elseif($user->status == 'nonaktif' || $user->status == 'diblokir')
    <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button class="bg-green-500 text-white px-2 py-1 rounded">Aktifkan</button>
                    </form>
     @endif

                    {{-- Hapus --}}
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Hapus permanen pengguna ini?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </form>
                    </td>
                    </tr>

                    {{-- Modal Tailwind --}}
                    <div id="modal-{{ $user->id }}"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                    <div class="bg-white p-6 rounded shadow-lg w-96 relative">
                    <h3 class="text-xl font-bold mb-4">Detail Pengguna</h3>
                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($user->status) }}</p>
                    <p><strong>Tanggal Daftar:</strong>
                    {{ $user->created_at->format('d M Y H:i') }}</p>
                    <button onclick="closeModal('modal-{{ $user->id }}')"
                    class="absolute top-2 right-2 text-gray-700 font-bold text-2xl">&times;</button>
                    </div>
                    </div>
                @empty
                    <tr><td colspan="6" class="text-center">Tidak ada pengguna
                    ditemukan</td></tr>
                @endforelse
                </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                {{ $users->links() }}
                </div>
                </div>

                {{-- Script Modal --}}
                <script>
                    function openModal(id) {
                        const modal = document.getElementById(id);
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    }

                    function closeModal(id) {
                        const modal = document.getElementById(id);
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                    }
                </script>
            @endsection)
