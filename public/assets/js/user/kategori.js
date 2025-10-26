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

    // FILTER MODAL MOBILE
    const mobileOpenFilterBtn = document.getElementById('mobileOpenFilterBtn');
    const mobileFilterModal = document.getElementById('mobileFilterModal');
    const closeMobileFilterBtn = document.getElementById('closeMobileFilterBtn');

    mobileOpenFilterBtn.addEventListener('click', () => mobileFilterModal.classList.remove('hidden'));
    closeMobileFilterBtn.addEventListener('click', () => mobileFilterModal.classList.add('hidden'));
    mobileFilterModal.addEventListener('click', e => {
        if (e.target === mobileFilterModal) mobileFilterModal.classList.add('hidden');
    });

    // SORT MODAL (Mobile)
    const openSortBtn = document.getElementById('openSortBtn');
    const sortModal = document.getElementById('sortModal');
    const closeSortModal = document.getElementById('closeSortModal');

    openSortBtn.addEventListener('click', () => sortModal.classList.remove('hidden'));
    closeSortModal.addEventListener('click', () => sortModal.classList.add('hidden'));
    sortModal.addEventListener('click', e => {
        if (e.target === sortModal) sortModal.classList.add('hidden');
    });

    // WISHLIST TOGGLE
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
                if (data.status === 'added') {
                    icon.classList.remove('text-gray-300');
                    icon.classList.add('text-red-500');
                } else {
                    icon.classList.remove('text-red-500');
                    icon.classList.add('text-gray-300');
                }
            })
            .catch(err => console.error(err));
    };

    // CATEGORY RADIO TOGGLE
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

});