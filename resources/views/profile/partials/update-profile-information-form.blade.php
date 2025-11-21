<div class="p-6 space-y-6">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="space-y-3">
            <label for="name" class="block text-sm font-semibold text-gray-900">
                Nama Lengkap
            </label>
            <div class="relative">
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-3.5 rounded-xl border border-gray-300 bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/20 transition-all outline-none placeholder-gray-500 text-gray-900"
                    placeholder="Masukkan nama lengkap">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fa-solid fa-circle-check text-green-500 opacity-0 transition-opacity duration-300"
                        id="name-check"></i>
                </div>
            </div>
            @error('name')
                <div class="flex items-center gap-2 text-sm text-red-600 mt-2 bg-red-50 px-3 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="space-y-3">
            <label for="email" class="block text-sm font-semibold text-gray-900">
                Alamat Email
            </label>
            <div class="relative">
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-3.5 rounded-xl border border-gray-300 bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/20 transition-all outline-none placeholder-gray-500 text-gray-900"
                    placeholder="Masukkan alamat email">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fa-solid fa-circle-check text-green-500 opacity-0 transition-opacity duration-300"
                        id="email-check"></i>
                </div>
            </div>
            @error('email')
                <div class="flex items-center gap-2 text-sm text-red-600 mt-2 bg-red-50 px-3 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 text-lg"></i>
                        <div>
                            <p class="font-semibold">Email Anda belum terverifikasi</p>
                            <button form="send-verification"
                                class="mt-2 text-gray-900 hover:text-gray-700 transition font-medium flex items-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i>
                                Kirim ulang email verifikasi
                            </button>

                            @if (session('status') === 'verification-link-sent')
                                <div class="mt-2 flex items-center gap-2 text-green-600 font-medium">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Link verifikasi baru telah dikirim ke email Anda
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-6 py-3.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 active:scale-[0.98] transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                <i class="fa-regular fa-floppy-disk"></i>
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)"
                    class="flex items-center gap-2 text-sm text-green-600 font-semibold bg-green-50 px-3 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-check"></i> Berhasil disimpan
                </p>
            @endif
        </div>
    </form>
</div>