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

        // 🔹 Ambil 6 produk terbaru
        $produk = Produk::with('fotos')
            ->latest()
            ->take(6)
            ->withStatistik()
            ->get();

        // 🔹 Ambil semua produk yang memiliki diskon
        $produkDiskon = Produk::with('fotos')
            ->withStatistik()
            ->where('diskon', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        // 🔹 Tambahkan logika untuk menampilkan modal login otomatis
        $showLoginModal = $request->query('showLogin', false);

        // 🔹 Kirim ke view
        return view('welcome', compact('produk', 'produkDiskon', 'showLoginModal'));
    }
}