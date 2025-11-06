<!-- Chat toggle button -->
<button id="chat-toggle" title="Chat Produk Nolite"
    class="w-12 h-12 bg-gray-400 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-600 hover:scale-110 transition-all duration-500 opacity-0 translate-y-6 pointer-events-none">
    <i class="fa-solid fa-robot text-lg"></i>
</button>

<!-- Mobile chat container full screen -->
<div id="chat-container"
    class="hidden z-[9999] fixed inset-0 sm:hidden bg-white rounded-t-3xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden animate__animated animate__fadeInUp">

    <!-- Header -->
    <div
        class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-gray-700 to-gray-600 rounded-t-3xl">
        <h4 class="text-white font-semibold text-sm flex items-center gap-2">
            <i class="fa-solid fa-robot text-gray-200"></i> Chat Nolite
        </h4>
        <button id="close-chat" class="text-white hover:text-gray-300 text-lg leading-none transition">&times;</button>
    </div>

    <!-- Chat area -->
    <div id="chatbox" class="flex-1 overflow-y-auto p-4 text-sm space-y-3 bg-gray-50 scroll-smooth">
        <div class="text-gray-400 text-center text-xs mt-10">
            💬 Hai! Tanya tentang produk Nolite Aspicience yuk 😊
        </div>
    </div>

    <!-- Floating input -->
    <div class="p-4 border-t border-gray-200 bg-white">
        <form id="chatForm" class="flex items-center bg-white rounded-2xl shadow-md border border-gray-200 p-2">
            <input type="text" id="message"
                class="flex-1 px-4 py-3 text-sm focus:outline-none focus:ring-0 text-gray-700 placeholder-gray-400 rounded-2xl"
                placeholder="Ketik pertanyaanmu...">
            <button type="submit"
                class="bg-gray-700 text-white px-5 py-2 ml-2 rounded-2xl hover:bg-gray-600 transition">
                Kirim
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chatToggle = document.getElementById("chat-toggle");
        const chatContainer = document.getElementById("chat-container");

        // Cek viewport
        const isMobile = window.innerWidth < 640; // Tailwind sm breakpoint = 640px

        chatToggle.addEventListener("click", () => {
            if (isMobile) {
                // Mobile -> popup
                chatContainer.classList.toggle("hidden");
            } else {
                // Desktop -> redirect ke halaman chatbot
                window.location.href = "{{ route('chatbot.view') }}";
            }
        });

        // Tombol close hanya untuk mobile
        const closeChat = document.getElementById("close-chat");
        closeChat.addEventListener("click", () => {
            chatContainer.classList.add("hidden");
        });

        // Chat form untuk mobile (hanya aktif kalau mobile)
        if (isMobile) {
            const chatForm = document.getElementById("chatForm");
            const chatbox = document.getElementById("chatbox");
            const messageInput = document.getElementById("message");

            chatForm.addEventListener("submit", async (e) => {
                e.preventDefault();
                const msg = messageInput.value.trim();
                if (!msg) return;

                chatbox.innerHTML += `
                <div class="text-right">
                    <span class="bg-gray-200 px-3 py-1 rounded-lg inline-block text-gray-800">${msg}</span>
                </div>
            `;
                messageInput.value = "";
                chatbox.scrollTop = chatbox.scrollHeight;

                const typing = document.createElement("div");
                typing.className = "text-left text-gray-400 italic animate-pulse";
                typing.innerText = "Bot sedang mengetik...";
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

                    chatbox.innerHTML += `
                    <div class="text-left">
                        <span class="bg-gray-100 px-3 py-2 rounded-lg inline-block text-gray-700 leading-relaxed">${replyText}</span>
                    </div>
                `;

                    if (produkList.length > 0) {
                        const cardsHtml = produkList.map(p => `
                        <a href="/produk/${p.id}" class="flex items-center gap-3 p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            <img src="${p.foto}" class="w-16 h-16 object-cover rounded" alt="${p.nama_produk}">
                            <div class="flex-1 text-sm">
                                <div class="font-semibold text-gray-700">${p.nama_produk}</div>
                                <div class="text-gray-500 text-xs">Ukuran: ${p.ukuran}</div>
                                <div class="text-gray-500 text-xs">Warna: ${p.warna}</div>
                                <div class="text-gray-700 font-medium text-sm">${p.harga}</div>
                                <div class="text-gray-600 text-xs mt-1">${p.deskripsi}</div>
                            </div>
                        </a>
                    `).join('');

                        chatbox.innerHTML += `<div class="space-y-2 mt-2">${cardsHtml}</div>`;
                    }

                    chatbox.scrollTop = chatbox.scrollHeight;

                } catch (error) {
                    typing.remove();
                    chatbox.innerHTML += `
                    <div class="text-left text-red-600">
                        <span class="bg-red-100 px-2 py-1 rounded-lg inline-block">Terjadi kesalahan koneksi ke server.</span>
                    </div>
                `;
                }
            });
        }
    });
</script>