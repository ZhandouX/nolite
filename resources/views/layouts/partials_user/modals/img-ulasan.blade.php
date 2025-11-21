<div id="reviewModal"
    class="fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center z-[9999] hidden animate-fade-in">
    <div
        class="modal-container bg-white rounded-2xl shadow-2xl overflow-hidden max-w-6xl mx-4 w-full max-h-3xl h-full animate-scale-in">
        {{-- CLOSE BUTTON --}}
        <button id="closeModal"
            class="absolute top-4 right-4 lg:top-4 lg:right-12 z-20 bg-white/90 hover:bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col lg:flex-row h-full">
            {{-- MAIN IMAGE AREA --}}
            <div
                class="lg:w-2/3 relative bg-gradient-to-br from-gray-900 to-black flex items-center justify-center min-h-[70vh] lg:min-h-auto">
                <div class="relative w-full h-full flex items-center justify-center p-6">
                    <img id="modalReviewImage" src="" class="h-full w-full object-contain rounded-lg"
                        alt="Review photo">

                    {{-- IMAGE OVERLAY INFO --}}
                    <div
                        class="absolute top-0 left-0 right-0 bg-gradient-to-b from-black/80 via-black/40 to-transparent p-6 text-white">
                        <div class="flex items-center gap-4">
                            <div id="modalUserInitial"
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold shadow-lg">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p id="modalUserName" class="font-semibold text-base truncate"></p>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    <p id="modalVariant" class="text-sm opacity-90 bg-white/20 px-2 py-1 rounded-full">
                                    </p>
                                    <span class="opacity-70">•</span>
                                    <p id="modalDate" class="text-sm opacity-75"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- IMAGE OVERLAY COMMENT --}}
                    <div
                        class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-6 text-white">
                        <p id="modalComment"
                            class="text-base leading-relaxed line-clamp-3 backdrop-blur-sm bg-black/20 p-3 rounded-lg">
                        </p>
                    </div>
                </div>
            </div>

            {{-- THUMBNAILS & ADDITIONAL INFO AREA --}}
            <div
                class="lg:w-1/3 bg-gradient-to-b from-gray-50 to-white p-6 flex flex-col h-auto lg:max-h-[80vh] overflow-y-auto custom-scrollbar">
                <h3 class="font-bold text-gray-900 text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4v16M4 9h16" />
                    </svg>
                    Foto Lainnya
                </h3>

                <div id="modalThumbnails" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-3 gap-3 mb-6">
                    {{-- Thumbnails will be populated by JavaScript --}}
                </div>

                {{-- RATING & DETAILS INFO --}}
                <div class="mt-auto pt-6 border-t border-gray-200/60">
                    <div class="flex items-center mb-4">
                        <div id="modalRating" class="flex mr-3">
                            {{-- Rating stars will be populated by JavaScript --}}
                        </div>
                        <span id="modalRatingText"
                            class="text-sm font-medium text-gray-700 bg-gray-100 px-3 py-1 rounded-full"></span>
                    </div>

                    <div
                        class="bg-white rounded-xl p-4 border border-gray-200/60 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <p id="modalFullComment" class="text-gray-700 text-sm leading-relaxed"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>