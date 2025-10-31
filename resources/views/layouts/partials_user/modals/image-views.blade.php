<!-- ======================== MODAL IMAGE (E-COMMERCE STYLE) ======================== -->
<div id="modalImage"
    class="fixed inset-0 bg-black bg-opacity-90 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4 transition-all duration-300">
    <div class="relative w-full max-w-5xl rounded-2xl overflow-hidden flex flex-col bg-transparent">
        <!-- CLOSE BUTTON -->
        <button onclick="closeModal('modalImage')"
            class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300 transition z-50">
            &times;
        </button>

        <!-- LARGE IMAGE -->
        <div class="relative flex justify-center items-center bg-transparent rounded-2xl overflow-hidden">
            <img id="modalImgContent" src="" alt="Full Image"
                class="max-h-[80vh] object-contain transition-all duration-500 ease-in-out scale-100" />

            <!-- PREV -->
            <button id="prevImage"
                class="absolute left-5 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-3 rounded-full transition duration-300">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </button>

            <!-- NEXT -->
            <button id="nextImage"
                class="absolute right-5 top-1/2 -translate-y-1/2 bg-black bg-opacity-40 hover:bg-opacity-70 text-white p-3 rounded-full transition duration-300">
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- THUMBNAIL LIST -->
        <div
            class="flex justify-center gap-3 mt-6 pb-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-transparent">
            @foreach($produk->fotos as $key => $foto)
                <img src="{{ asset('storage/' . $foto->foto) }}"
                    class="modal-thumb w-24 h-24 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-blue-500 transition-all duration-300"
                    data-index="{{ $key }}">
            @endforeach
        </div>
    </div>
</div>

<!-- ======================== STYLING & SCRIPT ======================== -->
<style>
    /* Scrollbar halus untuk thumbnail */
    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    /* Efek zoom lembut */
    #modalImgContent.zoom {
        transform: scale(1.05);
    }

    /* Thumbnail aktif */
    .modal-thumb.active {
        border-color: #3b82f6;
        /* biru Tailwind */
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();

        const modal = document.getElementById('modalImage');
        const modalImg = document.getElementById('modalImgContent');
        const thumbs = document.querySelectorAll('.modal-thumb');
        const prevBtn = document.getElementById('prevImage');
        const nextBtn = document.getElementById('nextImage');
        let currentIndex = 0;

        // Tampilkan gambar di modal
        thumbs.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
                currentIndex = index;
                updateModalImage();
                modal.classList.remove('hidden');
                modalImg.classList.add('zoom');
                setTimeout(() => modalImg.classList.remove('zoom'), 300);
            });
        });

        // Fungsi update gambar utama
        function updateModalImage() {
            const activeThumb = thumbs[currentIndex];
            modalImg.src = activeThumb.src;

            thumbs.forEach(t => t.classList.remove('active'));
            activeThumb.classList.add('active');
        }

        // Navigasi next/prev
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + thumbs.length) % thumbs.length;
            updateModalImage();
            modalImg.classList.add('zoom');
            setTimeout(() => modalImg.classList.remove('zoom'), 300);
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % thumbs.length;
            updateModalImage();
            modalImg.classList.add('zoom');
            setTimeout(() => modalImg.classList.remove('zoom'), 300);
        });

        // Klik area luar menutup modal
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal('modalImage');
        });
    });
</script>