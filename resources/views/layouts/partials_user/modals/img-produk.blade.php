<div id="productImageModal"
    class="fixed inset-0 bg-black/90 backdrop-blur-lg flex items-center justify-center z-[9999] hidden animate-fade-in">
    <div class="relative w-full max-w-6xl mx-4 lg:mx-8">
        {{-- CLOSE BUTTON --}}
        <button onclick="closeProductModal()"
            class="absolute -top-12 right-0 lg:top-6 lg:right-6 z-50 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-full w-12 h-12 flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 group">
            <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- MAIN IMAGE CONTAINER --}}
        <div class="relative flex justify-center items-center bg-transparent rounded-2xl overflow-hidden">
            <img id="modalProductImage" src="" alt="Full Product Image"
                class="max-h-[60vh] lg:max-h-[75vh] w-auto rounded-lg object-contain transition-all duration-500 ease-out transform scale-95 hover:scale-100" />

            {{-- NAVIGATION BUTTONS --}}
            <button id="prevProductImage"
                class="absolute left-4 lg:left-6 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 backdrop-blur-md text-white p-3 lg:p-4 rounded-full transition-all duration-300 hover:scale-110 hover:-translate-x-1 group">
                <svg class="w-5 h-5 lg:w-6 lg:h-6 group-hover:-translate-x-0.5 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button id="nextProductImage"
                class="absolute right-4 lg:right-6 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 backdrop-blur-md text-white p-3 lg:p-4 rounded-full transition-all duration-300 hover:scale-110 hover:translate-x-1 group">
                <svg class="w-5 h-5 lg:w-6 lg:h-6 group-hover:translate-x-0.5 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- IMAGE COUNTER --}}
            <div
                class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/60 backdrop-blur-md text-white px-4 py-2 rounded-full text-sm font-medium">
                <span id="currentImageIndex">1</span> / <span id="totalImages">{{ count($produk->fotos) }}</span>
            </div>
        </div>

        {{-- THUMBNAIL GALLERY --}}
        <div class="flex justify-center gap-3 mt-2 lg:mt-2 pb-1 overflow-x-auto custom-scrollbar px-4">
            @foreach($produk->fotos as $key => $foto)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $foto->foto) }}"
                        class="product-modal-thumb w-16 h-16 lg:w-16 lg:h-16 object-cover rounded-xl cursor-pointer border-2 border-transparent hover:border-white/60 group-hover:scale-105 transition-all duration-300 shadow-lg"
                        data-index="{{ $key }}">
                    <div
                        class="absolute inset-0 rounded-xl bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ZOOM CONTROLS (Optional) --}}
        <div class="flex justify-center gap-3 mt-2">
            <button id="zoomOut"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
            </button>
            <button id="resetZoom"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300 text-xs font-medium">
                100%
            </button>
            <button id="zoomIn"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
        </div>
    </div>
</div>