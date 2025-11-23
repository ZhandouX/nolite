function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

async function loadProductModals(productId) {
    // Cek jika modal sudah ada
    if (document.getElementById(`productModal-${productId}`)) return;

    try {
        const response = await fetch(`${window.ModalGlobal.routes.modals}/${productId}`);
        const html = await response.text();
        document.getElementById('dynamicModalsContainer').innerHTML += html;

        // Render ulang icon Lucide (bundler)
        createIcons({ icons: window.lucideIcons });

    } catch (error) {
        console.error('Error loading modals:', error);
    }
}

// Override openModal function untuk handle dynamic loading
const originalOpenModal = window.openModal;
window.openModal = async function (modalId) {
    const productId = modalId.match(/\d+/)[0];

    // Load modal jika belum ada
    await loadProductModals(productId);

    // Tunggu sebentar untuk memastikan modal sudah di-inject
    setTimeout(() => {
        if (originalOpenModal) {
            originalOpenModal(modalId);
        } else {
            // Fallback jika function asli tidak ada
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeModal(modalId);
                });
            }
        }
    }, 100);
};