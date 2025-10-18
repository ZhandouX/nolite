function updateCartBadge() {
    fetch("{{ route('keranjang.count') }}") // Pastikan route ini ada di web.php
        .then(res => res.json())
        .then(data => {
            const badge = document.querySelector('#cartBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        })
        .catch(err => console.error('Error update badge:', err));
}