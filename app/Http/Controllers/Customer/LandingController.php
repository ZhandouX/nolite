<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Jika sudah login -> redirect sesuai role
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('customer')) {
                return redirect()->route('customer.dashboard');
            } else {
                return redirect('/login');
            }
        }

        // Ambil 6 produk pertama
        $produk = Produk::with('fotos')
                        ->latest()
                        ->take(6)
                        ->get();

        // 🔹 Tambahkan logika untuk menampilkan modal login otomatis
        $showLoginModal = $request->query('showLogin', false);

        return view('welcome', compact('produk', 'showLoginModal'));
    }
}