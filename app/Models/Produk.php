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
        'deskripsi',
        'harga',
        'jumlah',
        'jenis',
        'jenis_lain',
        'foto'
    ];

    public function fotos()
    {
        return $this->hasMany(ProdukFoto::class);
    }
}
