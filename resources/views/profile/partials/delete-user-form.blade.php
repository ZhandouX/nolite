<form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4">
    @csrf
    @method('delete')

    <div>
        <label for="delete_password" class="block text-sm font-semibold text-gray-900 mb-2">
            Konfirmasi Password
        </label>
        <input id="delete_password" name="password" type="password" required
            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all outline-none placeholder-gray-500 text-gray-900"
            placeholder="Masukkan password untuk konfirmasi">
        @error('password', 'userDeletion')
            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-3 pt-4">
        <button type="button" onclick="closeDeleteModal()"
            class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
            Batal
        </button>
        <button type="submit"
            class="flex-1 px-4 py-3 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 active:bg-red-800 transition-colors">
            Hapus Akun
        </button>
    </div>
</form>