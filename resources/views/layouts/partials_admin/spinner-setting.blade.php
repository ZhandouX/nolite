<div class="gear-bubble-wrapper">
    {{-- ICON --}}
    <div class="gear-bubble" id="gearBubble">
        <i class="fa fa-gear icon-xl spinner-border"></i>
    </div>

    {{-- POPUP CARD --}}
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
                    {{-- DARK --}}
                    <button type="button" class="theme-btn dark-btn" title="Dark Mode"
                        onclick="window.themeManager.setTheme('dark')"></button>

                    {{-- LIGHT --}}
                    <button type="button" class="theme-btn light-btn" title="Light Mode"
                        onclick="window.themeManager.setTheme('light')"></button>
                </div>
            </div>

            {{-- CREATE PRODUCT DATA --}}
            <a href="{{ route('admin.produk.create') }}" class="popup-item d-flex align-items-center">
                <span class="popup-label"><i class="fa fa-plus text-primary me-2"></i>Tambah Produk</span>
            </a>

            {{-- SHOW PRODUCT --}}
            <a href="{{ route('admin.produk.index') }}" class="popup-item d-flex align-items-center">
                <span class="popup-label"><i class="fa fa-list text-primary me-2"></i>Lihat Produk</span>
            </a>
        </div>
    </div>
</div>

{{-- JS: SPINNER ACTIONS --}}
<script src="/assets/js/admin/main.js"></script>