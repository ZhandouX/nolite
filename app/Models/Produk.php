<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        return $this->hasMany(OrderItem::class, 'produk_id');
    }

    public function getTerjualAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', fn($q) => $q->where('status', 'selesai'))
            ->sum('jumlah');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id')->with('user', 'fotos');
    }

    // Local scope
    public function scopeWithStatistik($query)
    {
        return $query->select(
            'produks.*',
            DB::raw('COALESCE(SUM(order_items.jumlah), 0) as total_terjual'),
            DB::raw('COALESCE(AVG(ulasans.rating), 0) as average_rating'),
            DB::raw('COUNT(ulasans.id) as total_ulasan')
        )
            ->leftJoin('order_items', 'order_items.produk_id', '=', 'produks.id')
            ->leftJoin('orders', function ($join) {
                $join->on('orders.id', '=', 'order_items.order_id')
                    ->where('orders.status', '=', 'selesai');
            })
            ->leftJoin('ulasans', 'ulasans.produk_id', '=', 'produks.id')
            ->groupBy('produks.id');
    }
}
