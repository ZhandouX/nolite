<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8 mb-8">
    {{-- PRODUK TERLARIS --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-8 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Produk Terlaris</h2>
                </div>
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <i data-lucide="trending-up" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-4">
            @forelse($produkTerlaris as $index => $produk)
                <div
                    class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group border border-transparent hover:border-gray-100 dark:hover:border-gray-600">
                    <div class="shrink-0 relative">
                        @if ($produk->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $produk->fotos->first()->foto) }}" alt="{{ $produk->nama_produk }}"
                                class="w-12 h-12 md:w-14 md:h-14 rounded-xl object-cover ring-2 ring-gray-100 dark:ring-gray-600 group-hover:ring-blue-200 dark:group-hover:ring-blue-400 transition-all">
                            <div
                                class="absolute -top-2 -left-2 w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-lg">
                                {{ $index + 1 }}
                            </div>
                        @else
                            <div
                                class="w-12 h-12 md:w-14 md:h-14 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-600 transition-colors">
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate mb-1">
                            {{ $produk->nama_produk }}
                        </p>
                        <div class="flex items-center gap-2">
                            <span
                                class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 px-2 py-0.5 rounded-full">
                                {{ $produk->total_terjual ?? 0 }} terjual
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data produk terlaris</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- USER TERBARU --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-8 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">User Terbaru</h2>
                </div>
                <div class="p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <i data-lucide="users" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-4">
            @forelse($usersTerbaru as $user)
                    <div
                        class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group border border-transparent hover:border-gray-100 dark:hover:border-gray-600">
                        <div class="shrink-0 relative">
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 
                                flex items-center justify-center text-white font-semibold text-lg 
                                group-hover:from-green-600 group-hover:to-emerald-700 transition-all">
                                {{ collect(explode(' ', $user->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->implode('') }}
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate mb-1">{{ $user->name }}</p>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-medium px-2 py-1 rounded-full 
                                                    {{ $user->status === '' ? 'bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400' :
                ($user->role === 'seller' ? 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' :
                    'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
            @empty
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data user terbaru</p>
                </div>
            @endforelse
        </div>
    </div>
</div>