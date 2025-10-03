<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukFoto extends Model
{
    use HasFactory;

    protected $table = 'produk_fotos'; // pastikan sesuai nama tabel

    protected $fillable = [
        'produk_id',
        'foto',   // tambahkan ini
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
