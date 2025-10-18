<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    use HasFactory;

    protected $table = 'pesanan_items';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'nama_produk',
        'jumlah',
        'harga',
        'warna',
        'ukuran',
        'subtotal'
    ];

    /**
     * Relasi ke Pesanan (many to one)
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Relasi ke Produk (many to one)
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
