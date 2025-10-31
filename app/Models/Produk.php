<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProdukFoto;

class Produk extends Model
{
    protected $fillable = [
        'nama_produk',
        'warna',
        'warna_lain',
        'ukuran',
        'deskripsi',
        'harga',
        'jumlah',
        'jenis',
        'jenis_lain',
        'foto',
        'diskon'
    ];

    protected $casts = [
        'warna' => 'array',
        'ukuran' => 'array',
    ];

    public function fotos()
    {
        return $this->hasMany(ProdukFoto::class, 'produk_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
