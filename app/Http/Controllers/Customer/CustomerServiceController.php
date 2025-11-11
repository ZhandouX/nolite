<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerService;
use Illuminate\Support\Facades\Auth;

class CustomerServiceController extends Controller
{
    // Tampilkan halaman customer service
    public function index()
    {
        $user = Auth::user();

        // Pastikan user nonaktif
        if ($user->status !== 'nonaktif') {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.services.customer-service', [
            'user' => $user,
        ]);
    }

    // Kirim pesan ke admin
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        CustomerService::create([
            'user_id' => $user->id,
            'message' => $request->message,
            'status' => 'pending', // bisa 'pending', 'read', 'replied'
        ]);

        return back()->with('success', 'Pesan berhasil dikirim ke admin.');
    }
}
