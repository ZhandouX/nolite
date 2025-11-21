@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-6">
    <div class="max-w-screen mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="shrink-0 h-12 w-12 rounded-tl-xl rounded-br-xl bg-primary-500 flex items-center justify-center shadow-sm">
                    <i data-lucide="messages-square" class="text-white text-lg"></i>
                </div>
                <div class="ml-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Manajemen Chat Pengguna
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Kelola Percakapan dan pesan dari pengguna
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Pencarian & Filter -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-8 transition-all duration-300">
            <form method="GET" action="{{ route('admin.chats.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-5">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200" 
                            placeholder="Cari nama pengguna..."
                        >
                    </div>
                </div>
                <div class="md:col-span-5">
                    <select 
                        name="filter" 
                        onchange="this.form.submit()" 
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                    >
                        <option value="">Semua Pengguna</option>
                        <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Yang Pernah Chat</option>
                        <option value="empty" {{ request('filter') == 'empty' ? 'selected' : '' }}>Belum Ada Pesan</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <button 
                        type="submit" 
                        class="w-full h-full bg-black dark:bg-primary-500 hover:bg-primary-600 text-white font-medium py-3 px-4 rounded-2xl transition-colors duration-200 flex items-center justify-center shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                    >
                        <i data-lucide="search" class="w-5 h-5 mr-2"></i>
                        <span class="text-sm font-semibold">Cari</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Konten Utama -->
        @if ($chats->isEmpty())
            <!-- State Kosong -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center transition-all duration-300">
                <div class="max-w-md mx-auto">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <i class="fa-solid fa-comment-slash text-blue-500 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        Tidak ada hasil yang cocok
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Tidak ada chat yang sesuai dengan pencarian atau filter yang dipilih.
                    </p>
                    <a 
                        href="{{ route('admin.chats.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200"
                    >
                        <i class="fa-solid fa-refresh mr-2"></i>
                        Reset Pencarian
                    </a>
                </div>
            </div>
        @else
            <!-- Daftar Chat -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-all duration-300">
                <!-- Header Tabel -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-blue-100 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid fa-users text-primary-500 mr-2"></i>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Daftar Pengguna Chat
                            </h4>
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $chats->count() }} hasil ditemukan
                        </span>
                    </div>
                </div>

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-800 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Nama Pengguna
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Pesan Terakhir
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Waktu
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-300 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($chats as $index => $chat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="shrink-0 h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                                <i class="fa-solid fa-user text-primary-600 dark:text-primary-400"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $chat->user->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    ID: {{ $chat->user->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($chat->lastMessage)
                                            <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate">
                                                {{ $chat->lastMessage->message }}
                                            </div>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                <i class="fa-solid fa-minus mr-1"></i>
                                                Belum ada pesan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        @if ($chat->lastMessage)
                                            <div class="flex items-center">
                                                <i class="fa-solid fa-clock mr-1.5 text-gray-400"></i>
                                                {{ $chat->lastMessage->created_at->diffForHumans() }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a 
                                                href="{{ route('admin.chats.show', $chat->id) }}" 
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800 transition-colors duration-200 shadow-sm"
                                            >
                                                <i class="fa-solid fa-eye mr-1.5"></i>
                                                Lihat
                                            </a>
                                            <form 
                                                action="{{ route('admin.chats.delete', $chat->id) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus semua chat dengan pengguna ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition-colors duration-200 shadow-sm"
                                                >
                                                    <i class="fa-solid fa-trash mr-1.5"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Tabel (Pagination) -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Menampilkan {{ $chats->count() }} dari {{ $chats->total() }} hasil
                        </div>
                        <!-- Jika menggunakan pagination -->
                        @if($chats->hasPages())
                        <div class="flex space-x-2">
                            @if($chats->onFirstPage())
                                <span class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-white dark:bg-gray-700 cursor-not-allowed">
                                    Sebelumnya
                                </span>
                            @else
                                <a href="{{ $chats->previousPageUrl() }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                    Sebelumnya
                                </a>
                            @endif

                            @if($chats->hasMorePages())
                                <a href="{{ $chats->nextPageUrl() }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-500 hover:bg-primary-600 transition-colors duration-200">
                                    Selanjutnya
                                </a>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-lg text-gray-400 dark:text-gray-500 bg-primary-300 dark:bg-primary-800 cursor-not-allowed">
                                    Selanjutnya
                                </span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    /* Animasi untuk transisi halus */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    // Tambahkan animasi fade-in untuk elemen yang baru dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
        elements.forEach((el, index) => {
            el.classList.add('fade-in');
        });
    });
</script>
@endsection