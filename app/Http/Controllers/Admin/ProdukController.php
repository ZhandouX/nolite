<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    /* INDEX */
    public function index()
    {
        $produks = Produk::with('fotos')->get();
        return view('admin.produk.index', compact('produks'));

    }

    /* CREATE */
    public function create()
    {
        return view('admin.produk.create');
    }

    /* STORE */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:500',
            'warna' => 'required|string|max:250',
            'warna_lain' => 'nullable|string|max:250',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer',
            'jenis' => 'required|string|max:250',
            'jenis_lain' => 'nullable|string|max:250',
            'foto' => 'nullable',
            'foto.*' => 'image|mimes:jpg,jpeg,png',
        ]);

        // Jika warna = Other, ambil dari input manual
        $warnaFinal = $request->warna === 'Other' ? $request->warna_lain : $request->warna;

        // Jika jenis = Other, ambil dari input manual
        $jenisFinal = $request->jenis === 'Other' ? $request->jenis_lain : $request->jenis;

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'warna' => $warnaFinal,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'jenis' => $jenisFinal,
        ]);

        // Simpan semua foto (pakai default array [] biar tidak null)
        foreach ($request->file('foto', []) as $file) {
            $path = $file->store('produk', 'public'); // simpan ke storage/app/public/produk
            $produk->fotos()->create(['foto' => $path]);
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    /* SHOW */
    public function show(string $id)
    {
        $produk = Produk::with('fotos')->findOrFail($id);

        return view('admin.produk.show', compact('produk'));
    }

    /* EDIT */
    public function edit(string $id)
    {
        $produk = Produk::with('fotos')->findOrFail($id);
        
        return view('admin.produk.edit', compact('produk'));
    }

    /* UPDATE */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:500',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer',
            'jenis' => 'required|string|max:250',
            'foto' => 'nullable|mimes:jpg,jpeg,png'
        ]);

        $data = $request->only([
            'nama_produk',
            'harga',
            'jumlah',
            'jenis'
        ]);

        if ($request->hasFile('foto')) {
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/produk', $fotoName);
            $data['foto'] = $fotoName;
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diubah.');
    }

    /* DESTROY */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
