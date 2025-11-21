// ================================================
// ====== VARIATION MODAL & DISPLAY (MOBILE) ======
// ================================================
function openVariationModal() {
    const modal = document.getElementById('variationModal');
    const overlay = document.getElementById('variationOverlay');

    modal.classList.remove('translate-y-full');
    modal.classList.add('translate-y-0');

    overlay.classList.remove('opacity-0', 'pointer-events-none');
    overlay.classList.add('opacity-100');

    document.body.style.overflow = 'hidden';
}
function closeVariationModal() {
    const modal = document.getElementById('variationModal');
    const overlay = document.getElementById('variationOverlay');

    modal.classList.remove('translate-y-0');
    modal.classList.add('translate-y-full');

    overlay.classList.remove('opacity-100');
    overlay.classList.add('opacity-0', 'pointer-events-none');

    document.body.style.overflow = 'auto';
}

// Display
function updateVariationDisplay() {
    const productId = window.productId;
    const color = document.getElementById(`selectedColor-${productId}`).value || '-';
    const size = document.getElementById(`selectedSize-${productId}`).value || '-';

    document.getElementById('selectedVariationText').textContent = `Warna: ${color} | Ukuran: ${size}`;
}