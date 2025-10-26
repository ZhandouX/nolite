<div id="modalImage" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50 p-4">
    <div class="relative w-full max-w-4xl bg-white rounded-2xl overflow-hidden">
        <button onclick="closeModal('modalImage')"
            class="absolute top-2 right-2 text-white text-3xl z-20">&times;</button>

        {{-- LARGE IMAGE --}}
        <div class="relative">
            <img id="modalImgContent" src="" alt="Full Image"
                class="w-full max-h-[600px] object-contain transition-all duration-300" />

            {{-- PREV --}}
            <button id="prevImage"
                class="absolute top-1/2 left-2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                &#10094;
            </button>

            {{-- NEXT --}}
            <button id="nextImage"
                class="absolute top-1/2 right-2 -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                &#10095;
            </button>
        </div>

        {{-- THUMBNAIL LIST --}}
        <div class="flex justify-center gap-2 p-4 overflow-x-auto">
            @foreach($produk->fotos as $key => $foto)
                <img src="{{ asset('storage/' . $foto->foto) }}"
                    class="modal-thumb w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-200 hover:border-blue-600 transition-all"
                    data-index="{{ $key }}">
            @endforeach
        </div>
    </div>
</div>