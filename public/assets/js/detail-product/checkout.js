// ======================
// ====== CHECKOUT ======
// ======================
const PD =  window.ProductDetail.productId;
const STK = window.ProductDetail.stock;

document.addEventListener('DOMContentLoaded', function () {
    window.syncCheckout = function (PD) {
        // Cek stok
        if (STK <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Habis',
                text: 'Maaf, produk ini sedang tidak tersedia.',
                confirmButtonColor: '#4b5563'
            });
            return false;
        }

        const color = document.getElementById(`selectedColor-${PD}`)?.value;
        const size = document.getElementById(`selectedSize-${PD}`)?.value;

        // Ambil qty dari desktop atau mobile
        const desktopInput = document.getElementById(`desktopQty-${PD}`);
        const mobileInput = document.getElementById(`mobileQty-${PD}`);
        const activeInput = desktopInput || mobileInput;
        const quantity = parseInt(activeInput?.value) || 1;

        const checkoutBtn = document.getElementById(`checkoutBtn-${PD}`);
        const mobileCheckoutBtn = document.getElementById(`mobileCheckoutBtn-${PD}`);

        if (document.querySelector(`[data-item="${PD}"][data-color]`) && !color) {
            showModernAlert('Pilih warna terlebih dahulu!')
            return false;
        }

        if (document.querySelector(`[data-item="${PD}"][data-size]`) && !size) {
            showModernAlert('Pilih ukuran terlebih dahulu!')
            return false;
        }

        // Isi input checkout
        const checkoutQty = document.getElementById(`checkoutQty-${PD}`);
        const checkoutColor = document.getElementById(`checkoutColor-${PD}`);
        const checkoutSize = document.getElementById(`checkoutSize-${PD}`);

        const mobileCheckoutQty = document.getElementById(`mobileCheckoutQty-${PD}`);
        const mobileCheckoutColor = document.getElementById(`mobileCheckoutColor-${PD}`);
        const mobileCheckoutSize = document.getElementById(`mobileCheckoutSize-${PD}`);
        if (checkoutQty) checkoutQty.value = quantity;
        if (checkoutColor) checkoutColor.value = color || '';
        if (checkoutSize) checkoutSize.value = size || '';

        if (mobileCheckoutQty) mobileCheckoutQty.value = quantity;
        if (mobileCheckoutColor) mobileCheckoutColor.value = color || '';
        if (mobileCheckoutSize) mobileCheckoutSize.value = size || '';

        return true;

    }
});
