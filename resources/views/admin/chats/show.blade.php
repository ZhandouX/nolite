@extends('layouts.admin_app')

@section('content')
    <div class="container py-5">

        ```
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">
                <i class="fa-solid fa-message"></i> Chat dengan {{ $chat->user->name ?? 'Pengguna' }}
            </h3>

            <div class="d-flex gap-2">
                {{-- Tombol hapus seluruh chat --}}
                <form action="{{ route('admin.chats.delete', $chat->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus seluruh chat dengan pengguna ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Hapus Chat
                    </button>
                </form>

                {{-- Tombol kembali --}}
                <a href="{{ route('admin.chats.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Daftar pesan --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                @forelse ($messages as $msg)
                    <div class="mb-3 pb-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>
                                @if ($msg->sender_id === auth()->id())
                                    Admin
                                @elseif ($msg->sender_id)
                                    {{ $msg->sender->name }}
                                @else
                                    Bot (AI)
                                @endif
                            </strong>
                        </div>

                        <p class="bg-light p-2 rounded mt-1 mb-1">{{ $msg->message }}</p>

                        {{-- Waktu & Tombol hapus kecil di samping --}}
                        <div class="d-flex align-items-center" style="gap: 4px;">
                            <small class="text-muted mb-0" style="font-size: 0.8rem;">
                                {{ $msg->created_at->diffForHumans() }}
                            </small>
                            <form action="{{ route('admin.chats.message.delete', $msg->id) }}" method="POST"
                                onsubmit="return confirm('Hapus pesan ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0 m-0"
                                    style="font-size: 0.75rem; line-height: 0.8; transform: translateY(-1px);"
                                    title="Hapus pesan">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <p class="text-muted text-center">Belum ada pesan.</p>
                @endforelse
            </div>
        </div>

        {{-- Form kirim pesan --}}
        <form method="POST" action="{{ route('admin.chats.send', $chat->id) }}">
            @csrf
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane"></i> Kirim
                </button>
            </div>
        </form>
        ```

    </div>
@endsection
