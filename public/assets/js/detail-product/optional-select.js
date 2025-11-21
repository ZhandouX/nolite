// =========================================================
// ====== OPTIONAL SELECT (WARNA, UKURAN, DAN JUMLAH) ======
// =========================================================
// Warna
function selectColor(element, color, productId) {
    // Remove selected class from all color options for this product
    document.querySelectorAll(`[data-item="${productId}"][data-color]`).forEach(opt => {
        opt.classList.remove('selected');
    });

    // Add selected class to clicked element
    element.classList.add('selected');

    // Update hidden input and display text
    document.getElementById(`selectedColor-${productId}`).value = color;
    document.getElementById(`selectedColorText-${productId}`).textContent = color;
    document.getElementById(`mobileSelectedColorText-${productId}`).textContent = color;

    // Update checkout inputs if they exist
    const checkoutColor = document.getElementById(`checkoutColor-${productId}`);
    const mobileCheckoutColor = document.getElementById(`mobileCheckoutColor-${productId}`);
    
    if (checkoutColor) checkoutColor.value = color;

    // Update variation display if on mobile
    updateVariationDisplay();
}

// Ukuran
function selectSize(element, size, productId) {
    // Remove selected class from all size options for this product
    document.querySelectorAll(`[data-item="${productId}"][data-size]`).forEach(opt => {
        opt.classList.remove('selected');
    });

    // Add selected class to clicked element
    element.classList.add('selected');

    // Update hidden input and display text
    document.getElementById(`selectedSize-${productId}`).value = size;
    document.getElementById(`selectedSizeText-${productId}`).textContent = size;
    document.getElementById(`mobileSelectedSizeText-${productId}`).textContent = size;

    document.getElementById(`checkoutSize-${productId}`).value = size;
    document.getElementById(`mobileCheckoutSize-${productId}`).vlaue = size;

    // Update variation display if on mobile
    updateVariationDisplay();
}

// Jumlah (DESKTOP)
function detailIncrementQty(productId) {
    const desktopInput = document.getElementById(`desktopQty-${productId}`);
    const mobileInput = document.getElementById(`mobileQty-${productId}`);

    // Tentukan input yang aktif (desktop atau mobile)
    const activeInput = desktopInput || mobileInput;
    if (!activeInput) return;

    const max = parseInt(activeInput.getAttribute('max')) || 999;
    const currentValue = parseInt(activeInput.value);

    if (currentValue < max) {
        const newValue = currentValue + 1;

        // Update keduanya jika ada
        if (desktopInput) desktopInput.value = newValue;
        if (mobileInput) mobileInput.value = newValue;

        // Update qty di checkout juga
        const checkout = document.getElementById(`checkoutQty-${productId}`);
        const mobileCheckout = document.getElementById(`mobileCheckoutQty-${productId}`);

        if (checkout) checkout.value = newValue;

        // Update button state untuk desktop
        if (typeof updateDesktopQtyButtons === "function") {
            updateDesktopQtyButtons(productId);
        }

    } else {
        // Animasi shake jika max
        activeInput.classList.add('shake');
        setTimeout(() => activeInput.classList.remove('shake'), 500);
    }
}
function detailDecrementQty(productId) {
    const desktopInput = document.getElementById(`desktopQty-${productId}`);
    const mobileInput = document.getElementById(`mobileQty-${productId}`);

    const activeInput = desktopInput || mobileInput;
    if (!activeInput) return;

    const currentValue = parseInt(activeInput.value);

    if (currentValue > 1) {
        const newValue = currentValue - 1;

        // Update semua input jika ada
        if (desktopInput) desktopInput.value = newValue;
        if (mobileInput) mobileInput.value = newValue;

        // Update checkout juga
        const checkout = document.getElementById(`checkoutQty-${productId}`);
        const mobileCheckout = document.getElementById(`mobileCheckoutQty-${productId}`);

        if (checkout) checkout.value = newValue;

        if (typeof updateDesktopQtyButtons === "function") {
            updateDesktopQtyButtons(productId);
        }

    } else {
        activeInput.classList.add("shake");
        setTimeout(() => activeInput.classList.remove("shake"), 500);
    }

}
function detailValidateQty(productId) {
    const desktopInput = document.getElementById(`desktopQty-${productId}`);
    const mobileInput = document.getElementById(`mobileQty-${productId}`);

    const activeInput = desktopInput || mobileInput;
    if (!activeInput) return;

    const max = parseInt(activeInput.getAttribute("max")) || 999;
    let value = parseInt(activeInput.value);

    if (isNaN(value) || value < 1) value = 1;
    if (value > max) value = max;

    // Update kedua input
    if (desktopInput) desktopInput.value = value;
    if (mobileInput) mobileInput.value = value;

    // Update checkout
    const checkout = document.getElementById(`checkoutQty-${productId}`);
    const mobileCheckout = document.getElementById(`mobileCheckoutQty-${productId}`);

    if (checkout) checkout.value = value;

    if (typeof updateDesktopQtyButtons === "function") {
        updateDesktopQtyButtons(productId);
    }

}
function updateDesktopQtyButtons(productId) {
    const desktopInput = document.getElementById(`desktopQty-${productId}`);
    const mobileInput = document.getElementById(`mobileQty-${productId}`);

    const activeInput = desktopInput || mobileInput;
    if (!activeInput) return;

    const value = parseInt(activeInput.value);
    const max = parseInt(activeInput.getAttribute("max")) || 999;

    const decrementBtn = document.getElementById(`decrementBtn-${productId}`);
    const incrementBtn = document.getElementById(`incrementBtn-${productId}`);

    if (decrementBtn) decrementBtn.disabled = value <= 1;
    if (incrementBtn) incrementBtn.disabled = value >= max;

}

