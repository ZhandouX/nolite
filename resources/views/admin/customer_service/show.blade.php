@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Percakapan dengan {{ $user->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola percakapan customer service</p>
                </div>
                <a href="{{ route('admin.customer-service.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 text-gray-700 dark:text-gray-300 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>

            @if(session('success'))
                <div
                    class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Message History -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Riwayat Percakapan
                            </h2>
                        </div>
                        <div class="p-6 space-y-4 max-h-96 overflow-y-auto">
                            @forelse($messages as $msg)
                                                <div class="flex space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                                            {{ substr($msg->user->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl px-4 py-3">
                                                            <p class="text-gray-800 dark:text-gray-200 text-sm">{{ $msg->message }}</p>
                                                        </div>
                                                        @if($msg->reply)
                                                            <div
                                                                class="ml-8 mt-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl px-4 py-3">
                                                                <p class="text-blue-800 dark:text-blue-300 text-sm">
                                                                    <span class="font-semibold">Admin:</span> {{ $msg->reply }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                        <div class="flex items-center mt-2 text-xs text-gray-500 dark:text-gray-400 space-x-3">
                                                            <span class="inline-flex items-center">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                {{ $msg->created_at->diffForHumans() }}
                                                            </span>
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                                        {{ $msg->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                                ($msg->status === 'read' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' :
                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400') }}">
                                                                {{ ucfirst($msg->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <p>Belum ada pesan dalam percakapan ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Reply Form -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                                Balas Pesan
                            </h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.customer-service.reply', $messages->last()->id ?? null) }}"
                                method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="reply"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Pesan Balasan
                                        </label>
                                        <textarea name="reply" id="reply" rows="4" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-colors duration-200"
                                            placeholder="Tulis balasan untuk {{ $user->name }}..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Kirim Balasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - User Controls -->
                <div class="space-y-6">
                    <!-- User Status Control -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Status Akun
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center space-x-3 mb-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-600 to-gray-800 flex items-center justify-center text-white font-semibold text-lg">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="mb-6">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Status Akun:</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $user->status === 'aktif' ?
        'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
        'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>

                            <div class="space-y-3">
                                <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="w-full">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Aktifkan Akun
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.nonaktif', $user->id) }}" method="POST" class="w-full">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Nonaktifkan Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- User Info Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Informasi Pengguna</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Bergabung:</span>
                                    <span
                                        class="text-gray-900 dark:text-white font-medium">{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Total Pesan:</span>
                                    <span class="text-gray-900 dark:text-white font-medium">{{ $messages->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Pesan Tertanggapi:</span>
                                    <span
                                        class="text-gray-900 dark:text-white font-medium">{{ $messages->whereNotNull('reply')->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection