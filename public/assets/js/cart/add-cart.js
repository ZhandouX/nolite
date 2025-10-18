function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal(id);
        });
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.add('hidden');
}

function addToCart(id) {
    const warna = document.querySelector(`#selectedColor-${id}`)?.value;
    const ukuran = document.querySelector(`#selectedSize-${id}`)?.value;
    const qty = document.querySelector(`#qty-${id}`)?.value || 1;

    if (!warna || !ukuran) {
        alert('Silakan pilih warna dan ukuran terlebih dahulu!');
        return;
    }

    if (!warna || !ukuran) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Varian Dulu!',
            text: 'Silakan pilih warna dan ukuran sebelum menambahkan ke keranjang.',
            confirmButtonColor: '#3b82f6',
            background: '#fff',
            color: '#374151',
            iconColor: '#facc15',
        });
        return;
    }

    fetch("{{ route('keranjang.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            produk_id: id,
            warna: warna,
            ukuran: ukuran,
            jumlah: qty
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.error,
                    background: '#fff',
                    color: '#374151',
                    confirmButtonColor: '#ef4444',
                    iconColor: '#ef4444'
                });
            } else {
                Swal.fire({
                    title: 'Berhasil!',
                    text: data.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    position: 'top-end',
                    toast: true,
                    background: '#ffffff',
                    color: '#333',
                    iconColor: '#22c55e',
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' }
                });
                closeModal(`productModal-${id}`);
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: 'Gagal menambahkan produk ke keranjang.',
                background: '#fff',
                color: '#374151',
                confirmButtonColor: '#ef4444',
                iconColor: '#ef4444'
            });
            console.error(err);
        });
}

document.addEventListener('click', e => {
    if (e.target.closest('.color-btn')) {
        const btn = e.target.closest('.color-btn');
        const itemId = btn.dataset.item;
        document.querySelectorAll(`[data-item="${itemId}"].color-btn`)
            .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
        btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
        document.getElementById(`selectedColor-${itemId}`).value = btn.dataset.color;
    }

    if (e.target.closest('.size-btn')) {
        const btn = e.target.closest('.size-btn');
        const itemId = btn.dataset.item;
        document.querySelectorAll(`[data-item="${itemId}"].size-btn`)
            .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
        btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
        document.getElementById(`selectedSize-${itemId}`).value = btn.dataset.size;
    }
});

function decreaseQty(id) {
    const input = document.getElementById(`qty-${id}`);
    const min = parseInt(input.min);
    let value = parseInt(input.value);
    if (value > min) input.value = value - 1;
}

function increaseQty(id, max) {
    const input = document.getElementById(`qty-${id}`);
    const value = parseInt(input.value);
    if (value < max) input.value = value + 1;
}

document.addEventListener('input', e => {
    if (e.target.matches('input[id^="qty-"]')) {
        const input = e.target;
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        let val = parseInt(input.value);

        if (isNaN(val) || val < min) input.value = min;
        if (val > max) input.value = max;
    }
});

function updateQty(btn, change) {
    const parent = btn.closest('div');
    const input = parent.querySelector('input[type="number"]');
    const max = parseInt(input.max);
    const min = parseInt(input.min);
    let value = parseInt(input.value) || 1;

    value += change;
    if (value < min) value = min;
    if (value > max) value = max;

    input.value = value;
}

function incrementQty(itemId) {
    const input = document.getElementById(`qty-${itemId}`);
    const currentValue = parseInt(input.value) || 1;
    input.value = currentValue + 1;
    input.classList.add('ring-2', 'ring-green-400');
    setTimeout(() => {
        input.classList.remove('ring-2', 'ring-green-400');
    }, 200);
}

function decrementQty(itemId) {
    const input = document.getElementById(`qty-${itemId}`);
    const currentValue = parseInt(input.value) || 1;

    if (currentValue > 1) {
        input.value = currentValue - 1;

        input.classList.add('ring-2', 'ring-red-400');
        setTimeout(() => {
            input.classList.remove('ring-2', 'ring-red-400');
        }, 200);
    }
}

function validateQty(itemId) {
    const input = document.getElementById(`qty-${itemId}`);
    const value = parseInt(input.value);

    if (isNaN(value) || value < 1) {
        input.value = 1;
    }
}