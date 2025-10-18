<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
;

class AllProdukController extends Controller
{
    public function allProduk()
    {
        $produks = Produk::all();
        return view('customer.all-produk', compact('produks'));
    }
}
