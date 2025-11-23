<div id="chat-container"
    class="hidden z-[10000] fixed bottom-0 right-0 lg:bottom-4 lg:right-4 w-full h-full lg:w-96 lg:h-[450px] bg-white lg:rounded-2xl shadow-2xl flex flex-col overflow-hidden animate__animated animate__fadeInUp dark:bg-gray-800">

    {{-- HEADER --}}
    <div
        class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-600 bg-black lg:rounded-t-2xl">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-robot text-white text-sm"></i>
            </div>
            <div>
                <h4 class="text-white font-semibold text-sm">Chat Nolite</h4>
                <p class="text-primary-100 text-xs"><span class="text-green-600">Online</span> • Siap membantu</p>
            </div>
        </div>
        <button id="close-chat" class="text-white hover:text-primary-200 text-lg leading-none transition-colors duration-200 w-6 h-6 flex items-center justify-center rounded-full hover:bg-white/10">
            &times;
        </button>
    </div>

    {{-- CHAT AREA --}}
    <div id="chatbox" class="flex-1 overflow-y-auto p-4 text-sm space-y-3 bg-gray-50 dark:bg-gray-900 scroll-smooth">
        <div class="text-center mt-8">
            <div class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-robot text-white text-2xl"></i>
            </div>
            <h4 class="text-gray-700 dark:text-gray-300 font-semibold text-sm mb-1">Hai, {{ auth()->user()->name ?? 'Pelanggan Nolite' }}! 👋</h4>
            <p class="text-gray-500 dark:text-gray-400 text-xs px-4">
                Tanya tentang produk Nolite Aspicience yuk! 😊
            </p>
        </div>
    </div>

    {{-- INPUT AREA --}}
    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <form id="chatForm" class="flex items-center gap-2">
            <div class="flex-1 relative">
                <input type="text" id="message"
                    class="w-full px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 text-gray-700 dark:text-gray-300 placeholder-gray-500 dark:placeholder-gray-400 rounded-xl bg-gray-100 dark:bg-gray-700 border border-transparent focus:border-gray-500 transition-all duration-200"
                    placeholder="Ketik pertanyaanmu...">
            </div>
            <button type="submit"
                class="bg-gray-600 text-white p-3 rounded-xl hover:bg-gray-600 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center min-w-[44px]">
                <i class="fa-solid fa-paper-plane text-sm"></i>
            </button>
        </form>
    </div>
</div>