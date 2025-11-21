// ==============================
// ====== TAMBAH KERANJANG ======
// ==============================
const PID = window.ProductDetail.productId;
const STOCK = window.ProductDetail.stock;
const CSRF = window.ProductDetail.csrf;
const ADD_CART_URL = window.ProductDetail.addToCartUrl;
const CART_CHECK_URL = window.ProductDetail.cartCheckUrl;
const ADD_WISHLIST_URL = window.ProductDetail.wishlistUrl;

document.addEventListener('DOMContentLoaded', function () {
    window.isMobile = function () {
        return window.innerWidth < 768;
    }
    window.detailAddToCart = function (PID) {
        // Cek stok
        if (STOCK <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Stok Habis',
                text: 'Maaf, produk ini sedang tidak tersedia.',
                confirmButtonColor: '#4b5563'
            });
            return;
        }

        const color = document.getElementById(`selectedColor-${PID}`)?.value;
        const size = document.getElementById(`selectedSize-${PID}`)?.value;

        // Ambil qty dari desktop atau mobile
        const desktopInput = document.getElementById(`desktopQty-${PID}`);
        const mobileInput = document.getElementById(`mobileQty-${PID}`);
        const activeInput = desktopInput || mobileInput;
        const quantity = parseInt(activeInput?.value) || 1;

        const cartBtn = document.getElementById(`cartBtn-${PID}`);

        // CEK VARIAN WARNA
        if (document.getElementById(`selectedColor-${PID}`) && !color) {

            if (isMobile()) {
                // Mobile → buka modal
                openVariationModal(PID);
            } else {
                // Desktop → tampilkan SweetAlert2
                showModernAlert('Pilih warna terlebih dahulu!');
            }

            return;
        }

        // CEK VARIAN UKURAN
        if (document.getElementById(`selectedSize-${PID}`) && !size) {

            if (isMobile()) {
                openVariationModal(PID);
            } else {
                showModernAlert('Pilih ukuran terlebih dahulu!');
            }

            return;
        }


        // =========================
        // === PROSES ADD TO CART NORMAL
        // =========================
        const originalText = cartBtn.innerHTML;
        const loadingText =
            '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menambahkan...';

        // Set loading state
        cartBtn.disabled = true;
        cartBtn.innerHTML = loadingText;

        fetch(ADD_CART_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF
            },
            body: JSON.stringify({
                produk_id: PID,
                warna: color,
                ukuran: size,
                jumlah: quantity
            })
        })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                cartBtn.innerHTML = originalText;
                cartBtn.disabled = false;

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message ?? 'Produk berhasil ditambahkan ke keranjang.',
                    toast: true,
                    position: 'top-end',
                    // agar tidak menutupi navbar (navbar tinggi 60px → offset 70px)
                    customClass: {
                        popup: 'modern-toast'
                    },
                    showConfirmButton: false,
                    timer: 1800,
                    background: 'rgba(255, 255, 255, 0.25)',
                    color: '#0f172a',
                    iconColor: '#10b981'
                });

                closeVariationModal();
                refreshCartPopup();
            })
            .catch(err => {
                console.error(err);
                cartBtn.innerHTML = originalText;
                cartBtn.disabled = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: 'Gagal menambahkan produk ke keranjang.',
                    confirmButtonColor: '#4b5563'
                });
            });
    }
});

