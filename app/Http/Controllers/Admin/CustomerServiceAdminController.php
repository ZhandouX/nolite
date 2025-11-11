<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerServiceAdminController extends Controller
{
    // 📋 Tampilkan daftar user yang pernah mengirim pesan
    public function index()
    {
        $messages = CustomerService::select('user_id', DB::raw('MAX(created_at) as latest'))
            ->groupBy('user_id')
            ->orderByDesc('latest')
            ->with('user')
            ->paginate(10);

        return view('admin.customer_service.index', compact('messages'));
    }

    // 👁️ Lihat detail pesan dari 1 user
    public function show(User $user)
    {
        // Semua pesan user ini
        $messages = CustomerService::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Update semua yang pending → read
        CustomerService::where('user_id', $user->id)
            ->where('status', 'pending')
            ->update(['status' => 'read']);

        return view('admin.customer_service.show', compact('user', 'messages'));
    }

    // 💬 Balas pesan user
    public function reply(Request $request, $id)
    {
        $request->validate(['reply' => 'required|string|max:1000']);

        $message = CustomerService::findOrFail($id);
        $message->update([
            'reply' => $request->reply,
            'status' => 'replied',
        ]);

        return back()->with('success', 'Balasan berhasil dikirim dan status diperbarui.');
    }
}
