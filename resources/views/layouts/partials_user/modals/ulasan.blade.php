{{-- MODAL ULASAN (DETAIL & EDIT) --}}
<div id="ulasanModal"
    class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 md:p-6">
    <div
        class="bg-white w-full max-w-2xl max-h-[90vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col border border-gray-200 animate-fadeIn">

        {{-- HEADER --}}
        <div
            class="bg-gradient-to-r from-red-900 via-red-800 to-red-700 text-white px-6 py-5 flex items-center justify-between">
            <h2 class="text-2xl font-bold" id="ulasanModalTitle">Detail Ulasan</h2>
            <button onclick="closeUlasanModal()"
                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/20 transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- BODY --}}
        <div class="flex-1 overflow-y-auto p-6">
            {{-- DETAIL ULASAN --}}
            <div id="ulasanDetailContent">
                {{-- Diisi oleh JavaScript --}}
            </div>

            {{-- FORM EDIT ULASAN --}}
            <div id="ulasanEditContent" class="hidden">
                <form id="editUlasanForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <select name="rating" class="w-full border rounded-lg p-2" required>
                            <option value="">Pilih Rating</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                        <textarea name="komentar" rows="3" class="w-full border rounded-lg p-2"
                            placeholder="Tulis ulasan Anda..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Ulasan Saat Ini</label>
                        <div id="currentPhotos" class="grid grid-cols-3 gap-2 mb-3">
                            {{-- Foto akan dimuat di sini --}}
                        </div>
                    </div>

                    {{-- FILE UPLOAD (EDIT FORM) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-800 mb-3">Tambah Foto Baru</label>

                        {{-- Upload Area --}}
                        <div id="uploadAreaEdit"
                            class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center transition-all duration-300 hover:border-red-400 hover:bg-red-50 cursor-pointer">
                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-3"></i>
                            <p class="text-sm font-medium text-gray-700 mb-1">Klik atau drag & drop foto di sini</p>
                            <p class="text-xs text-gray-500">Format: JPG, PNG, JPEG (Maks. 5MB per gambar)</p>

                            <input type="file" name="fotos[]" multiple accept="image/*" id="fileInputEdit"
                                class="hidden" onchange="previewImagesEdit(this)">
                        </div>

                        {{-- Image Previews --}}
                        <div id="imagePreviewsEdit" class="grid grid-cols-3 gap-3 mt-4 hidden"></div>

                        {{-- Upload Info --}}
                        <div id="uploadInfoEdit" class="flex items-center gap-2 mt-3 text-xs text-gray-500 hidden">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>Anda dapat mengupload maksimal 5 foto</span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="showUlasanDetail()"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Batal</button>
                        <button type="submit"
                            class="bg-red-900 text-white px-4 py-2 rounded-lg hover:bg-red-800 transition">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>