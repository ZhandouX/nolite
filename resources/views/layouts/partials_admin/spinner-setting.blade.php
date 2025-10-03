{{-- GEAR BUBBLE --}}
<div class="gear-bubble-wrapper">
    <!-- ICON BUBBLE GEAR -->
    <div class="gear-bubble" id="gearBubble">
        <i class="fa fa-gear icon-xl spinner-border"></i>
    </div>

    <!-- POPUP CARD -->
    <div class="gear-popup shadow" id="gearPopup">
        <div class="popup-header text-center">
            <p class="mb-1 fw-bold">ACTIONS</p>
            <button type="button" class="btn-close text-danger" id="closeGearPopup" aria-label="Close"></button>
        </div>

        <div class="popup-body">
            {{-- THEME SWITCHER --}}
            <div class="popup-item d-flex align-items-center justify-content-between">
                <span class="popup-label"><i class="fa fa-leaf text-primary me-2"></i>Pilih Tema</span>
                <div class="theme-options d-flex align-items-center gap-2">
                    <!-- DARK -->
                    <button type="button" class="theme-btn dark-btn" title="Dark Mode"
                        onclick="window.themeManager.setTheme('dark')"></button>
                        
                    <!-- LIGHT -->
                    <button type="button" class="theme-btn light-btn" title="Light Mode"
                        onclick="window.themeManager.setTheme('light')"></button>

                    <!-- GRADIENT -->
                    <button type="button" class="theme-btn gradient-btn" title="Gradient Mode"
                        onclick="window.themeManager.setTheme('gradient')"></button>

                    <!-- PURPLE -->
                    <!-- <button type="button" class="theme-btn purple-btn" title="Purple Mode"
                        onclick="window.themeManager.setTheme('purple')"></button> -->
                </div>
            </div>

            {{-- TAMBAH BERITA --}}
            <a href="{{ route('admin.produk.create') }}" class="popup-item d-flex align-items-center">
                <span class="popup-label"><i class="fa fa-plus text-primary me-2"></i>Tambah Produk</span>
            </a>

            {{-- LIHAT BERITA --}}
            <a href="{{ route('admin.produk.index') }}" class="popup-item d-flex align-items-center">
                <span class="popup-label"><i class="fa fa-list text-primary me-2"></i>Lihat Produk</span>
            </a>
        </div>
    </div>
</div>

<!-- JS SPINNER ACTIONS -->
<script>
    const gearBubble = document.getElementById('gearBubble');
    const gearPopup = document.getElementById('gearPopup');
    const closeBtn = document.getElementById('closeGearPopup');

    // Toggle popup
    gearBubble.addEventListener('click', () => {
        gearPopup.style.display = gearPopup.style.display === 'flex' ? 'none' : 'flex';
    });

    // Close popup
    closeBtn.addEventListener('click', () => {
        gearPopup.style.display = 'none';
    });

    // Tutup popup kalau klik di luar
    document.addEventListener('click', function (event) {
        if (!gearPopup.contains(event.target) && !gearBubble.contains(event.target)) {
            gearPopup.style.display = 'none';
        }
    });
</script>