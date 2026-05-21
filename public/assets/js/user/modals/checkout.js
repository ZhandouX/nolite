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

document.addEventListener('click', e => {
    // WARNA
    if (e.target.closest('.color-btn')) {
        const btn = e.target.closest('.color-btn');
        const itemId = btn.dataset.item;
        document.querySelectorAll(`[data-item="${itemId}"].color-btn`)
            .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
        btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
        document.getElementById(`selectedColor-${itemId}`).value = btn.dataset.color;
        checkBeliReady(itemId);
    }

    // UKURAN
    if (e.target.closest('.size-btn')) {
        const btn = e.target.closest('.size-btn');
        const itemId = btn.dataset.item;
        document.querySelectorAll(`[data-item="${itemId}"].size-btn`)
            .forEach(b => b.classList.remove('ring', 'ring-blue-400', 'bg-gray-100'));
        btn.classList.add('ring', 'ring-blue-400', 'bg-gray-100');
        document.getElementById(`selectedSize-${itemId}`).value = btn.dataset.size;
        checkBeliReady(itemId);
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

function validateQty(input) {
    const min = parseInt(input.min);
    const max = parseInt(input.max);
    let val = parseInt(input.value);
    if (isNaN(val) || val < min) input.value = min;
    if (val > max) input.value = max;
}

// Tampilkan tombol hanya jika warna & ukuran sudah dipilih
function checkBeliReady(itemId) {
    const warna  = document.getElementById(`selectedColor-${itemId}`).value;
    const ukuran = document.getElementById(`selectedSize-${itemId}`).value;
    const btn    = document.getElementById(`btnBeli-${itemId}`);

    if (!btn) return;

    if (warna && ukuran) {

        // aktifkan tombol
        btn.disabled = false;

        btn.classList.remove(
            'bg-gray-300',
            'cursor-not-allowed'
        );

        btn.classList.add(
            'bg-gray-600',
            'hover:bg-gray-400'
        );

    } else {

        // nonaktifkan tombol
        btn.disabled = true;

        btn.classList.remove(
            'bg-gray-600',
            'hover:bg-gray-400'
        );

        btn.classList.add(
            'bg-gray-300',
            'cursor-not-allowed'
        );
    }
}
function submitBeliForm(itemId) {
    document.getElementById(`formBeli-${itemId}`).submit();
}
