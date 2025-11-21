<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'warna',
        'ukuran',
        'jumlah',
        'subtotal',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function jumlahKeranjang()
    {
        if (Auth::check()) {
            // User login → hitung keranjang di database
            return self::where('user_id', Auth::id())->count();
        } else {
            // Guest → hitung dari session
            return count(session('keranjang', []));
        }
    }
}
