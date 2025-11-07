@extends('layouts.admin_app')

@section('content')

<div class="container py-5">
    <h3 class="mb-4">
        <i class="fa-solid fa-comments"></i> Manajemen Chat Pengguna
    </h3>

```
{{-- Form pencarian & filter --}}
<form method="GET" action="{{ route('admin.chats.index') }}" class="row g-2 mb-4">
    <div class="col-md-6">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
            placeholder="Cari nama pengguna...">
    </div>
    <div class="col-md-4">
        <select name="filter" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Pengguna</option>
            <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Yang Pernah Chat</option>
            <option value="empty" {{ request('filter') == 'empty' ? 'selected' : '' }}>Belum Ada Pesan</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fa-solid fa-search"></i> Cari
        </button>
    </div>
</form>

{{-- Jika tidak ada chat sama sekali --}}
@if ($chats->isEmpty())
    <div class="alert alert-info text-center">
        <i class="fa-solid fa-info-circle"></i> Tidak ada hasil yang cocok dengan pencarian atau filter.
    </div>
@else
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <strong><i class="fa-solid fa-users"></i> Daftar Pengguna Chat</strong>
        </div>
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Pesan Terakhir</th>
                        <th>Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chats as $index => $chat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><i class="fa-solid fa-user text-primary"></i> {{ $chat->user->name }}</td>
                            <td>
                                @if ($chat->lastMessage)
                                    {{ Str::limit($chat->lastMessage->message, 50) }}
                                @else
                                    <em class="text-muted">Belum ada pesan</em>
                                @endif
                            </td>
                            <td>
                                @if ($chat->lastMessage)
                                    <small class="text-muted">{{ $chat->lastMessage->created_at->diffForHumans() }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.chats.show', $chat->id) }}"
                                   class="btn btn-sm btn-primary me-1">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>
                                <form action="{{ route('admin.chats.delete', $chat->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus semua chat dengan pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
```

</div>
@endsection
