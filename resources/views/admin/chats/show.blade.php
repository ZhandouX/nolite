@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300 py-6">
        <div class="max-w-screen mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center">
                        <div
                            class="shrink-0 h-12 w-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-sm">
                            <i class="fa-solid fa-message text-white text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Chat dengan {{ $chat->user->name ?? 'Pengguna' }}
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Kelola percakapan dengan {{ $chat->user->name ?? 'Pengguna' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <!-- Tombol Hapus Seluruh Chat -->
                        <form action="{{ route('admin.chats.delete', $chat->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus seluruh chat dengan pengguna ini?')"
                            class="sm:order-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-trash mr-2"></i>
                                Hapus Chat
                            </button>
                        </form>

                        <!-- Tombol Kembali -->
                        <a href="{{ route('admin.chats.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Container Utama Chat -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-all duration-300">
                <!-- Header Chat -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="shrink-0 h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                <i class="fa-solid fa-user text-primary-600 dark:text-primary-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $chat->user->name ?? 'Pengguna' }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $messages->count() }} pesan dalam percakapan
                                </p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ $messages->first() ? $messages->first()->created_at->diffForHumans() : 'Baru saja' }}
                        </div>
                    </div>
                </div>

                <!-- Daftar Pesan -->
                <div class="h-96 overflow-y-auto p-6 bg-gray-50 dark:bg-gray-900/30">
                    @forelse ($messages as $msg)
                        <div
                            class="mb-6 last:mb-0 group hover:bg-gray-100 dark:hover:bg-gray-800/50 rounded-lg p-3 transition-colors duration-150">
                            <!-- Header Pesan -->
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-2">
                                    @if ($msg->sender_id === auth()->id())
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200">
                                            <i class="fa-solid fa-user-shield mr-1"></i>
                                            Admin
                                        </span>
                                    @elseif ($msg->sender_id)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            <i class="fa-solid fa-user mr-1"></i>
                                            {{ $msg->sender->name }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                            <i class="fa-solid fa-robot mr-1"></i>
                                            Bot (AI)
                                        </span>
                                    @endif
                                </div>

                                <!-- Tombol Hapus Pesan (muncul pada hover) -->
                                <form action="{{ route('admin.chats.message.delete', $msg->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus pesan ini?')"
                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center p-1.5 text-red-500 hover:text-red-700 dark:hover:text-red-400 bg-white dark:bg-gray-700 rounded-full shadow-sm border border-gray-200 dark:border-gray-600 transition-colors duration-150"
                                        title="Hapus pesan">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Konten Pesan -->
                            <div class="pl-1">
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $msg->message }}</p>
                                </div>

                                <!-- Waktu Pesan -->
                                <div class="flex items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fa-solid fa-clock mr-1.5"></i>
                                    {{ $msg->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- State Kosong -->
                        <div class="text-center py-12">
                            <div
                                class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <i class="fa-solid fa-comment-slash text-gray-400 dark:text-gray-500 text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                Belum ada pesan
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                                Mulai percakapan dengan mengirim pesan pertama kepada pengguna.
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Form Kirim Pesan -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
                    <form method="POST" action="{{ route('admin.chats.send', $chat->id) }}">
                        @csrf
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <input type="text" name="message"
                                    class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200 shadow-sm"
                                    placeholder="Ketik pesan Anda di sini..." required autocomplete="off">
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fa-solid fa-paper-plane mr-2"></i>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Statistik Chat -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-all duration-300">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fa-solid fa-chart-bar text-primary-500 mr-2"></i>
                        Statistik Chat
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Total Pesan</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $messages->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Pesan Admin</span>
                            <span class="font-medium text-primary-600 dark:text-primary-400">
                                {{ $messages->where('sender_id', auth()->id())->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Pesan Pengguna</span>
                            <span class="font-medium text-green-600 dark:text-green-400">
                                {{ $messages->where('sender_id', '!=', auth()->id())->where('sender_id', '!=', null)->count() }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Pesan Bot</span>
                            <span class="font-medium text-purple-600 dark:text-purple-400">
                                {{ $messages->where('sender_id', null)->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pengguna -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 transition-all duration-300">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fa-solid fa-user text-primary-500 mr-2"></i>
                        Informasi Pengguna
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Nama</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $chat->user->name ?? 'Tidak diketahui' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Email</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white">{{ $chat->user->email ?? 'Tidak diketahui' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">ID Pengguna</span>
                            <span
                                class="font-mono text-sm text-gray-500 dark:text-gray-400">{{ $chat->user->id ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 dark:text-gray-400">Bergabung</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $chat->user->created_at ? $chat->user->created_at->diffForHumans() : '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animasi untuk transisi halus */
        /* .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .slide-in-up {
            animation: slideInUp 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        } */

        /* Custom scrollbar untuk area chat */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animasi untuk elemen yang baru dimuat
            const elements = document.querySelectorAll('.bg-white, .bg-gray-50');
            elements.forEach((el, index) => {
                el.classList.add('fade-in');
                el.style.animationDelay = `${index * 0.1}s`;
            });

            // Auto scroll ke bagian bawah chat
            const chatContainer = document.querySelector('.overflow-y-auto');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            // Tambahkan class untuk custom scrollbar
            if (chatContainer) {
                chatContainer.classList.add('custom-scrollbar');
            }

            // Focus pada input pesan saat halaman dimuat
            const messageInput = document.querySelector('input[name="message"]');
            if (messageInput) {
                messageInput.focus();
            }
        });
    </script>
@endsection