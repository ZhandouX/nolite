const toggleBtn = document.getElementById("payment-toggle");
const dropdown = document.getElementById("payment-options");
const selectedMethod = document.getElementById("selected-method");
const metodeInput = document.getElementById("metode-pembayaran-input");

toggleBtn.addEventListener("click", () => dropdown.classList.toggle("hidden"));
function selectMethod(method) {
    selectedMethod.textContent = method;
    metodeInput.value = method;
    dropdown.classList.add("hidden");
}
window.addEventListener("click", (e) => {
    if (!toggleBtn.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add("hidden");
});

document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggle-items-btn');
    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', function () {
        const extras = document.querySelectorAll('.extra-item');
        const isHidden = extras[0].classList.contains('hidden');
        extras.forEach(el => el.classList.toggle('hidden'));
        toggleBtn.textContent = isHidden ? 'Tutup ▲' : 'Lihat Lebih Banyak ▼';
    });
});

document.getElementById('provinsi').addEventListener('change', function () {
    const provinsi = this.value;
    const kotaSelect = document.getElementById('kota');
    kotaSelect.innerHTML = '<option value="">Memuat...</option>';

    fetch(`${window.CheckoutForm.routes.kota}?provinsi=${encodeURIComponent(provinsi)}`)
        .then(res => res.json())
        .then(data => {
            kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
            data.forEach(kota => {
                const option = document.createElement('option');
                option.value = kota;
                option.text = kota;
                kotaSelect.appendChild(option);
            });
        });
});