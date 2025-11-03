document.addEventListener("DOMContentLoaded", function () {

    // =======================
    // SORT DROPDOWN (Desktop)
    // =======================
    const sortDropdownBtn = document.getElementById('sortDropdownBtn');
    const sortDropdownMenu = document.getElementById('sortDropdownMenu');
    if (sortDropdownBtn) {
        sortDropdownBtn.addEventListener('click', e => {
            e.stopPropagation();
            sortDropdownMenu.classList.toggle('hidden');
        });
        document.addEventListener('click', (e) => {
            if (!sortDropdownMenu.contains(e.target) && !sortDropdownBtn.contains(e.target)) {
                sortDropdownMenu.classList.add('hidden');
            }
        });
    }

    // =======================
    // FILTER MODAL MOBILE
    // =======================
    const mobileOpenFilterBtn = document.getElementById('mobileOpenFilterBtn');
    const mobileFilterModal = document.getElementById('mobileFilterModal');
    const closeMobileFilterBtn = document.getElementById('closeMobileFilterBtn');

    if (mobileOpenFilterBtn && mobileFilterModal && closeMobileFilterBtn) {
        mobileOpenFilterBtn.addEventListener('click', () => mobileFilterModal.classList.remove('hidden'));
        closeMobileFilterBtn.addEventListener('click', () => mobileFilterModal.classList.add('hidden'));
        mobileFilterModal.addEventListener('click', e => {
            if (e.target === mobileFilterModal) mobileFilterModal.classList.add('hidden');
        });
    }

    // =======================
    // SORT MODAL MOBILE
    // =======================
    const openSortBtn = document.getElementById('openSortBtn');
    const sortModal = document.getElementById('sortModal');
    const closeSortModal = document.getElementById('closeSortModal');

    if (openSortBtn && sortModal && closeSortModal) {
        openSortBtn.addEventListener('click', () => sortModal.classList.remove('hidden'));
        closeSortModal.addEventListener('click', () => sortModal.classList.add('hidden'));
        sortModal.addEventListener('click', e => {
            if (e.target === sortModal) sortModal.classList.add('hidden');
        });
    }

    // =======================
    // WISHLIST TOGGLE
    // =======================
    window.toggleWishlist = function (produkId) {
        fetch(`${window.Laravel.routes.wishlistToggle}/${produkId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
                'Accept': 'application/json',
            },
        })
            .then(res => res.json())
            .then(data => {
                const icon = document.getElementById(`heart-icon-${produkId}`);
                if (icon) {
                    if (data.status === 'added') {
                        icon.classList.remove('text-gray-300');
                        icon.classList.add('text-red-500');
                    } else {
                        icon.classList.remove('text-red-500');
                        icon.classList.add('text-gray-300');
                    }
                }
            })
            .catch(err => console.error(err));
    };

    // =======================
    // CATEGORY RADIO TOGGLE
    // =======================
    window.handleCategoryClick = function (radio, categoryUrl, allUrl) {
        if (radio.dataset.waschecked === "true") {
            radio.checked = false;
            radio.dataset.waschecked = "false";
            window.location.href = allUrl;
        } else {
            document.querySelectorAll('input[name="kategori"]').forEach(el => el.dataset.waschecked = "false");
            radio.dataset.waschecked = "true";
            window.location.href = categoryUrl;
        }
    };
    document.querySelectorAll('input[name="kategori"]').forEach(el => {
        if (el.checked) el.dataset.waschecked = "true";
    });

    // =======================
    // FORMAT IDR
    // =======================
    function formatIDR(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })
            .format(angka).replace('Rp', 'IDR');
    }

    // =======================
    // SUBTOTAL & CHECKBOX
    // =======================
    function updateTotal() {
        const checkboxes = document.querySelectorAll('.select-item');
        let total = 0;
        const selected = [];
        checkboxes.forEach(cb => {
            const qty = parseInt(cb.dataset.jumlah) || 0;
            const harga = parseFloat(cb.dataset.harga) || 0;
            if (cb.checked) {
                total += harga * qty;
                selected.push(cb.dataset.keranjang);
            }
        });
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total');
        const checkoutBtn = document.getElementById('checkout-btn');
        const selectedItems = document.getElementById('selected-items');

        if (subtotalEl) subtotalEl.textContent = formatIDR(total);
        if (totalEl) totalEl.textContent = formatIDR(total);
        if (checkoutBtn) checkoutBtn.disabled = selected.length === 0;
        if (selectedItems) selectedItems.value = JSON.stringify(selected);
    }

    document.querySelectorAll('.select-item').forEach(cb => cb.addEventListener('change', updateTotal));
    const selectAll = document.getElementById('select-all');
    if (selectAll) selectAll.addEventListener('change', function () {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
        updateTotal();
    });

    // =======================
    // KERANJANG POPUP & FUNCTIONS
    // =======================
    function refreshCartPopup() {
        fetch(window.Laravel.routes.keranjangCek, { headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken } })
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('cartPopupContainer');
                if (!container) return;
                container.innerHTML = '';

                if (data.items && data.items.length > 0) {
                    const totalProdukUnik = data.items.length;
                    showCartPopup(totalProdukUnik);
                    animateCartBadge(totalProdukUnik);
                } else {
                    animateCartBadge(0);
                }
            });
    }

    function showCartPopup(totalProduk) {
        const container = document.getElementById('cartPopupContainer');
        if (!container) return;
        container.innerHTML = '';

        const popup = document.createElement('div');
        popup.className = "bg-gray-400/95 text-white rounded-2xl shadow-2xl flex items-center justify-between gap-3 px-5 py-4 w-80 cursor-pointer hover:bg-gray-500/95 transition-all duration-300 animate-slide-up animate-border-gray backdrop-blur-sm";
        popup.onclick = () => { window.location.href = window.Laravel.routes.keranjangIndex; };

        popup.innerHTML = `
            <div class="flex items-center gap-3 relative">
                <div class="relative">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-white-400"></i>
                    <span class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5 py-0.5">
                        ${totalProduk}
                    </span>
                </div>
                <span class="text-base font-medium">
                    Ada <strong>${totalProduk}</strong> produk di keranjang
                </span>
            </div>
            <button class="text-gray-400 hover:text-white text-lg font-bold" onclick="closePopup(event, this)">×</button>
        `;
        container.appendChild(popup);
        if (window.lucide) lucide.createIcons();
    }

    function closePopup(e, btn) {
        e.stopPropagation();
        if (btn?.parentElement) btn.parentElement.remove();
    }

    function animateCartBadge(total) {
        const badge = document.getElementById('cartBadge');
        if (!badge) return;

        if (total > 0) {
            badge.textContent = total;
            badge.classList.remove('hidden');
            badge.classList.add('animate-bounce');
            setTimeout(() => badge.classList.remove('animate-bounce'), 300);
        } else {
            badge.classList.add('hidden');
        }
    }

    // =======================
    // ADD TO CART
    // =======================
    window.addToCart = function (id) {
        const warna = document.querySelector(`#selectedColor-${id}`)?.value;
        const ukuran = document.querySelector(`#selectedSize-${id}`)?.value;
        const qty = parseInt(document.querySelector(`#qty-${id}`)?.value || 1);

        if (!warna || !ukuran) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Varian Dulu!',
                text: 'Silakan pilih warna dan ukuran sebelum menambahkan ke keranjang.',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        fetch(window.Laravel.routes.keranjangStore, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": window.Laravel.csrfToken
            },
            body: JSON.stringify({ produk_id: id, warna: warna, ukuran: ukuran, jumlah: qty })
        })
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: data.error, confirmButtonColor: '#ef4444' });
                } else {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true,
                        position: 'top-end'
                    });
                    closeModal(`productModal-${id}`);
                    refreshCartPopup();
                }
            });
    };

    // =======================
    // QUANTITY HANDLER (updateQuantity tetap dipakai)
    // =======================
    window.updateQuantity = function (id, change) {
        const qtyEl = document.getElementById(`qty-${id}`);
        let currentQty = parseInt(qtyEl.textContent) || 0;
        let newQty = currentQty + change;

        if (newQty < 1) {
            hapusKeranjang(id);
            return;
        }

        qtyEl.textContent = newQty;

        const checkbox = document.querySelector(`.select-item[data-keranjang='${id}']`);
        if (checkbox) {
            checkbox.dataset.jumlah = newQty;
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change'));
        }

        // 🧠 CEK apakah user login atau tidak
        if (!window.Laravel.isLoggedIn) {
            // Update session via route keranjang/session/update
            fetch(`${window.Laravel.routes.keranjangSessionUpdate}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ key: id, jumlah: newQty })
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message });
                        qtyEl.textContent = currentQty;
                    } else {
                        refreshCartPopup();
                    }
                });
            return;
        }

        // 🧩 Kalau login, baru PATCH ke database
        fetch(`${window.Laravel.routes.keranjangBase}/${id}`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ jumlah: newQty })
        })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message });
                    qtyEl.textContent = currentQty;
                } else {
                    refreshCartPopup();
                }
            });
    };

    window.hapusKeranjang = function (id) {
        Swal.fire({
            title: 'Hapus item ini?',
            text: "Produk akan dihapus dari keranjangmu.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`${window.Laravel.routes.keranjangBase}/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken, 'Accept': 'application/json' }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const itemEl = document.querySelector(`.item-keranjang[data-id='${id}']`);
                            if (itemEl) itemEl.remove();
                            updateTotal();
                            refreshCartPopup();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500,
                                toast: true,
                                position: 'top-end'
                            });
                        }
                    });
            }
        });
    };

    // =======================
    // QTY IN MODAL / PRODUCT PAGE
    // =======================
    window.incrementQty = function (id) {
        const qtyEl = document.getElementById(`qty-${id}`);
        const max = parseInt(qtyEl?.max || 999);
        if (!qtyEl) return;

        let val = parseInt(qtyEl.value) || 1;
        if (val < max) qtyEl.value = val + 1;
        updateQtyData(id);
    };

    window.decrementQty = function (id) {
        const qtyEl = document.getElementById(`qty-${id}`);
        if (!qtyEl) return;

        let val = parseInt(qtyEl.value) || 1;
        if (val > 1) qtyEl.value = val - 1;
        updateQtyData(id);
    };

    window.validateQty = function (id) {
        const qtyEl = document.getElementById(`qty-${id}`);
        if (!qtyEl) return;

        let val = parseInt(qtyEl.value) || 1;
        const max = parseInt(qtyEl.max || 999);
        if (val < 1) val = 1;
        if (val > max) val = max;
        qtyEl.value = val;
        updateQtyData(id);
    };

    function updateQtyData(id) {
        const qtyEl = document.getElementById(`qty-${id}`);
        const checkbox = document.querySelector(`.select-item[data-keranjang='${id}']`);
        if (qtyEl && checkbox) {
            checkbox.dataset.jumlah = parseInt(qtyEl.value);
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change'));
        }
    }

    // =======================
    // REFRESH CART ON LOAD
    // =======================
    refreshCartPopup();
});
