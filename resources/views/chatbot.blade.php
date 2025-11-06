@extends('layouts.user_app')

@section('content')
    <div class="max-w-4xl mx-auto mt-32 mb-32">
        <div class="bg-gray-300 shadow-2xl rounded-3xl flex flex-col h-auto max-h-[600px] overflow-hidden">
            {{-- Header --}}
            <div
                class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-gray-700 to-gray-600 rounded-t-3xl">
                <h4 class="text-white font-bold text-xl flex items-center text-center gap-2">
                    <i class="fa-solid fa-robot mr-1 text-gray-200"></i>Chat Nolite
                </h4>
            </div>

            {{-- Chat area --}}
            <div id="chatbox" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50 scroll-smooth max-h-[500px]">
                <div class="text-center text-gray-400 text-[14px]] mt-10">
                    <i class="fa-solid fa-robot mr-1"></i> Hai! Ketik pertanyaanmu tentang produk <strong class="underline">Nolite Aspiciencs</strong>
                </div>
            </div>

            {{-- Input area --}}
            <div class="bg-white p-4 border-t border-gray-200 rounded-b-3xl">
                <form id="chatForm" class="flex items-center gap-2">
                    <input type="text" id="message"
                        class="flex-1 px-4 py-3 rounded-2xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        placeholder="Ketik pertanyaanmu...">
                    <button type="submit" class="bg-gray-700 text-white px-5 py-3 rounded-2xl hover:bg-gray-600 transition">
                        <i class="fa-solid fa-paper-plane text-[20px]"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chatForm = document.getElementById("chatForm");
            const chatbox = document.getElementById("chatbox");
            const messageInput = document.getElementById("message");

            function appendMessage(message, from = 'user') {
                // Hapus placeholder awal
                const placeholder = chatbox.querySelector('.text-center');
                if (placeholder) placeholder.remove();

                const bubble = document.createElement('div');
                bubble.className = `flex ${from === 'user' ? 'justify-end' : 'justify-start'}`;
                bubble.innerHTML = `<span class="${from === 'user' ? 'bg-gray-200 text-gray-800' : 'bg-gray-100 text-gray-700'} px-4 py-2 rounded-2xl inline-block max-w-[65%] break-words whitespace-pre-line">${message}</span>`;
                chatbox.appendChild(bubble);
                chatbox.scrollTop = chatbox.scrollHeight;
            }

            function appendProductCards(produkList) {
                if (produkList.length === 0) return;
                const wrapper = document.createElement('div');
                wrapper.className = 'space-y-2 mt-2';

                produkList.forEach(p => {
                    const card = document.createElement('a');
                    card.href = `/produk/${p.id}`;
                    card.target = "_blank";
                    card.className = "flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-100 transition max-w-[65%]";
                    card.innerHTML = `
                    <img src="${p.foto}" class="w-16 h-16 object-cover rounded" alt="${p.nama_produk}">
                    <div class="flex-1 text-sm">
                        <div class="font-bold text-gray-700">${p.nama_produk}</div>
                        <div class="text-gray-500 text-xs">Ukuran: ${p.ukuran}</div>
                        <div class="text-gray-500 text-xs">Warna: ${p.warna}</div>
                        <div class="text-gray-700 font-medium text-sm">${p.harga}</div>
                        <div class="text-gray-600 text-xs mt-1">${p.deskripsi}</div>
                    </div>
                `;
                    wrapper.appendChild(card);
                });

                chatbox.appendChild(wrapper);
                chatbox.scrollTop = chatbox.scrollHeight;
            }

            chatForm.addEventListener("submit", async (e) => {
                e.preventDefault();
                const msg = messageInput.value.trim();
                if (!msg) return;

                appendMessage(msg, 'user');
                messageInput.value = "";

                // Typing indicator
                const typing = document.createElement('div');
                typing.className = 'text-gray-400 italic';
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

                    // Format jawaban AI: bold nama produk dalam bullet point
                    let formattedReply = data.reply || "Maaf, saya tidak menemukan informasi produk.";
                    formattedReply = formattedReply.replace(/- (.*?), Warna:/g, (match, p1) => `- <strong>${p1}</strong>, Warna:`);

                    appendMessage(formattedReply, 'bot');
                    appendProductCards(data.produk_list);

                } catch (error) {
                    typing.remove();
                    appendMessage("Terjadi kesalahan koneksi ke server.", 'bot');
                }
            });
        });
    </script>
@endsection