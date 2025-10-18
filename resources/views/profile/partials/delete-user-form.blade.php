<section class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-gray-500 leading-relaxed">
            Once your account is deleted, all your data will be permanently removed.
            Please download any information you wish to keep before continuing.
        </p>
    </header>

    <!-- Delete Account Button -->
    <button type="button" onclick="openDeleteModal()"
        class="px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 active:bg-red-800 transition">
        <i class="fa-solid fa-trash-can mr-2"></i> Delete Account
    </button>

    <!-- === Custom Delete Confirmation Modal === -->
    <div id="deleteAccountModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-[9999]">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md relative">
            <button type="button" onclick="closeDeleteModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                Are you sure you want to delete your account?
            </h3>
            <p class="text-sm text-gray-600 mb-5">
                This action is <span class="font-semibold text-red-600">permanent</span> and cannot be undone.
                Please enter your password to confirm.
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="delete_password" name="password" type="password"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition outline-none placeholder-gray-400"
                        placeholder="Enter your password" required>
                    @error('password', 'userDeletion')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 active:bg-red-800 transition">
                        Confirm Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // === OPEN DELETE MODAL ===
    function openDeleteModal() {
        const modal = document.getElementById('deleteAccountModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    // === CLOSE DELETE MODAL ===
    function closeDeleteModal() {
        const modal = document.getElementById('deleteAccountModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }
</script>
