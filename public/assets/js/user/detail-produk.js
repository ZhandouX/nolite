// =============================
// PRODUCT IMAGE MODAL FUNCTIONS
// =============================
const productImages = config.images;

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

// Initialize product image modal
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
});


// =============================
// COLOR & SIZE SELECTION
// =============================
function selectColor(element, color, productId) {
    // Remove selected class from all color options for this product
    document.querySelectorAll(`.option-btn[data-item="${productId}"]`).forEach(opt => {
        if (opt.dataset.color) {
            opt.classList.remove('selected');
        }
    });

    // Add selected class to clicked element
    element.classList.add('selected');

    // Update hidden input and display text
    document.getElementById(`selectedColor-${productId}`).value = color;
    document.getElementById(`selectedColorText-${productId}`).textContent = color;
    document.getElementById(`checkoutColor-${productId}`).value = color;
    document.getElementById(`checkoutColor-mobile-${productId}`).value = color;
}

function selectSize(element, size, productId) {
    // Remove selected class from all size options for this product
    document.querySelectorAll(`.option-btn[data-item="${productId}"]`).forEach(opt => {
        if (opt.dataset.size) {
            opt.classList.remove('selected');
        }
    });

    // Add selected class to clicked element
    element.classList.add('selected');

    // Update hidden input and display text
    document.getElementById(`selectedSize-${productId}`).value = size;
    document.getElementById(`selectedSizeText-${productId}`).textContent = size;
    document.getElementById(`checkoutSize-${productId}`).value = size;
    document.getElementById(`checkoutSize-mobile-${productId}`).value = size;
}


// =============================
// QUANTITY FUNCTIONS
// =============================
function incrementQty(productId) {
    const input = document.getElementById(`qty-${productId}`);
    const max = parseInt(input.getAttribute('max')) || 999;
    const currentValue = parseInt(input.value);

    if (currentValue < max) {
        input.value = currentValue + 1;
        updateQtyButtons(productId);
        document.getElementById(`checkoutQty-${productId}`).value = input.value;
        document.getElementById(`checkoutQty-mobile-${productId}`).value = input.value;
    } else {
        // Shake animation when reaching max
        input.classList.add('shake');
        setTimeout(() => input.classList.remove('shake'), 500);
    }
}

function decrementQty(productId) {
    const input = document.getElementById(`qty-${productId}`);
    const currentValue = parseInt(input.value);

    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateQtyButtons(productId);
        document.getElementById(`checkoutQty-${productId}`).value = input.value;
        document.getElementById(`checkoutQty-mobile-${productId}`).value = input.value;
    } else {
        // Shake animation when reaching min
        input.classList.add('shake');
        setTimeout(() => input.classList.remove('shake'), 500);
    }
}

function validateQty(productId) {
    const input = document.getElementById(`qty-${productId}`);
    const max = parseInt(input.getAttribute('max')) || 999;
    let value = parseInt(input.value);

    if (isNaN(value) || value < 1) value = 1;
    if (value > max) value = max;

    input.value = value;
    updateQtyButtons(productId);
    document.getElementById(`checkoutQty-${productId}`).value = value;
    document.getElementById(`checkoutQty-mobile-${productId}`).value = value;
}

function updateQtyButtons(productId) {
    const input = document.getElementById(`qty-${productId}`);
    const currentValue = parseInt(input.value);
    const max = parseInt(input.getAttribute('max')) || 999;

    // Update decrement button
    const decrementBtn = document.getElementById(`decrementBtn-${productId}`);
    if (currentValue <= 1) {
        decrementBtn.disabled = true;
    } else {
        decrementBtn.disabled = false;
    }

    // Update increment button
    const incrementBtn = document.getElementById(`incrementBtn-${productId}`);
    if (currentValue >= max) {
        incrementBtn.disabled = true;
    } else {
        incrementBtn.disabled = false;
    }
}


// =============================
// ADD TO CART
// =============================
const productStock = window.productConfig.stock;

