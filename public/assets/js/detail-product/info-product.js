// ==============================
// ====== REVIEW FILTERING ======
// ==============================
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-star');
    const ulasanCards = document.querySelectorAll('.review-card');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const rating = this.getAttribute('data-star');

            // Update active filter button dengan animasi
            document.querySelectorAll('.filter-star').forEach(b => {
                b.classList.remove('bg-gradient-to-r', 'from-gray-900', 'to-gray-800', 'text-white', 'shadow-md');
                b.classList.add('bg-white', 'text-gray-700', 'shadow-sm');
            });

            this.classList.remove('bg-white', 'text-gray-700', 'shadow-sm');
            this.classList.add('bg-gradient-to-r', 'from-gray-900', 'to-gray-800', 'text-white', 'shadow-md');

            // Filter reviews dengan animasi halus
            ulasanCards.forEach(card => {
                if (rating === 'all' || card.getAttribute('data-rating') === rating) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Initialize quantity buttons
    updateDesktopQtyButtons(window.productId);
});

// ===================================
// ====== READ MORE DESCRIPTION ======
// ===================================
document.addEventListener('DOMContentLoaded', function () {
    const descriptionContent = document.getElementById('descriptionContent');
    const descriptionOverlay = document.getElementById('descriptionOverlay');
    const readMoreBtn = document.getElementById('readMoreBtn');

    if (descriptionContent && readMoreBtn) {
        // Check if content is longer than max-height
        const isOverflowing = descriptionContent.scrollHeight > descriptionContent.clientHeight;

        if (!isOverflowing) {
            descriptionOverlay.style.display = 'none';
            return;
        }

        let isExpanded = false;

        readMoreBtn.addEventListener('click', function () {
            if (isExpanded) {
                // Collapse
                descriptionContent.style.maxHeight = '8rem'; // 32 = 8rem
                readMoreBtn.textContent = 'Lihat Selengkapnya';
                descriptionOverlay.style.display = 'flex';
            } else {
                // Expand
                descriptionContent.style.maxHeight = descriptionContent.scrollHeight + 'px';
                readMoreBtn.textContent = 'Lihat Lebih Sedikit';
                descriptionOverlay.style.display = 'none';
            }
            isExpanded = !isExpanded;
        });

        // Handle window resize
        window.addEventListener('resize', function () {
            if (!isExpanded) {
                const stillOverflowing = descriptionContent.scrollHeight > descriptionContent.clientHeight;
                descriptionOverlay.style.display = stillOverflowing ? 'flex' : 'none';
            }
        });
    }
});
