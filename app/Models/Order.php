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
        'status'
    ];

    // protected static function booted()
    // {
    //     // Saat Order
    //     static::created(function ($order) {
    //         if ($order->status === 'menunggu') {
    //             Cache::put('new_order_' . $order->user_id, true, 300);
    //         }
    //     });

    //     static::updated(function ($order) {
    //         if ($order->wasChanged('status') && $order->status === 'menunggu') {
    //             Cache::put('new_order' . $order->user_id, true, 300);
    //         }
    //     });
    // }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}