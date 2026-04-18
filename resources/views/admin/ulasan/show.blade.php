@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Detail Ulasan</h1>

    <div class="bg-white shadow rounded p-5">

        {{-- INFORMASI USER --}}
        <h2 class="font-semibold text-lg mb-2">Informasi User</h2>
        <p><strong>Nama:</strong> {{ $ulasan->user->name }}</p>
        <p><strong>Email:</strong> {{ $ulasan->user->email }}</p>

        <hr class="my-4">

        {{-- INFORMASI PRODUK --}}
        <h2 class="font-semibold text-lg mb-2">Informasi Produk</h2>
        <p><strong>Nama Produk:</strong> {{ $ulasan->produk->nama_produk }}</p>

        @if($ulasan->produk->foto)
            <img src="{{ asset('storage/' . $ulasan->produk->foto) }}"
                 class="w-32 h-32 object-cover rounded border my-2">
        @endif

        <hr class="my-4">

        {{-- ULASAN USER --}}
        <h2 class="font-semibold text-lg mb-2">Ulasan Pengguna</h2>

        <p><strong>Rating:</strong>
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $ulasan->rating)
                    ⭐
                @else
                    ☆
                @endif
            @endfor
        </p>

        <p class="mt-2"><strong>Komentar:</strong> {{ $ulasan->komentar ?? '-' }}</p>

        {{-- Foto ulasan --}}
        @if($ulasan->fotos->count() > 0)
            <h4 class="font-semibold mt-3 mb-2">Foto Ulasan:</h4>

            <div class="flex gap-3">
                @foreach($ulasan->fotos as $foto)
                    <img src="{{ asset('storage/' . $foto->foto) }}"
                         class="w-24 h-24 object-cover rounded border cursor-pointer"
                         onclick="openPreview('{{ asset('storage/' . $foto->foto) }}')">
                @endforeach
            </div>
        @endif

        <hr class="my-4">

        {{-- BALASAN ADMIN --}}
        <h2 class="font-semibold text-lg mb-2">Balasan Admin</h2>

        @if($ulasan->admin_reply)
            <div class="p-3 bg-blue-50 border-l-4 border-blue-400 rounded">
                {!! nl2br(e($ulasan->admin_reply)) !!}
            </div>
        @else
            <form action="{{ route('admin.ulasan.reply', $ulasan->id) }}" method="POST" class="mt-3">
                @csrf
                <label class="font-medium mb-1">Tulis Balasan</label>
                <textarea name="admin_reply" class="w-full border rounded p-2" rows="4" required></textarea>

                <button class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Kirim Balasan
                </button>
            </form>
        @endif

    </div>

</div>

{{-- Modal Preview --}}
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

