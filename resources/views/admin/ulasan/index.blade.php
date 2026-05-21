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
                            <td class="px-6 py-4">
                                @if ($ulasan->fotos->isNotEmpty())
                                    <div class="flex -space-x-2">

                                        @foreach ($ulasan->fotos->take(3) as $index => $foto)
                                            <img src="{{ asset('storage/' . $foto->foto) }}"
                                                onclick="openPreview('{{ asset('storage/' . $foto->foto) }}')"
                                                class="w-10 h-10 rounded-lg border-2 border-white dark:border-gray-800
                                                    object-cover shadow-sm cursor-pointer
                                                    hover:z-10 hover:scale-110 transition-transform duration-200"
                                                alt="Foto {{ $index + 1 }}"
                                                title="Foto Ulasan">
                                        @endforeach

                                        @if ($ulasan->fotos->count() > 3)
                                            <div
                                                class="w-10 h-10 rounded-lg bg-orange-500 border-2 border-white dark:border-gray-800
                                                    flex items-center justify-center text-xs font-medium text-white shadow-sm">
                                                +{{ $ulasan->fotos->count() - 3 }}
                                            </div>
                                        @endif

                                    </div>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                        <i class="fa-solid fa-image mr-1"></i>
                                        Tidak ada foto
                                    </span>
                                @endif
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

                            <td class="p-3 relative">
    <div class="relative inline-block text-left">

        {{-- Button Dropdown --}}
        <button onclick="toggleDropdown({{ $ulasan->id }})"
            class="inline-flex items-center px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-md hover:bg-gray-800 transition">
            Aksi
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M19 9l-7 7-7-7">
                </path>
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div id="dropdown-{{ $ulasan->id }}"
            class="hidden absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg z-50">

            {{-- Detail --}}
            <a href="{{ route('admin.ulasan.show', $ulasan->id) }}"
                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i data-lucide="eye" class="w-4 h-4 mr-2"></i>
                Lihat Detail
            </a>

            {{-- Hapus --}}
            <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>
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

    <script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(`dropdown-${id}`);

        // tutup semua dropdown lain
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            if (el.id !== `dropdown-${id}`) {
                el.classList.add('hidden');
            }
        });

        dropdown.classList.toggle('hidden');
    }

    // klik luar dropdown = tutup
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                el.classList.add('hidden');
            });
        }
    });
</script>

@endsection
