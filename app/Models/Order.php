<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'nama_penerima',
        'no_hp',
        'provinsi',
        'kota',
        'alamat_detail',
        'email',
        'metode_pembayaran',
        'subtotal',
        'status',
        'snap_token',
        // 'payment_url',
        'midtrans_order_id',
        'payment_type'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke ULASAN
     * Setiap pesanan hanya memiliki SATU ulasan.
     * Pastikan kolomnya: order_id di tabel ulasans
     */
    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'order_id');
    }
}