function addToCart(productId) {
    // Check if product is out of stock
    if (productStock <= 0) {
    Swal.fire({
        icon: 'warning',
        title: 'Stok Habis',
        text: 'Maaf, produk ini sedang tidak tersedia.',
        confirmButtonColor: '#4b5563'
    });
    return;
}

const color = document.getElementById(`selectedColor-${productId}`)?.value;
const size = document.getElementById(`selectedSize-${productId}`)?.value;
const quantity = parseInt(document.getElementById(`qty-${productId}`)?.value) || 1;

// Validate color selection if required
if (document.querySelector(`.option-btn[data-item="${productId}"][data-color]`) && !color) {
    Swal.fire({
        icon: 'warning',
        title: 'Pilih Warna',
        text: 'Silakan pilih warna terlebih dahulu!',
        confirmButtonColor: '#4b5563'
    });

    // Highlight color options
    document.querySelectorAll(`.option-btn[data-item="${productId}"][data-color]`).forEach(btn => {
        btn.classList.add('shake');
        setTimeout(() => btn.classList.remove('shake'), 1000);
    });
    return;
}

// Validate size selection if required
if (document.querySelector(`.option-btn[data-item="${productId}"][data-size]`) && !size) {
    Swal.fire({
        icon: 'warning',
        title: 'Pilih Ukuran',
        text: 'Silakan pilih ukuran terlebih dahulu!',
        confirmButtonColor: '#4b5563'
    });

    // Highlight size options
    document.querySelectorAll(`.option-btn[data-item="${productId}"][data-size]`).forEach(btn => {
        btn.classList.add('shake');
        setTimeout(() => btn.classList.remove('shake'), 1000);
    });
    return;
}

// Show loading state
const cartBtn = document.getElementById(`cartBtn-${productId}`);
const mobileCartBtn = document.getElementById(`mobileCartBtn-${productId}`);
const originalText = cartBtn.innerHTML;
const loadingText = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menambahkan...';
const storeUrl     = window.productConfig.storeUrl;
const csrfToken    = window.productConfig.csrf;

cartBtn.innerHTML = loadingText;
cartBtn.disabled = true;
if (mobileCartBtn) {
    mobileCartBtn.innerHTML = loadingText;
    mobileCartBtn.disabled = true;
}

fetch(storeUrl, {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken
    },
    body: JSON.stringify({
        produk_id: productId,
        warna: color,
        ukuran: size,
        jumlah: quantity
    })
})
    .then(res => {
        if (!res.ok) {
            throw new Error('Network response was not ok');
        }
        return res.json();
    })
    .then(data => {
        // Reset button state
        cartBtn.innerHTML = originalText;
        cartBtn.disabled = false;
        if (mobileCartBtn) {
            mobileCartBtn.innerHTML = 'Keranjang';
            mobileCartBtn.disabled = false;
        }

        // Show success message
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: data.message ?? 'Produk berhasil ditambahkan ke keranjang.',
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: 'top-end',
            background: '#10b981',
            color: 'white',
            iconColor: 'white'
        });

        // UPDATE BADGE REAL-TIME
        refreshCartPopup();
    })
    .catch(err => {
        console.error(err);

        // Reset button state
        cartBtn.innerHTML = originalText;
        cartBtn.disabled = false;
        if (mobileCartBtn) {
            mobileCartBtn.innerHTML = 'Keranjang';
            mobileCartBtn.disabled = false;
        }

        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan!',
            text: 'Gagal menambahkan produk ke keranjang.',
            confirmButtonColor: '#4b5563'
        });
    });
        }


// =============================
// REFRESH CART BADGE
// =============================

const cartCheckUrl = window.productConfig.cartCheckUrl;

function refreshCartPopup() {
    fetch(cartCheckUrl, {
        headers: { 'X-CSRF-TOKEN': csrfToken }
    })
        .then(res => res.json())
        .then(data => {
            const total = data.items?.length || 0;
            animateCartBadge(total);
        })
        .catch(err => console.error(err));
}

function animateCartBadge(total) {
    const badge = document.getElementById('cartBadge');
    if (!badge) return;
    if (total > 0) {
        badge.textContent = total;
        badge.classList.remove('hidden');
        badge.classList.add('animate-bounce');
        setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
    } else {
        badge.classList.add('hidden');
    }
}


// =============================
// SYNC CHECKOUT
// =============================
function syncCheckout(productId) {
    // Check if product is out of stock
    if (productStock <= 0) {
    Swal.fire({
        icon: 'warning',
        title: 'Stok Habis',
        text: 'Maaf, produk ini sedang tidak tersedia.',
        confirmButtonColor: '#4b5563'
    });
    return false;
}

const color = document.getElementById(`selectedColor-${productId}`)?.value;
const size = document.getElementById(`selectedSize-${productId}`)?.value;
const quantity = document.getElementById(`qty-${productId}`).value;

if (document.querySelector(`.option-btn[data-item="${productId}"][data-color]`) && !color) {
    Swal.fire({
        icon: 'warning',
        title: 'Pilih Warna',
        text: 'Pilih warna terlebih dahulu!',
        confirmButtonColor: '#4b5563'
    });
    return false;
}

if (document.querySelector(`.option-btn[data-item="${productId}"][data-size]`) && !size) {
    Swal.fire({
        icon: 'warning',
        title: 'Pilih Ukuran',
        text: 'Pilih ukuran terlebih dahulu!',
        confirmButtonColor: '#4b5563'
    });
    return false;
}

document.getElementById(`checkoutColor-${productId}`).value = color;
document.getElementById(`checkoutSize-${productId}`).value = size;
document.getElementById(`checkoutQty-${productId}`).value = quantity;

// Also sync mobile form
document.getElementById(`checkoutColor-mobile-${productId}`).value = color;
document.getElementById(`checkoutSize-mobile-${productId}`).value = size;
document.getElementById(`checkoutQty-mobile-${productId}`).value = quantity;

return true;
        }


// =============================
// REVIEW FILTERING
// =============================
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-star');
    const ulasanCards = document.querySelectorAll('.review-card');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const rating = this.getAttribute('data-star');

            // Update active filter button
            document.querySelectorAll('.filter-star').forEach(b => {
                b.classList.remove('bg-gray-800', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-700');
            });
            this.classList.remove('bg-gray-100', 'text-gray-700');
            this.classList.add('bg-gray-800', 'text-white');

            // Filter reviews
            ulasanCards.forEach(card => {
                if (rating === 'all' || card.getAttribute('data-rating') === rating) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Initialize quantity buttons
    updateQtyButtons('{{ $produk->id }}');
});


// =============================
// READ MORE DESCRIPTION
// =============================
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