// =======================================
// ====== WISHLIST FUNCTIONS DETAIL ======
// =======================================
document.addEventListener('DOMContentLoaded', function () {
    window.toggleWishlistDetail = function (PID) {
        fetch(`${ADD_WISHLIST_URL}/${PID}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
        })
            .then(res => res.json())
            .then(data => {

                const wishlistIcon = document.getElementById(`wishlistIcon-${PID}`);
                const fixedIcon = document.getElementById(`fixedIcon-${PID}`);
                const mobileWishlistIcon = document.getElementById(`mobileWishlistIcon-${PID}`);

                if (!wishlistIcon && !mobileWishlistIcon) return;

                if (data.status === 'added') {
                    // Add active style
                    if (wishlistIcon) {
                        wishlistIcon.classList.remove('text-gray-500', 'fill-none');
                        wishlistIcon.classList.add('text-red-500', 'fill-red-500');

                        // Animate
                        wishlistIcon.classList.add('animate-springIn');
                        setTimeout(() => wishlistIcon.classList.remove('animate-springIn'), 300);
                    }

                    if (mobileWishlistIcon) {
                        mobileWishlistIcon.classList.remove('text-gray-500', 'fill-none');
                        mobileWishlistIcon.classList.add('text-red-500', 'fill-red-500');

                        // Animate (Mobile)
                        mobileWishlistIcon.classList.add('animate-springOut');
                        setTimeout(() => mobileWishlistIcon.classList.remove('animate-springOut'), 300);
                    }

                    if (fixedIcon) {
                        fixedIcon.classList.remove('text-gray-500', 'fill-none');
                        fixedIcon.classList.add('text-red-500', 'fill-red-500');

                        // Animate (Fixed)
                        fixedIcon.classList.add('animate-springOut');
                        setTimeout(() => fixedIcon.classList.remove('animate-springOut'), 300);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message ?? 'Ditambahkan ke Wishlist.',
                        toast: true,
                        position: 'top-end',
                        customClass: {
                            popup: 'modern-toast'
                        },
                        showConfirmButton: false,
                        timer: 1800,
                        background: 'rgba(255, 255, 255, 0.25)',
                        color: '#0f172a',
                        iconColor: '#10b981'
                    });

                } else {
                    // Remove active style
                    if (wishlistIcon) {
                        wishlistIcon.classList.remove('text-red-500', 'fill-red-500');
                        wishlistIcon.classList.add('text-gray-500', 'fill-none');

                        // Animate remove wishlist
                        wishlistIcon.classList.add('animate-springIn');
                        setTimeout(() => wishlistIcon.classList.remove('animate-springIn'), 300);
                    }

                    if (mobileWishlistIcon) {
                        mobileWishlistIcon.classList.remove('text-red-500', 'fill-red-500');
                        mobileWishlistIcon.classList.add('text-gray-500', 'fill-none');

                        // Animate remove wishlist (MOBILE)
                        mobileWishlistIcon.classList.add('animate-springOut');
                        setTimeout(() => mobileWishlistIcon.classList.remove('animate-springOut'), 300);
                    }

                    if (fixedIcon) {
                        fixedIcon.classList.remove('text-red-500', 'fill-red-500');
                        fixedIcon.classList.add('text-gray-500', 'fill-none');

                        // Animate remove wishlist (MOBILE)
                        fixedIcon.classList.add('animate-springOut');
                        setTimeout(() => fixedIcon.classList.remove('animate-springOut'), 300);
                    }

                    showToast({
                        title: 'Dihapus!',
                        text: data.message ?? 'Dihapus dari Wishlist.',
                        iconHtml: `<i class="fa-solid fa-trash-can text-xl"></i>`
                    });

                }
            })
            .catch(err => console.error(err));
    };
});

// ================================
// ====== REFRESH CART BADGE ======
// ================================
document.addEventListener('DOMContentLoaded', function () {
    window.refreshCartPopup = function () {
        fetch(CART_CHECK_URL, {
            headers: { 'X-CSRF-TOKEN': CSRF }
        })
            .then(res => res.json())
            .then(data => {
                const total = data.items?.length || 0;
                animateCartBadge(total);
            })
            .catch(err => console.error(err));
    }
    window.animateCartBadge = function (total) {
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
    window.showModernAlert = function (message) {
        Swal.fire({
            icon: 'warning',
            title: 'Variasi Belum Lengkap',
            text: message,
            toast: true,
            position: 'top',
            customClass: {
                popup: 'modern-toast'
            },
            showConfirmButton: false,
            timer: 1800,
            background: 'rgba(255, 255, 255, 0.35)',
            color: '#0f172a',
            iconColor: '#f59e0b'
        });
    }
    window.showToast = function ({
        title = '',
        text = '',
        iconHtml = '',
        timer = 1800
    }) {
        Swal.fire({
            iconHtml: iconHtml,
            title: title,
            text: text,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'modern-toast'
            },
            showConfirmButton: false,
            timer: timer,
            background: 'rgba(255, 255, 255, 0.25)',
            color: '#0f172a',
            iconColor: '#FF0000'
        });
    }
});
