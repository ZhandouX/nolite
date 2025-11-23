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