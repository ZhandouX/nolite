<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'produk_id',
        'order_id',
        'order_item_id',
        'rating',
        'komentar',
    ];

    public function fotos()
    {
        return $this->hasMany(UlasanFoto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
