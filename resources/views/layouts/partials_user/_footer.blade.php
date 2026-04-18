<footer class="text-white font-sans px-6 py-10 md:py-14" style="background-color: #000;">
    <div class="max-w-screen mx-auto flex flex-col md:flex-row justify-between items-center md:items-start gap-10 text-center md:text-left">

        {{-- LEFT FOOTER --}}
        <div class="flex-1 min-w-[220px] flex flex-col items-center md:items-start ml-0 lg:-ml-2">
            <p class="italic text-xs md:text-sm leading-relaxed text-white max-w-[260px]">
                “Born for souls who find solace <br />
                in the dark, reject the ordinary, <br />
                and embrace their bold uniqueness.”
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

        {{-- CENTER FOOTER --}}
        <div class="text-center flex flex-col items-center md:relative md:-top-8">
            <img src="{{ asset('assets/images/logo/logonolite.png') }}" class="w-16 md:w-24 mb-3" />
            <h2 class="text-lg md:text-3xl font-bold">Nolite Aspiciens</h2>
        </div>

        {{-- RIGHT FOOTER --}}
        <div class="flex-1 min-w-[250px] flex flex-col items-center text-center">

            {{-- MOBILE BUTTON --}}
            <button id="footerToggle"
                class="w-full bg-black text-white font-semibold flex justify-between items-center py-3 px-4 text-[16px] cursor-pointer md:hidden"
                onclick="toggleFooterPayment()">
                Metode Pembayaran
                <i class="fa-solid fa-chevron-up transition-transform duration-300" id="footerIcon"></i>
            </button>

            {{-- MOBILE PAYMENT LOGOS (default terbuka) --}}
            <div id="footerLogosMobile" class="grid grid-cols-5 gap-2 mt-2 px-4 md:hidden">
                <img src="{{ asset('assets/images/icon/qris.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/ovo.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/dana.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/gopay.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/alfamart.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/indomaret.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/mandiri.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/bri.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/bni.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/bsi.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/bca.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/visa.png') }}" class="footer-pay w-10 h-10 object-contain" />
                <img src="{{ asset('assets/images/icon/mastercard.png') }}" class="footer-pay w-10 h-10 object-contain" />
            </div>

            {{-- DESKTOP PAYMENT --}}
            <div class="hidden md:flex md:flex-col w-full">
                <h3 class="text-[18px] font-bold mb-3 ml-4">Metode Pembayaran</h3>

                <div id="footerLogosDesktop" class="grid grid-cols-5 gap-5 justify-items-start items-center pl-20">
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
    </div>

    {{-- BOTTOM --}}
    <div class="footer-bottom border-t-2 border-white/30 mt-6 pt-4">
        <p>&copy; {{ date('Y') }} Nolite Aspiciens. All Rights Reserved.</p>
    </div>
</footer>

{{-- SCRIPT --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const list = document.getElementById("footerLogosMobile");
        const icon = document.getElementById("footerIcon");

        // Mobile → auto open
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
