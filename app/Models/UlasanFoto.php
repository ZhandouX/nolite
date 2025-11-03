<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'ulasan_id',
        'foto',
    ];

    public function ulasan()
    {
        return $this->belongsTo(Ulasan::class);
    }

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'order_id');
    }
}
