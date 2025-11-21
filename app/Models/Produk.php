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
        'kategori_id',
        'jenis_lain',
        'foto',
        'diskon'
    ];

    protected $casts = [
        'warna' => 'array',
        'ukuran' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function fotos()
    {
        return $this->hasMany(ProdukFoto::class, 'produk_id');
    }

    public function getHargaDiskonAttribute()
    {
        // Jika ada diskon
        $harga = ($this->diskon > 0)
            ? $this->harga - ($this->harga * $this->diskon / 100)
            : $this->harga;

        // Formatting rupiah
        return number_format($harga, 0, ',', '.');
    }

    public function getHargaFormatAttribute()
    {
        // Harga asli terformat
        return number_format($this->harga, 0, ',', '.');
    }

    public function getHasDiskonAttribute()
    {
        return $this->diskon > 0;
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

    public function scopeWithStatistik($query)
    {
        return $query
            ->addSelect([
                // total terjual
                'total_terjual' => OrderItem::query()
                    ->join('orders', function ($join) {
                        $join->on('orders.id', '=', 'order_items.order_id')
                            ->where('orders.status', '=', 'selesai');
                    })
                    ->selectRaw('COALESCE(SUM(order_items.jumlah), 0)')
                    ->whereColumn('order_items.produk_id', 'produks.id'),

                // average rating
                'average_rating' => Ulasan::query()
                    ->selectRaw('COALESCE(AVG(ulasans.rating), 0)')
                    ->whereColumn('ulasans.produk_id', 'produks.id'),

                // total ulasan
                'total_ulasan' => Ulasan::query()
                    ->selectRaw('COALESCE(COUNT(*), 0)')
                    ->whereColumn('ulasans.produk_id', 'produks.id'),
            ]);
    }
}
