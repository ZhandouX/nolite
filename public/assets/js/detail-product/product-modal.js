// ===========================================
// ====== PRODUCT IMAGE MODAL FUNCTIONS ======
// ===========================================
const productImages = window.productImages;

let currentProductIndex = 0;

function changeMainImage(src, element, index) {
    const mainImage = document.getElementById('mainImage');

    // Add fade out effect
    mainImage.style.opacity = '0';

    setTimeout(() => {
        mainImage.src = src;
        mainImage.style.opacity = '1';

        // Update thumbnails
        document.querySelectorAll('.thumb').forEach(thumb => {
            thumb.classList.remove('border-gray-700');
            thumb.classList.add('border-gray-200');
        });
        element.classList.remove('border-gray-200');
        element.classList.add('border-gray-700');

        // Update current index
        currentProductIndex = index;
    }, 150);
}
function openProductModal(index) {
    currentProductIndex = index;
    const modal = document.getElementById('productImageModal');
    const img = document.getElementById('modalProductImage');

    img.src = productImages[currentProductIndex];
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Update active thumbnail in modal
    updateProductModalThumbnails();
}
function closeProductModal() {
    const modal = document.getElementById('productImageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}
function showProductImage(index) {
    if (index < 0) index = productImages.length - 1;
    if (index >= productImages.length) index = 0;

    currentProductIndex = index;
    document.getElementById('modalProductImage').src = productImages[currentProductIndex];
    document.getElementById('currentImageIndex').innerText = index + 1;
    updateProductModalThumbnails();
}
function updateProductModalThumbnails() {
    document.querySelectorAll('.product-modal-thumb').forEach(thumb => {
        const index = parseInt(thumb.dataset.index);
        if (index === currentProductIndex) {
            thumb.classList.add('border-blue-500', 'active');
            thumb.classList.remove('border-transparent');
        } else {
            thumb.classList.remove('border-blue-500', 'active');
            thumb.classList.add('border-transparent');
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    // Prev / Next buttons for product modal
    document.getElementById('prevProductImage').addEventListener('click', () => showProductImage(currentProductIndex - 1));
    document.getElementById('nextProductImage').addEventListener('click', () => showProductImage(currentProductIndex + 1));

    // Thumbnail clicks in product modal
    document.querySelectorAll('.product-modal-thumb').forEach(thumb => {
        thumb.addEventListener('click', () => {
            const index = parseInt(thumb.dataset.index);
            showProductImage(index);
        });
    });

    // Close product modal on click outside
    document.getElementById('productImageModal').addEventListener('click', e => {
        if (e.target.id === 'productImageModal') closeProductModal();
    });

    // Close product modal with ESC
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeProductModal();
    });

    // Initialize variation display
    updateVariationDisplay();
});

