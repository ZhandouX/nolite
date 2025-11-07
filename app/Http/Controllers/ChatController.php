<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ChatController extends Controller
{
    /**
     * Halaman chat untuk user biasa (bukan admin)
     */
    public function index()
    {
        $user = Auth::user();

        // Cari atau buat sesi chat milik user
        $chat = Chat::firstOrCreate(
            ['user_id' => $user->id],
            ['last_activity' => now()]
        );

        // Ambil pesan terakhir (max 50)
        $messages = $chat->messages()
            ->latest()
            ->take(config('chat.max_messages_per_session', 50))
            ->get()
            ->reverse()
            ->values();

        // Hapus pesan lama (kalau diaktifkan)
        $this->cleanupOldMessages($chat);

        return view('chat.index', compact('chat', 'messages'));
    }

    /**
     * Kirim pesan dari user ke sistem
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $chat = Chat::findOrFail($request->chat_id);

        // Simpan pesan user
        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'role' => 'user',
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Update last activity
        $chat->update(['last_activity' => now()]);

        // Simpan ke cache sementara (jika aktif)
        if (config('chat.cache_enabled', false)) {
            Cache::put(
                'chat_' . $chat->id . '_last_activity',
                now(),
                now()->addSeconds(config('chat.cache_duration', 60))
            );
        }

        // Batasi jumlah pesan agar tidak menumpuk
        $this->trimMessages($chat);

        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * Fetch pesan dari chat tertentu (digunakan untuk AJAX user)
     */
    public function fetchMessages($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        // Jika mode temporary aktif, hapus pesan lama
        if (config('chat.temporary_mode', false)) {
            $lastActivity = Cache::get('chat_' . $chat->id . '_last_activity');
            $duration = config('chat.history_duration', 60);

            if ($lastActivity && Carbon::parse($lastActivity)->diffInMinutes(now()) > $duration) {
                $chat->messages()->delete();
            }
        }

        // Ambil pesan terbaru
        return $chat->messages()
            ->latest()
            ->take(config('chat.max_messages_per_session', 50))
            ->get()
            ->reverse()
            ->values();
    }

    /**
     * ======================
     * 📁 FITUR UNTUK ADMIN
     * ======================
     */

    // Tampilkan daftar semua user yang memiliki chat
    public function adminIndex(Request $request)
    {
        $users = User::whereHas('chat')->get();
        $selectedUserId = $request->get('user_id');

        $chat = null;
        $messages = collect();

        if ($selectedUserId) {
            $chat = Chat::where('user_id', $selectedUserId)->first();
            if ($chat) {
                $messages = $chat->messages()
                    ->latest()
                    ->take(100)
                    ->get()
                    ->reverse()
                    ->values();
            }
        }

        return view('admin.chats.index', compact('users', 'selectedUserId', 'chat', 'messages'));
    }

    // Kirim pesan dari admin ke user
    public function adminSend(Request $request, $chatId)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $chat = Chat::findOrFail($chatId);

        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'role' => 'admin',
            'message' => $request->message,
            'is_read' => false,
        ]);

        $chat->update(['last_activity' => now()]);

        return redirect()->route('admin.chats.index', ['user_id' => $chat->user_id]);
    }

    /**
     * Hapus pesan yang sudah lebih lama dari durasi yang diizinkan.
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
     * Pangkas pesan lama agar tidak melebihi batas maksimum.
     */
    private function trimMessages(Chat $chat)
    {
        $maxMessages = config('chat.max_messages_per_session', 200);
        $count = $chat->messages()->count();

        if ($count > $maxMessages) {
            $excess = $count - $maxMessages;
            $chat->messages()
                ->oldest()
                ->take($excess)
                ->delete();
        }
    }
}
