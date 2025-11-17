<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori', 'foto_sampul'];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
