document.addEventListener('DOMContentLoaded', function () {

    // PAYMENT DROPDOWN
    const toggleBtn = document.getElementById("payment-toggle");
    const dropdown = document.getElementById("payment-options");

    if (toggleBtn && dropdown) {
        toggleBtn.addEventListener("click", () => dropdown.classList.toggle("hidden"));

        window.addEventListener("click", (e) => {
            if (!toggleBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });
    }

    // PROVINSI → KOTA
    const provinsiEl = document.getElementById('provinsi');

    if (provinsiEl) {
        provinsiEl.addEventListener('change', function () {
            const provinsi = this.value;
            const kotaSelect = document.getElementById('kota');

            kotaSelect.innerHTML = '<option value="">Memuat...</option>';

            fetch(`/get-kota?provinsi=${encodeURIComponent(provinsi)}`)
                .then(res => res.json())
                .then(data => {
                    kotaSelect.innerHTML = '<option value="">-- Pilih Kota --</option>';

                    data.forEach(kota => {
                        const option = document.createElement('option');
                        option.value = kota;
                        option.text = kota;
                        kotaSelect.appendChild(option);
                    });
                })
                .catch(err => {
                    console.error(err);
                    kotaSelect.innerHTML = '<option value="">Gagal load data</option>';
                });
        });
    }

});