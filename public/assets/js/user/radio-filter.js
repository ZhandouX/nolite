document.addEventListener('DOMContentLoaded', () => {
    const radios = document.querySelectorAll('#filterTipeForm input[name="tipe"]');
    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            switch (radio.value) {
                case 'all':
                    window.location.href = window.RadioSwitch.routes.allProduk;
                    break;
                case 'unggulan':
                    window.location.href = window.RadioSwitch.routes.unggulan;
                    break;
                case 'diskon':
                    window.location.href = window.RadioSwitch.routes.diskon;
                    break;
            }
        });
    });
});