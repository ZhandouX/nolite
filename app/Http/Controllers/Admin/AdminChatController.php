<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    /**
     * 📨 Menampilkan daftar semua chat user
     * Dapat difilter dan dicari berdasarkan nama pengguna.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil semua chat dengan user dan pesan terakhir
        $chats = Chat::with(['user', 'lastMessage'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('last_activity')
            ->get();

        return view('admin.chats.index', compact('chats', 'search'));
    }

    /**
     * 💬 Menampilkan isi percakapan dengan user tertentu.
     */
    public function show($chatId)
    {
        $chat = Chat::with(['user', 'messages.sender'])->findOrFail($chatId);

        // Tandai semua pesan dari user sebagai sudah dibaca
        $chat->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('admin.chats.show', compact('chat', 'messages'));
    }

    /**
     * ✉️ Admin mengirim pesan ke user tertentu.
     */
    public function send(Request $request, $chatId)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $chat = Chat::findOrFail($chatId);

        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => true,
        ]);

        $chat->update(['last_activity' => now()]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    /**
     * 🗑️ Menghapus pesan tertentu dari chat.
     */
    public function deleteMessage($messageId)
    {
        $message = Message::findOrFail($messageId);

        // Hanya admin yang boleh hapus
        if (Auth::user()->hasRole('admin')) {
            $message->delete();
            return back()->with('success', 'Pesan berhasil dihapus.');
        }

        return back()->with('error', 'Anda tidak memiliki izin untuk menghapus pesan ini.');
    }

    /**
     * 🧹 Menghapus seluruh chat (beserta semua pesannya).
     */
    public function deleteChat($chatId)
    {
        $chat = Chat::with('messages')->findOrFail($chatId);

        $chat->messages()->delete();
        $chat->delete();

        return redirect()->route('admin.chats.index')
            ->with('success', 'Chat dengan user tersebut telah dihapus.');
    }
}
