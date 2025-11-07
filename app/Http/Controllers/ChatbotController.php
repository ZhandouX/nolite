<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function query(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = Auth::user(); // bisa null kalau belum login

        // ✅ Buat chat hanya jika user sudah login
        $chat = null;
        if ($user) {
            $chat = Chat::firstOrCreate(
                ['user_id' => $user->id],
                ['last_activity' => now()]
            );
        }

        // ✅ Simpan pesan user hanya kalau login
        $userMessage = null;
        if ($chat) {
            $userMessage = Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $user->id,
                'message' => $request->message,
                'is_read' => true,
            ]);
        }

        // 🔹 Kirim pertanyaan ke Gemini AI Service
        $aiResponse = $this->gemini->query($request->message);

        // ✅ Simpan balasan AI hanya kalau user login
        $botMessage = null;
        if ($chat) {
            $botMessage = Message::create([
                'chat_id' => $chat->id,
                'sender_id' => null, // bot
                'message' => $aiResponse['reply'] ?? 'Maaf, saya tidak dapat menjawab saat ini.',
                'is_read' => false,
            ]);
            // update aktivitas terakhir
            $chat->update(['last_activity' => now()]);
        }

        // 🔸 Return response ke frontend (user & guest sama)
        return response()->json([
            'success' => true,
            'reply' => $aiResponse['reply'] ?? 'Maaf, saya tidak dapat menjawab saat ini.',
            'produk_list' => $aiResponse['produk_list'] ?? [],
            'user_message' => $userMessage ? [
                'id' => $userMessage->id,
                'message' => $userMessage->message,
                'created_at' => $userMessage->created_at->toDateTimeString(),
            ] : [
                'id' => null,
                'message' => $request->message,
                'created_at' => now()->toDateTimeString(),
            ],
            'bot_message' => $botMessage ? [
                'id' => $botMessage->id,
                'message' => $botMessage->message,
                'created_at' => $botMessage->created_at->toDateTimeString(),
            ] : [
                'id' => null,
                'message' => $aiResponse['reply'] ?? 'Maaf, saya tidak dapat menjawab saat ini.',
                'created_at' => now()->toDateTimeString(),
            ],
        ]);
    }
}
