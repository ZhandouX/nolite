<div class="p-6 space-y-6">
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="space-y-3">
            <label for="current_password" class="block text-sm font-semibold text-gray-900">
                Kata Sandi Saat Ini
            </label>
            <div class="relative">
                <input id="current_password" name="current_password" type="password" required
                    class="w-full px-4 py-3.5 rounded-xl border border-gray-300 bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/20 transition-all outline-none placeholder-gray-500 text-gray-900 pr-12"
                    placeholder="Masukkan kata sandi saat ini">
                <button type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 transition-colors"
                    onclick="togglePasswordVisibility('current_password', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <div class="flex items-center gap-2 text-sm text-red-600 mt-2 bg-red-50 px-3 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="space-y-3">
            <label for="password" class="block text-sm font-semibold text-gray-900">
                Kata Sandi Baru
            </label>
            <div class="relative">
                <input id="password" name="password" type="password" required
                    class="w-full px-4 py-3.5 rounded-xl border border-gray-300 bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/20 transition-all outline-none placeholder-gray-500 text-gray-900 pr-12"
                    placeholder="Masukkan kata sandi baru">
                <button type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 transition-colors"
                    onclick="togglePasswordVisibility('password', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>

            <!-- Password Strength -->
            <div class="mt-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Kekuatan kata sandi:</span>
                    <span id="password-strength-text" class="font-semibold">Sangat Lemah</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div id="password-strength-bar" class="h-2 rounded-full bg-red-500 transition-all duration-500"
                        style="width:0%"></div>
                </div>
            </div>

            @error('password', 'updatePassword')
                <div class="flex items-center gap-2 text-sm text-red-600 mt-2 bg-red-50 px-3 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-3">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-900">
                Konfirmasi Kata Sandi Baru
            </label>
            <div class="relative">
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full px-4 py-3.5 rounded-xl border border-gray-300 bg-white focus:border-gray-900 focus:ring-2 focus:ring-gray-900/20 transition-all outline-none placeholder-gray-500 text-gray-900 pr-12"
                    placeholder="Konfirmasi kata sandi baru">
                <button type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 transition-colors"
                    onclick="togglePasswordVisibility('password_confirmation', this)">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </div>

            <!-- Password Match Indicator -->
            <div id="password-match"
                class="hidden flex items-center gap-2 text-sm text-green-600 mt-2 bg-green-50 px-3 py-2 rounded-lg">
                <i class="fa-solid fa-circle-check"></i>
                <span>Kata Sandi cocok!</span>
            </div>

            @error('password_confirmation', 'updatePassword')
                <div class="flex items-center gap-2 text-sm text-red-600 mt-2 bg-red-50 px-3 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Requirements -->
        <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-shield-alt text-gray-700"></i>
                Kriteria Kata Sandi Aman
            </h3>
            <ul class="text-sm text-gray-600 space-y-2">
                <li id="req-length" class="flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-circle text-[4px]"></i>
                    Minimal 8 karakter
                </li>
                <li id="req-uppercase" class="flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-circle text-[4px]"></i>
                    Mengandung huruf kapital dan kecil
                </li>
                <li id="req-number" class="flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-circle text-[4px]"></i>
                    Mengandung angka dan karakter khusus
                </li>
            </ul>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit" id="submit-btn"
                class="px-6 py-3.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 active:scale-[0.98] transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <i class="fa-solid fa-key"></i>
                Perbarui Kata Sandi
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)"
                    class="flex items-center gap-2 text-sm text-green-600 font-semibold bg-green-50 px-3 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-check"></i> Kata Sandi berhasil diperbarui
                </p>
            @endif
        </div>
    </form>
</div>