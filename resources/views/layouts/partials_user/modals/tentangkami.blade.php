<div id="aboutModal"
    class="fixed inset-0 z-[999] hidden items-end md:items-center justify-center bg-black/80 backdrop-blur-md px-3 md:px-4 transition-all duration-300">

    <div
        class="bg-gradient-to-br from-[#0a0a0a] via-[#111111] to-[#0a0a0a] text-white w-full md:max-w-2xl rounded-t-2xl md:rounded-2xl shadow-2xl shadow-black/50 p-5 md:p-6 relative max-h-[90vh] flex flex-col overflow-hidden border border-white/10">

        {{-- ORNAMEN BACKGROUND --}}
        <div class="absolute inset-0 opacity-20 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-gray-400 rounded-full blur-[80px]"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-gray-500 rounded-full blur-[80px]"></div>
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0aCBmaWxsPSJub25lIiBzdHJva2U9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiIHN0cm9rZS13aWR0aD0iMSIgZD0iTTAgMGg0MHY0MEgweiIvPjwvc3ZnPg==')] opacity-30">
            </div>
        </div>

        {{-- CLOSE BUTTON --}}
        <button onclick="closeModal('aboutModal')"
            class="absolute top-3 right-3 md:top-4 md:right-4 text-gray-400 hover:text-white hover:bg-white/10 rounded-full w-8 h-8 flex items-center justify-center transition-all duration-200 z-20">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        {{-- LOGO --}}
        <div class="flex justify-center mb-3 md:mb-4 z-10 relative">

            {{-- GLOW --}}
            <div class="absolute inset-0 blur-xl bg-white/20 rounded-full w-20 h-20 mx-auto"></div>

            {{-- WRAPPER BULAT --}}
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-full overflow-hidden relative z-10 border border-white/10">
                <img src="{{ asset('assets/images/logo/logonolite.png') }}" alt="Nolite Aspiciens"
                    class="w-full h-full object-cover">
            </div>

        </div>

        {{-- TITLE --}}
        <h2
            class="text-center text-xl md:text-2xl font-bold tracking-wider mb-2 z-10 bg-gradient-to-r from-gray-200 via-white to-gray-400 bg-clip-text text-transparent">
            Tentang Kami
        </h2>
        <div class="flex justify-center gap-1 mb-3">
            <i class="fas fa-circle text-[6px] text-gray-400/60"></i>
            <i class="fas fa-circle text-[6px] text-gray-400/60"></i>
            <i class="fas fa-circle text-[6px] text-gray-400/60"></i>
        </div>

        {{-- GARIS ORNAMEN --}}
        <div
            class="relative w-24 h-[2px] bg-gradient-to-r from-transparent via-gray-400/60 to-transparent mx-auto mb-5">
            <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-400 rounded-full"></div>
        </div>

        {{-- CONTENT --}}
        <div
            class="text-xs md:text-sm text-gray-300 leading-relaxed space-y-4 md:space-y-5 overflow-y-auto pr-1 md:pr-2 flex-1 z-10 text-justify [&::-webkit-scrollbar]:w-1 [&::-webkit-scrollbar-track]:bg-gray-800/50 [&::-webkit-scrollbar-thumb]:bg-gray-500/50 [&::-webkit-scrollbar-thumb]:rounded-full">

            <p class="indent-6 [&:first-letter]:text-2xl [&:first-letter]:font-bold [&:first-letter]:text-gray-300">
                <strong class="text-white font-semibold">Nolite Aspiciens</strong> adalah brand lokal pakaian yang
                menghadirkan gaya berani dan ekspresif bagi individu yang tidak ingin terikat pada standar umum. Kami
                percaya bahwa setiap orang memiliki identitas unik yang layak untuk ditampilkan tanpa batas.
            </p>

            {{-- QUOTE CARD --}}
            <div
                class="bg-white/5 border-l-4 border-gray-500 p-3 md:p-4 rounded-r-xl my-3 italic text-center text-gray-200 text-xs md:text-sm backdrop-blur-sm">
                <i class="fas fa-quote-left text-gray-400/60 mr-1 text-xs"></i>
                “Born for souls who find solace in the dark, reject the ordinary, and embrace their bold uniqueness.”
                <i class="fas fa-quote-right text-gray-400/60 ml-1 text-xs align-top"></i>
            </div>

            <p class="indent-6 flex items-start gap-2">
                <i class="fas fa-skull text-gray-400/70 mt-1 text-sm"></i>
                <span>Terinspirasi dari konsep <span class="italic font-medium text-white">dark aesthetic</span> dan
                    kebebasan berekspresi, kami menghadirkan ruang bagi mereka yang nyaman dalam perbedaan dan berani
                    menolak hal yang biasa.</span>
            </p>

            <p class="indent-6 flex items-start gap-2">
                <i class="fas fa-pen-fancy text-gray-400/70 mt-1 text-sm"></i>
                <span>Setiap desain kami dibuat untuk merepresentasikan karakter yang kuat, misterius, dan autentik —
                    bukan sekadar pakaian, tetapi identitas.</span>
            </p>

            <p class="indent-6 flex items-start gap-2">
                <i class="fas fa-comment-dots text-gray-400/70 mt-1 text-sm"></i>
                <span>Kami percaya fashion adalah bentuk komunikasi tanpa kata, dan Nolite Aspiciens hadir untuk mereka
                    yang ingin tampil berbeda dan tetap menjadi diri sendiri.</span>
            </p>

            <p class="indent-6 flex items-start gap-2">
                <i class="fas fa-globe-asia text-gray-400/70 mt-1 text-sm"></i>
                <span>Sebagai brand lokal, kami berkomitmen untuk terus berkembang dan mendukung kreativitas dalam
                    negeri.</span>
            </p>

            {{-- LOKASI --}}
            <div class="pt-3 mt-2 border-t border-gray-700/70">
                <div class="bg-black/40 rounded-xl p-3 backdrop-blur-sm border border-white/5 text-center">

                    <div class="flex items-center justify-center gap-2 mb-2">
                        <i class="fas fa-map-pin text-gray-400 text-sm"></i>
                        <p class="text-gray-300 text-[11px] md:text-xs font-medium tracking-wide">
                            📍 Berlokasi di:
                        </p>
                    </div>

                    <p class="text-gray-200 text-[11px] md:text-xs leading-relaxed">
                        Jl. Bougenville Raya No.50, Paropo,<br>
                        Kec. Panakkukang, Kota Makassar,<br>
                        Sulawesi Selatan 90231
                    </p>

                    <div class="flex justify-center gap-2 mt-2 text-[10px] text-gray-400">
                        <span class="bg-white/5 px-2 py-0.5 rounded-full">
                            <i class="far fa-clock mr-1"></i> Senin - Sabtu
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
