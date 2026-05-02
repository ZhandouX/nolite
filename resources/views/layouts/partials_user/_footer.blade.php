<footer class="text-white font-sans px-6 py-10 md:py-14" style="background-color: #000;">

    {{-- DESKTOP: 3 kolom --}}
    <div class="max-w-screen mx-auto hidden md:grid grid-cols-3 items-start gap-10">

        {{-- KOLOM KIRI: FIX DI SINI --}}
        <div class="flex md:flex-row flex-col gap-8 items-start">

            {{-- Quote + Sosmed --}}
            <div class="flex flex-col items-start max-w-[260px]">
                <p class="italic text-sm leading-relaxed text-white">
                    "Born for souls who find solace <br />
                    in the dark, reject the ordinary, <br />
                    and embrace their bold uniqueness."
                </p>

                <div class="flex gap-4 mt-4">
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/wa.png') }}" class="w-full h-full object-cover" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/ig.png') }}" class="w-full h-full object-cover" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/tt.png') }}" class="w-full h-full object-cover" />
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                        <img src="{{ asset('assets/images/icon/shopee.png') }}" class="w-full h-full object-cover" />
                    </a>
                </div>
            </div>

            {{-- Google Maps --}}
            <div class="flex flex-col items-start gap-2 md:ml-12">
                <a href="https://maps.app.goo.gl/2JL1WGFm4Stzkp3z7"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group relative block rounded-xl overflow-hidden border border-white/20 hover:border-white/60 transition-all duration-300 shadow-lg hover:shadow-white/10">

                    <iframe
                        src="https://www.google.com/maps/embed?pb=GANTI_DENGAN_EMBED_URL_ASLI"
                        width="220"
                        height="140"
                        style="border:0; display:block; pointer-events:none;"
                        loading="lazy">
                    </iframe>

                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center">
                        <span class="opacity-0 group-hover:opacity-100 bg-white text-black text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1">
                            <i class="fa-solid fa-location-dot"></i> Buka Maps
                        </span>
                    </div>
                </a>

                <p class="text-[10px] text-white/50">Klik untuk membuka Google Maps</p>
            </div>

        </div>

        {{-- KOLOM TENGAH --}}
        <div class="flex flex-col items-center justify-start pt-2">
            <img src="{{ asset('assets/images/logo/logonolite.png') }}" class="w-24 mb-3 rounded-full" />
            <h2 class="text-3xl font-bold">Nolite Aspiciens</h2>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="flex flex-col items-center">
            <h3 class="text-[18px] font-bold mb-3">Metode Pembayaran</h3>
            <div class="grid grid-cols-5 gap-3 justify-items-center items-center">
                <img src="{{ asset('assets/images/icon/qris.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/ovo.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/dana.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/gopay.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/alfamart.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/indomaret.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/mandiri.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/bri.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/bni.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/bsi.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/bca.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/visa.png') }}" class="footer-pay" />
                <img src="{{ asset('assets/images/icon/mastercard.png') }}" class="footer-pay" />
            </div>
        </div>
    </div>

    {{-- MOBILE --}}
    <div class="flex flex-col md:hidden items-center gap-8 text-center">

        {{-- Logo --}}
        <div class="flex flex-col items-center">
            <img src="{{ asset('assets/images/logo/logonolite.png') }}" class="w-16 mb-3 rounded-full" />
            <h2 class="text-lg font-bold">Nolite Aspiciens</h2>
        </div>

        {{-- Quote --}}
        <div class="flex flex-col items-center">
            <p class="italic text-xs leading-relaxed text-white max-w-[260px]">
                "Born for souls who find solace <br />
                in the dark, reject the ordinary, <br />
                and embrace their bold uniqueness."
            </p>

            <div class="flex gap-4 mt-4 justify-center">
                <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/images/icon/wa.png') }}" />
                </a>
                <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/images/icon/ig.png') }}" />
                </a>
                <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/images/icon/tt.png') }}" />
                </a>
                <a href="#" class="w-9 h-9 rounded-full overflow-hidden hover:scale-110 transition-transform">
                    <img src="{{ asset('assets/images/icon/shopee.png') }}" />
                </a>
            </div>
        </div>

        {{-- Maps --}}
        <div class="flex flex-col items-center gap-2">
            <p class="text-xs font-semibold text-white/80 uppercase tracking-widest">Lokasi Kami</p>

            <a href="https://maps.app.goo.gl/2JL1WGFm4Stzkp3z7"
               target="_blank"
               class="group relative block rounded-xl overflow-hidden border border-white/20">

                <iframe
                    src="https://www.google.com/maps/embed?pb=GANTI_DENGAN_EMBED_URL_ASLI"
                    width="280"
                    height="150"
                    style="border:0; display:block; pointer-events:none;">
                </iframe>
            </a>
        </div>

        {{-- Payment --}}
        <div class="w-full">
            <button id="footerToggle"
                class="w-full bg-black text-white font-semibold flex justify-between items-center py-3 px-4"
                onclick="toggleFooterPayment()">
                Metode Pembayaran
                <i class="fa-solid fa-chevron-up transition-transform duration-300" id="footerIcon"></i>
            </button>

            <div id="footerLogosMobile" class="grid grid-cols-5 gap-2 mt-2 px-4">
                <!-- logo pembayaran tetap -->
            </div>
        </div>
    </div>

    {{-- BOTTOM --}}
    <div class="footer-bottom border-t-2 border-white/30 mt-6 pt-4 text-center">
        <p>&copy; {{ date('Y') }} Nolite Aspiciens. All Rights Reserved.</p>
    </div>

</footer>

{{-- SCRIPT --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const list = document.getElementById("footerLogosMobile");
        const icon = document.getElementById("footerIcon");
        if (window.innerWidth < 768) {
            list.classList.remove("hidden");
            icon.classList.add("rotate-180");
        }
    });

    function toggleFooterPayment() {
        const list = document.getElementById("footerLogosMobile");
        const icon = document.getElementById("footerIcon");
        if (list.classList.contains("hidden")) {
            list.classList.remove("hidden");
            icon.classList.add("rotate-180");
        } else {
            list.classList.add("hidden");
            icon.classList.remove("rotate-180");
        }
    }
</script>
