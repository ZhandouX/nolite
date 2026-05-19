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

    const chatForm = document.getElementById("chatForm");
    const chatbox = document.getElementById("chatbox");
    const messageInput = document.getElementById("message");

    // HISTORY
    const openHistory = document.getElementById("open-history");
    const backToChat = document.getElementById("back-to-chat");
    const historyBox = document.getElementById("history-box");
    const historyContent = document.getElementById("history-content");

    // NOTIFICATION
    const notificationBadge = document.getElementById("chat-notification");

    let autoScroll = true;

    // Deteksi scroll manual
    chatbox.addEventListener("scroll", () => {
        const distanceFromBottom =
            chatbox.scrollHeight - chatbox.scrollTop - chatbox.clientHeight;
        autoScroll = distanceFromBottom < 100;
    });

    function scrollToBottom() {
        if (autoScroll) {
            chatbox.scrollTop = chatbox.scrollHeight;
        }
    }

    // ✅ Helper: buat elemen dari HTML string tanpa ganggu scroll
    function createEl(html) {
        const div = document.createElement("div");
        div.innerHTML = html.trim();
        return div.firstChild;
    }

    // ✅ Helper: append ke chatbox lalu scroll
    function appendToChat(html) {
        const el = createEl(html);
        chatbox.appendChild(el);
        scrollToBottom();
    }

    chatForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const msg = messageInput.value.trim();
        if (!msg) return;

        // Sanitasi input untuk hindari XSS
        const safe = document.createElement("span");
        safe.textContent = msg;
        const safeMsgHtml = safe.innerHTML;

        // Append pesan user — pakai appendChild bukan innerHTML+=
        appendToChat(`
            <div class="flex justify-end">
                <div class="max-w-[80%]">
                    <div class="bg-primary-500 text-white px-4 py-2 rounded-2xl rounded-br-sm">
                        ${safeMsgHtml}
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block text-right">Sekarang</span>
                </div>
            </div>
        `);

        messageInput.value = "";
        autoScroll = true;
        scrollToBottom();

        // Typing indicator
        const typing = createEl(`
            <div class="flex justify-start">
                <div class="max-w-[80%]">
                    <div class="bg-gray-200 dark:bg-gray-700 px-4 py-2 rounded-2xl rounded-bl-sm">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>
            </div>
        `);
        chatbox.appendChild(typing);
        scrollToBottom();

        try {
            const response = await fetch(window.Chatbot.routes.chatbotAsk, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.Chatbot.csrf,
                },
                body: JSON.stringify({ message: msg }),
            });

            const data = await response.json();
            typing.remove();

            const replyText =
                data.reply || "Maaf, saya tidak menemukan informasi produk.";
            const produkList = data.produk_list || [];

            // Append balasan bot
            appendToChat(`
                <div class="flex justify-start">
                    <div class="max-w-[80%]">
                        <div class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-2xl rounded-bl-sm">
                            ${replyText}
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Nolite Bot</span>
                    </div>
                </div>
            `);

            // Append product cards jika ada
            if (produkList.length > 0) {
                const cardsWrapper = document.createElement("div");
                cardsWrapper.className = "space-y-3 mt-3";

                produkList.forEach((p) => {
                    const card = createEl(`
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
                            <a href="${window.Chatbot.routes.productAct}/${p.id}"
                               class="block w-full mt-3 text-center bg-primary-500 hover:bg-primary-600 text-white text-xs py-2 rounded-lg transition-colors duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    `);
                    cardsWrapper.appendChild(card);
                });

                chatbox.appendChild(cardsWrapper);
                scrollToBottom();
            }
        } catch (error) {
            typing.remove();
            appendToChat(`
                <div class="flex justify-start">
                    <div class="max-w-[80%]">
                        <div class="bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400 px-4 py-2 rounded-2xl rounded-bl-sm">
                            Terjadi kesalahan koneksi ke server.
                        </div>
                    </div>
                </div>
            `);
        }
    });

    // Auto-focus input saat chat dibuka
    chatToggle.addEventListener("click", () => {
        setTimeout(() => {
            messageInput.focus();
        }, 300);
    });

    /**
     * ==========================
     * HISTORY CHAT
     * ==========================
     */

    openHistory.addEventListener("click", async () => {
        document.getElementById("chat-main").classList.add("hidden");

        // ✅ Fix: tambah class flex agar layout history benar
        historyBox.classList.remove("hidden");
        historyBox.classList.add("flex");

        historyContent.innerHTML = `
            <div class="text-center text-gray-500 text-sm">
                Memuat riwayat...
            </div>
        `;

        try {
            const response = await fetch("/chat/history");
            const messages = await response.json();

            historyContent.innerHTML = "";

            if (messages.length === 0) {
                historyContent.innerHTML = `
                    <div class="text-center text-gray-500 text-sm">
                        Belum ada riwayat percakapan.
                    </div>
                `;
                return;
            }

            messages.forEach((msg) => {
                let position = "justify-start";
                let bubble =
                    "bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200";
                let sender = "Nolite Bot";

                if (msg.sender_id === window.Chatbot.userId) {
                    position = "justify-end";
                    bubble = "bg-primary-500 text-white";
                    sender = "Anda";
                } else if (msg.sender_id !== null) {
                    sender = "Admin Nolite";
                    bubble =
                        "bg-blue-100 text-blue-900 dark:bg-blue-900/30 dark:text-blue-200";
                }

                const el = createEl(`
                    <div class="flex ${position}">
                        <div class="max-w-[80%]">
                            <div class="${bubble} px-4 py-2 rounded-2xl">
                                ${msg.message}
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">
                                ${sender}
                            </span>
                        </div>
                    </div>
                `);
                historyContent.appendChild(el);
            });

            historyContent.scrollTop = historyContent.scrollHeight;

            await fetch("/chat/mark-read", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": window.Chatbot.csrf,
                    "Content-Type": "application/json",
                },
            });

            notificationBadge.classList.add("hidden");
        } catch (e) {
            historyContent.innerHTML = `
                <div class="text-center text-red-500 text-sm">
                    Gagal memuat riwayat chat.
                </div>
            `;
        }
    });

    backToChat.addEventListener("click", () => {
        // ✅ Fix: hapus juga class flex saat disembunyikan
        historyBox.classList.add("hidden");
        historyBox.classList.remove("flex");
        document.getElementById("chat-main").classList.remove("hidden");
    });

    /**
     * ==========================
     * NOTIFICATION CHECK
     * ==========================
     */

    let isChecking = false;
    let lastRequestTime = 0;
    const MIN_INTERVAL = 20000; // 20 detik

    async function checkUnreadMessages() {
        if (isChecking) return;

        const now = Date.now();

        // 🔴 TAMBAHAN: anti spam request
        if (now - lastRequestTime < MIN_INTERVAL) return;

        isChecking = true;
        lastRequestTime = now;

        try {
            const response = await fetch("/chat/unread-count");
            const data = await response.json();

            if (data.count > 0) {
                notificationBadge.classList.remove("hidden");
                notificationBadge.innerText = data.count;
            } else {
                notificationBadge.classList.add("hidden");
            }
        } catch (e) {
            console.log(e);
        } finally {
            isChecking = false;
        }
    }

    let intervalId = setInterval(checkUnreadMessages, 20000);

    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            clearInterval(intervalId);
        } else {
            intervalId = setInterval(checkUnreadMessages, 20000);
            checkUnreadMessages();
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const tooltip = document.getElementById("chat-tooltip");
    const arrow = document.getElementById("chat-arrow");
    const fullText = `Halo ${window.Chatbot.tooltip}! Selamat datang di Nolite Aspiciens. Ada produk yang ingin kamu lihat atau tanyakan?`;
    let index = 0;

    setTimeout(() => {
        tooltip.classList.remove("opacity-0", "translate-x-4");
        arrow.classList.remove("opacity-0", "translate-x-4");

        const typing = setInterval(() => {
            if (index < fullText.length) {
                tooltip.querySelector(".typing-text").textContent +=
                    fullText.charAt(index);
                index++;
            } else {
                clearInterval(typing);
                setTimeout(() => {
                    tooltip.classList.add("opacity-0", "translate-x-4");
                    arrow.classList.add("opacity-0", "translate-x-4");
                }, 6000);
            }
        }, 50);
    }, 800);
});
