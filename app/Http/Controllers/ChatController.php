<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari atau buat chat user
        $chat = Chat::firstOrCreate(['user_id' => $user->id]);

        // Ambil pesan terbaru (dibatasi sesuai config)
        $messages = $chat->messages()
            ->latest()
            ->take(config('chat.max_messages_per_session', 50))
            ->get()
            ->reverse();

        // Hapus pesan lama jika history_duration aktif
        $this->cleanupOldMessages($chat);

        return view('chat.index', compact('chat', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $chat = Chat::findOrFail($request->chat_id);

        // Buat pesan baru
        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Update aktivitas & cache sementara
        if (config('chat.cache_enabled')) {
            Cache::put(
                'chat_' . $chat->id . '_last_activity',
                now(),
                now()->addSeconds(config('chat.cache_duration', 60))
            );
        }

        $chat->update(['last_activity' => now()]);

        // Batasi jumlah pesan agar tidak menumpuk
        $this->trimMessages($chat);

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function fetchMessages($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        // Jika chat sementara dan durasi sudah habis, hapus otomatis
        if (config('chat.temporary_mode')) {
            $lastActivity = Cache::get('chat_' . $chat->id . '_last_activity');
            $duration = config('chat.history_duration', 60);

            if ($lastActivity && Carbon::parse($lastActivity)->diffInMinutes(now()) > $duration) {
                $chat->messages()->delete();
            }
        }

        return $chat->messages()
            ->latest()
            ->take(config('chat.max_messages_per_session', 50))
            ->get()
            ->reverse();
    }

    /**
     * Hapus pesan lama sesuai durasi dari config/chat.php
     */
    private function cleanupOldMessages(Chat $chat)
    {
        $minutes = config('chat.history_duration', 60);
        if ($minutes > 0) {
            $cutoff = Carbon::now()->subMinutes($minutes);
            $chat->messages()->where('created_at', '<', $cutoff)->delete();
        }
    }

    /**
     * Pangkas pesan jika jumlahnya melebihi batas maksimum
     */
    private function trimMessages(Chat $chat)
    {
        $maxMessages = config('chat.max_messages_per_session', 200);
        $count = $chat->messages()->count();

        if ($count > $maxMessages) {
            $excess = $count - $maxMessages;
            $oldest = $chat->messages()->oldest()->take($excess);
            $oldest->delete();
        }
    }
}
