<div id="chat-container"
    class="hidden z-[10000] fixed bottom-0 right-0 lg:bottom-4 lg:right-4 w-full h-full lg:w-96 lg:h-[450px] bg-white rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 flex flex-col overflow-hidden animate__animated animate__fadeInUp dark:bg-gray-800">

    <!-- Header -->
    <div
        class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-600 bg-black rounded-t-2xl">
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

    <!-- Chat area -->
    <div id="chatbox" class="flex-1 overflow-y-auto p-4 text-sm space-y-3 bg-gray-50 dark:bg-gray-900 scroll-smooth">
        <!-- Welcome Message -->
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

    <!-- Input area -->
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatToggle = document.getElementById("chat-toggle");
        const chatContainer = document.getElementById("chat-container");

        chatToggle.addEventListener("click", () => {
            chatContainer.classList.toggle("hidden");
        });

        const closeChat = document.getElementById("close-chat");
        closeChat.addEventListener("click", () => {
            chatContainer.classList.add("hidden");
        });

        // Chat form functionality for both mobile and desktop
        const chatForm = document.getElementById("chatForm");
        const chatbox = document.getElementById("chatbox");
        const messageInput = document.getElementById("message");

        chatForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const msg = messageInput.value.trim();
            if (!msg) return;

            // Add user message
            chatbox.innerHTML += `
                <div class="flex justify-end">
                    <div class="max-w-[80%]">
                        <div class="bg-primary-500 text-white px-4 py-2 rounded-2xl rounded-br-sm">
                            ${msg}
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block text-right">Sekarang</span>
                    </div>
                </div>
            `;
            
            messageInput.value = "";
            chatbox.scrollTop = chatbox.scrollHeight;

            // Show typing indicator
            const typing = document.createElement("div");
            typing.className = "flex justify-start";
            typing.innerHTML = `
                <div class="max-w-[80%]">
                    <div class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-2xl rounded-bl-sm">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>
            `;
            chatbox.appendChild(typing);
            chatbox.scrollTop = chatbox.scrollHeight;

            try {
                const response = await fetch("{{ route('chatbot.query') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ message: msg })
                });

                const data = await response.json();
                typing.remove();

                const replyText = data.reply || "Maaf, saya tidak menemukan informasi produk.";
                const produkList = data.produk_list || [];

                // Add bot reply
                chatbox.innerHTML += `
                    <div class="flex justify-start">
                        <div class="max-w-[80%]">
                            <div class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-2xl rounded-bl-sm">
                                ${replyText}
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Nolite Bot</span>
                        </div>
                    </div>
                `;

                // Add product cards if available
                if (produkList.length > 0) {
                    const cardsHtml = produkList.map(p => `
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-3 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex gap-3">
                                <img src="${p.foto}" class="w-12 h-12 object-cover rounded-lg" alt="${p.nama_produk}">
                                <div class="flex-1 min-w-0">
                                    <h5 class="font-semibold text-gray-800 dark:text-gray-200 text-sm truncate">${p.nama_produk}</h5>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-gray-600 dark:text-gray-400">${p.ukuran}</span>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">•</span>
                                        <span class="text-xs text-gray-600 dark:text-gray-400">${p.warna}</span>
                                    </div>
                                    <div class="text-primary-600 dark:text-primary-400 font-semibold text-sm mt-1">${p.harga}</div>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-xs mt-2 line-clamp-2">${p.deskripsi}</p>
                            <a href="/produk/${p.id}" 
                               class="block w-full mt-3 text-center bg-primary-500 hover:bg-primary-600 text-white text-xs py-2 rounded-lg transition-colors duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    `).join('');

                    chatbox.innerHTML += `<div class="space-y-3 mt-3">${cardsHtml}</div>`;
                }

                chatbox.scrollTop = chatbox.scrollHeight;

            } catch (error) {
                typing.remove();
                chatbox.innerHTML += `
                    <div class="flex justify-start">
                        <div class="max-w-[80%]">
                            <div class="bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400 px-4 py-2 rounded-2xl rounded-bl-sm">
                                Terjadi kesalahan koneksi ke server.
                            </div>
                        </div>
                    </div>
                `;
                chatbox.scrollTop = chatbox.scrollHeight;
            }
        });

        // Auto-focus input when chat opens
        chatToggle.addEventListener("click", () => {
            setTimeout(() => {
                messageInput.focus();
            }, 300);
        });
    });
</script>