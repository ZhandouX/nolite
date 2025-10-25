<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}