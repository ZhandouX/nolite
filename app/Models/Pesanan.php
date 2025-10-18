<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_penerima',
        'email',
        'no_hp',
        'negara',
        'kota',
        'alamat_detail',
        'is_dropship',
        'catatan',
        'metode_pembayaran',
        'total_harga',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }
}
