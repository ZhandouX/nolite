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

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:500',
            'warna' => 'required|array',
            'warna.*' => 'string|max:250',
            'warna_lain' => 'nullable|string|max:250',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer',
            'jenis' => 'required|string|max:250',
            'ukuran' => 'nullable|array',
            'ukuran.*' => 'string|in:XS,S,M,L,XL,XXL',
            'foto' => 'nullable',
            'foto.*' => 'image|mimes:jpg,jpeg,png',
        ]);

        $warnaFinal = $request->warna;

        // Jika ada "Other", tambahkan input manual ke array warna
        if (in_array('Other', $warnaFinal) && $request->filled('warna_lain')) {
            $warnaFinal = array_diff($warnaFinal, ['Other']); // hapus placeholder "Other"
            $warnaFinal[] = $request->warna_lain;            // tambah warna manual
        }

        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'warna' => $warnaFinal, // langsung simpan array, Laravel cast ke JSON
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,   // langsung simpan jenis (tanpa "jenis_lain")
            'ukuran' => $request->ukuran ?? [], // Simpan ukuran array
        ]);

        foreach ($request->file('foto', []) as $file) {
            $path = $file->store('produk', 'public');
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
            'warna' => 'required|array',
            'warna.*' => 'string|max:250',
            'warna_lain' => 'nullable|string|max:250',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'jumlah' => 'required|integer',
            'jenis' => 'required|string|max:250',
            'ukuran' => 'nullable|array',
            'ukuran.*' => 'string|in:XS,S,M,L,XL,XXL',
            'foto' => 'nullable',
            'foto.*' => 'image|mimes:jpg,jpeg,png',
        ]);

        // Warna final
        $warnaFinal = $request->warna;
        if (in_array('Other', $warnaFinal) && $request->filled('warna_lain')) {
            $warnaFinal = array_diff($warnaFinal, ['Other']);
            $warnaFinal[] = $request->warna_lain;
        }

        // Update data produk
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'warna' => $warnaFinal,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'jenis' => $request->jenis,
            'ukuran' => $request->ukuran ?? [],
        ]);

        // Upload foto baru
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('produk', 'public');
                $produk->fotos()->create(['foto' => $path]);
            }
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diubah.');
    }

    /* DISKON */
    public function updateDiskon(Request $request, Produk $produk)
    {
        $request->validate([
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        $produk->diskon = $request->diskon ?? 0;
        $produk->save();

        return response()->json(['success' => true]);
    }


    /* DESTROY */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
