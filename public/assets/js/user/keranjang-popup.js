function formatIDR(angka) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })
        .format(angka).replace('Rp', 'IDR');
}

// SUBTOTAL
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

    document.getElementById('subtotal').textContent = formatIDR(total);
    document.getElementById('total').textContent = formatIDR(total);
    document.getElementById('checkout-btn').disabled = selected.length === 0;
    document.getElementById('selected-items').value = JSON.stringify(selected);
}

// KERANJANG POPUP
function refreshCartPopup() {
    fetch(window.Laravel.routes.keranjangCek, { headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken } })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('cartPopupContainer');
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

// LIHAT KERANJANG
function showCartPopup(totalProduk) {
    const container = document.getElementById('cartPopupContainer');
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

// CLOSE KERANJANG POPUP
function closePopup(e, btn) {
    e.stopPropagation();
    btn.parentElement.remove();
}

// ANIMASI BADGE
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

// TAMBAH KERANJANG
function addToCart(id) {
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
}

// --- Update quantity ---
function updateQuantity(id, change) {
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
                if (checkbox) {
                    checkbox.dataset.jumlah = currentQty;
                    checkbox.dispatchEvent(new Event('change'));
                }
            } else {
                refreshCartPopup();
            }
        });
}

// --- Hapus keranjang ---
function hapusKeranjang(id) {
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
}

// --- Init on load ---
document.addEventListener('DOMContentLoaded', () => {
    refreshCartPopup();
    document.querySelectorAll('.select-item').forEach(cb => cb.addEventListener('change', updateTotal));
    const selectAll = document.getElementById('select-all');
    if (selectAll) selectAll.addEventListener('change', function () {
        document.querySelectorAll('.select-item').forEach(cb => cb.checked = this.checked);
        updateTotal();
    });
});