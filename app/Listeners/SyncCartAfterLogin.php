<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Keranjang;
use App\Models\Produk;

class SyncCartAfterLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $sessionCart = session()->get('keranjang', []);

        if (!empty($sessionCart)) {
            foreach ($sessionCart as $key => $item) {
                $produk = Produk::find($item['produk_id']);
                if (!$produk) continue;

                // Cek apakah produk sudah ada di keranjang user
                $existing = Keranjang::where('user_id', $user->id)
                    ->where('produk_id', $produk->id)
                    ->where('warna', $item['warna'])
                    ->where('ukuran', $item['ukuran'])
                    ->first();

                if ($existing) {
                    // Jika sudah ada → update jumlah
                    $existing->jumlah += $item['jumlah'];
                    $existing->subtotal = $existing->jumlah * $produk->harga;
                    $existing->save();
                } else {
                    // Jika belum ada → buat baru
                    Keranjang::create([
                        'user_id' => $user->id,
                        'produk_id' => $produk->id,
                        'warna' => $item['warna'],
                        'ukuran' => $item['ukuran'],
                        'jumlah' => $item['jumlah'],
                        'subtotal' => $produk->harga * $item['jumlah'],
                    ]);
                }
            }

            // Hapus session keranjang setelah disinkronkan
            session()->forget('keranjang');
        }
    }
}
