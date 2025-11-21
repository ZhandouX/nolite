        document.addEventListener('DOMContentLoaded', () => {

        // Fungsi membuka modal ulasan
        window.openReviewModal = function (reviewId, photoIndex = 0) {
            const data = window.reviewData[reviewId];
            if (!data) return;

            const modal = document.getElementById('reviewModal');
            const modalImage = document.getElementById('modalReviewImage');
            const modalUserInitial = document.getElementById('modalUserInitial');
            const modalUserName = document.getElementById('modalUserName');
            const modalVariant = document.getElementById('modalVariant');
            const modalDate = document.getElementById('modalDate');
            const modalComment = document.getElementById('modalComment');
            const modalFullComment = document.getElementById('modalFullComment');
            const modalRating = document.getElementById('modalRating');
            const modalRatingText = document.getElementById('modalRatingText');
            const modalThumbnails = document.getElementById('modalThumbnails');

            // Set data utama
            modalImage.src = data.photos[photoIndex];
            modalUserInitial.textContent = data.userInitial;
            modalUserName.textContent = data.userName;
            modalVariant.textContent = data.variant;
            modalDate.textContent = data.date;
            modalComment.textContent = data.comment;
            modalFullComment.textContent = data.comment;

            // Set rating
            modalRating.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('div');
                star.className = `w-4 h-4 ${i <= data.rating ? 'text-yellow-400' : 'text-gray-300'}`;
                star.innerHTML = `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>`;
                modalRating.appendChild(star);
            }
            modalRatingText.textContent = `${data.rating}/5`;

            // Set thumbnails
            modalThumbnails.innerHTML = '';
            data.photos.forEach((photo, index) => {
                const thumb = document.createElement('div');
                thumb.className = `relative cursor-pointer border-2 rounded ${index === photoIndex ? 'border-blue-500' : 'border-transparent'}`;
                thumb.onclick = () => openReviewModal(reviewId, index);

                const img = document.createElement('img');
                img.src = photo;
                img.className = 'w-full h-24 max-w-26 object-cover rounded';
                img.alt = `Review photo ${index + 1}`;

                thumb.appendChild(img);
                modalThumbnails.appendChild(thumb);
            });

            // Tampilkan modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Tutup modal
        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('reviewModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        document.getElementById('reviewModal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.getElementById('reviewModal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
                                                                                                                            });

        // Zoom functionality for product image modal
        document.addEventListener('DOMContentLoaded', function () {
            let currentScale = 1;
            const minScale = 1;
            const maxScale = 3;
            const scaleStep = 0.2;

            const modalImage = document.getElementById('modalProductImage');
            const zoomInBtn = document.getElementById('zoomIn');
            const zoomOutBtn = document.getElementById('zoomOut');
            const resetZoomBtn = document.getElementById('resetZoom');

            // Initialize zoom state
            function initializeZoom() {
                currentScale = 1;
                modalImage.style.transform = 'scale(1)';
                modalImage.style.cursor = 'default';
                updateZoomButtons();
            }

            // Zoom in function
            function zoomIn() {
                if (currentScale < maxScale) {
                    currentScale += scaleStep;
                    applyZoom();
                }
            }

            // Zoom out function
            function zoomOut() {
                if (currentScale > minScale) {
                    currentScale -= scaleStep;
                    applyZoom();
                }
            }

            // Apply zoom transformation
            function applyZoom() {
                modalImage.style.transform = `scale(${currentScale})`;
                modalImage.style.cursor = currentScale > 1 ? 'grab' : 'default';
                updateZoomButtons();

                // Add panning functionality when zoomed
                if (currentScale > 1) {
                    enablePanning();
                } else {
                    disablePanning();
                }
            }

            // Update zoom buttons state
            function updateZoomButtons() {
                zoomInBtn.disabled = currentScale >= maxScale;
                zoomOutBtn.disabled = currentScale <= minScale;

                // Visual feedback for disabled state
                zoomInBtn.style.opacity = zoomInBtn.disabled ? '0.5' : '1';
                zoomOutBtn.style.opacity = zoomOutBtn.disabled ? '0.5' : '1';
                resetZoomBtn.textContent = `${Math.round(currentScale * 100)}%`;

                // Add/remove hover effects based on state
                if (zoomInBtn.disabled) {
                    zoomInBtn.classList.remove('hover:bg-white/20');
                } else {
                    zoomInBtn.classList.add('hover:bg-white/20');
                }

                if (zoomOutBtn.disabled) {
                    zoomOutBtn.classList.remove('hover:bg-white/20');
                } else {
                    zoomOutBtn.classList.add('hover:bg-white/20');
                }
            }

            // Panning functionality
            let isPanning = false;
            let startX, startY;
            let translateX = 0, translateY = 0;

            function enablePanning() {
                modalImage.addEventListener('mousedown', startPan);
                modalImage.addEventListener('touchstart', startPanTouch);
            }

            function disablePanning() {
                modalImage.removeEventListener('mousedown', startPan);
                modalImage.removeEventListener('touchstart', startPanTouch);
                modalImage.style.cursor = 'default';
                translateX = 0;
                translateY = 0;
                modalImage.style.transform = `scale(${currentScale})`;
            }

            function startPan(e) {
                if (currentScale <= 1) return;

                isPanning = true;
                startX = e.clientX - translateX;
                startY = e.clientY - translateY;
                modalImage.style.cursor = 'grabbing';

                document.addEventListener('mousemove', pan);
                document.addEventListener('mouseup', stopPan);
            }

            function startPanTouch(e) {
                if (currentScale <= 1) return;

                isPanning = true;
                const touch = e.touches[0];
                startX = touch.clientX - translateX;
                startY = touch.clientY - translateY;
                modalImage.style.cursor = 'grabbing';

                document.addEventListener('touchmove', panTouch);
                document.addEventListener('touchend', stopPan);
            }

            function pan(e) {
                if (!isPanning) return;
                e.preventDefault();

                translateX = e.clientX - startX;
                translateY = e.clientY - startY;

                // Apply boundaries to prevent panning too far
                const maxTranslate = 100 * currentScale;
                translateX = Math.max(Math.min(translateX, maxTranslate), -maxTranslate);
                translateY = Math.max(Math.min(translateY, maxTranslate), -maxTranslate);

                modalImage.style.transform = `scale(${currentScale}) translate(${translateX}px, ${translateY}px)`;
            }

            function panTouch(e) {
                if (!isPanning) return;
                e.preventDefault();

                const touch = e.touches[0];
                translateX = touch.clientX - startX;
                translateY = touch.clientY - startY;

                // Apply boundaries to prevent panning too far
                const maxTranslate = 100 * currentScale;
                translateX = Math.max(Math.min(translateX, maxTranslate), -maxTranslate);
                translateY = Math.max(Math.min(translateY, maxTranslate), -maxTranslate);

                modalImage.style.transform = `scale(${currentScale}) translate(${translateX}px, ${translateY}px)`;
            }

            function stopPan() {
                isPanning = false;
                if (currentScale > 1) {
                    modalImage.style.cursor = 'grab';
                }
                document.removeEventListener('mousemove', pan);
                document.removeEventListener('touchmove', panTouch);
                document.removeEventListener('mouseup', stopPan);
                document.removeEventListener('touchend', stopPan);
            }

            // Double click to zoom in/out
            modalImage.addEventListener('dblclick', function (e) {
                e.preventDefault();
                if (currentScale === 1) {
                    currentScale = 2;
                } else {
                    currentScale = 1;
                    translateX = 0;
                    translateY = 0;
                }
                applyZoom();
            });

            // Mouse wheel zoom
            modalImage.addEventListener('wheel', function (e) {
                if (e.ctrlKey) {
                    e.preventDefault();
                    if (e.deltaY < 0) {
                        zoomIn();
                    } else {
                        zoomOut();
                    }
                }
            }, { passive: false });

            // Event listeners for zoom buttons
            zoomInBtn.addEventListener('click', zoomIn);
            zoomOutBtn.addEventListener('click', zoomOut);
            resetZoomBtn.addEventListener('click', initializeZoom);

            // Reset zoom when modal is closed
            function closeProductModal() {
                initializeZoom();
                // Your existing close modal logic here
                document.getElementById('productImageModal').classList.add('hidden');
            }

            // Reset zoom when changing images
            document.querySelectorAll('.product-modal-thumb').forEach(thumb => {
                thumb.addEventListener('click', function () {
                    // Small delay to ensure image is loaded before resetting zoom
                    setTimeout(initializeZoom, 100);
                });
            });

            // Initialize zoom on modal open
            const modal = document.getElementById('productImageModal');
            if (modal) {
                // Observe modal opening to initialize zoom
                const observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            if (!modal.classList.contains('hidden')) {
                                // Modal is open, initialize zoom
                                setTimeout(initializeZoom, 100);
                            }
                        }
                    });
                });

                observer.observe(modal, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }

            // Initialize zoom state
            initializeZoom();
        });