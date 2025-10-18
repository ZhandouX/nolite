<section class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-lock text-yellow-600"></i>
            Update Password
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Ensure your account uses a strong and secure password.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                Current Password
            </label>
            <input id="current_password" name="current_password" type="password"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all outline-none placeholder-gray-400"
                   autocomplete="current-password" placeholder="Enter your current password">
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                New Password
            </label>
            <input id="password" name="password" type="password"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all outline-none placeholder-gray-400"
                   autocomplete="new-password" placeholder="Enter your new password">
            @error('password', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Confirm Password
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all outline-none placeholder-gray-400"
                   autocomplete="new-password" placeholder="Re-enter your new password">
            @error('password_confirmation', 'updatePassword')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-5 py-2.5 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 active:bg-yellow-800 transition">
                Save Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm text-green-600 font-medium">
                    <i class="fa-solid fa-circle-check mr-1"></i> Password updated successfully
                </p>
            @endif
        </div>
    </form>
</section>
