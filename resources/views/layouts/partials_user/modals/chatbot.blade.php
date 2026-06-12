<div id="chat-container"
    class="hidden z-[10000] fixed inset-0 lg:inset-auto lg:bottom-4 lg:right-4
           w-full lg:w-96 lg:h-[450px]
           bg-white lg:rounded-2xl shadow-2xl
           flex flex-col overflow-hidden
           animate__animated animate__fadeInUp
           dark:bg-gray-800">

    {{-- ================= HEADER ================= --}}
    <div
        class="flex items-center justify-between p-4
               border-b border-gray-200 dark:border-gray-600
               bg-black lg:rounded-t-2xl shrink-0">

        <div class="flex items-center gap-3">

            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-robot text-white text-sm"></i>
            </div>

            <div>
                <h4 class="text-white font-semibold text-sm">
                    Chat Nolite
                </h4>

                <p class="text-primary-100 text-xs">
                    <span class="text-green-600">Online</span>
                    • Siap membantu
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">

            <<button id="open-history"
                class="relative text-white/80 hover:text-white
           px-3 py-1.5 rounded-full hover:bg-white/10
           flex items-center gap-2 text-xs">

                <i class="fa-solid fa-clock-rotate-left text-sm"></i>

                <span class="hidden sm:inline">
                    Riwayat
                </span>

                <span id="chat-notification"
                    class="hidden absolute -top-1 -right-1
               min-w-[18px] h-[18px]
               px-1 text-[10px]
               bg-red-500 text-white
               rounded-full flex items-center justify-center">
                </span>
                </button>

                <button id="close-chat"
                    class="text-white w-8 h-8 flex items-center justify-center
                       rounded-full hover:bg-white/10">

                    &times;
                </button>
        </div>
    </div>

    {{-- ================= CHAT MAIN ================= --}}
    <div id="chat-main" class="flex flex-col flex-1 min-h-0">

        {{-- CHATBOX (ONLY SCROLL AREA) --}}
        <div id="chatbox"
            class="flex-1 min-h-0 overflow-y-auto
                   p-4 text-sm space-y-3
                   bg-gray-50 dark:bg-gray-900
                   overscroll-contain">

            <div class="text-center mt-8">

                <div
                    class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600
                            rounded-full flex items-center justify-center mx-auto mb-3">

                    <i class="fa-solid fa-robot text-white text-2xl"></i>
                </div>

                <h4 class="text-gray-700 dark:text-gray-300 font-semibold text-sm mb-1">
                    Hai, {{ auth()->user()->name ?? 'Pelanggan Nolite' }}! 👋
                </h4>

                <p class="text-gray-500 dark:text-gray-400 text-xs px-4">
                    Tanya tentang produk Nolite Aspicience yuk! 😊
                </p>

            </div>
        </div>
    </div>

    {{-- ================= HISTORY ================= --}}
    <div id="history-box" class="hidden flex-col flex-1 min-h-0
               bg-gray-50 dark:bg-gray-900">

        <div
            class="flex items-center gap-3 p-4
                    border-b border-gray-200 dark:border-gray-700 shrink-0">

            <button id="back-to-chat"
                class="w-8 h-8 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700
                       flex items-center justify-center">

                <i class="fa-solid fa-arrow-left text-sm"></i>
            </button>

            <h4 class="font-semibold text-sm">
                Riwayat Chat
            </h4>
        </div>

        <div id="history-content"
            class="flex-1 min-h-0 overflow-y-auto
                   p-4 space-y-3 text-sm
                   overscroll-contain">
        </div>
    </div>

    {{-- ================= INPUT ================= --}}
    <div
        class="p-4 border-t border-gray-200 dark:border-gray-700
                    bg-white dark:bg-gray-800 shrink-0">

        <form id="chatForm" class="flex items-center gap-2">

            <input type="text" id="message"
                class="flex-1 px-4 py-3 text-sm rounded-xl
                           bg-gray-100 dark:bg-gray-700
                           text-gray-700 dark:text-gray-300
                           focus:outline-none focus:ring-2 focus:ring-gray-500"
                placeholder="Ketik pertanyaanmu...">

            <button type="submit" class="bg-gray-600 text-white p-3 rounded-xl hover:bg-gray-700">

                <i class="fa-solid fa-paper-plane text-sm"></i>
            </button>

        </form>
    </div>

</div>
