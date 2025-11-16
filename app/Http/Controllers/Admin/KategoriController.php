<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
            'foto_sampul' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only('nama_kategori');

        if ($request->hasFile('foto_sampul')) {
            $data['foto_sampul'] = $request->file('foto_sampul')->store('kategori', 'public');
        }

        Kategori::create($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'foto_sampul' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only('nama_kategori');

        if ($request->hasFile('foto_sampul')) {
            if ($kategori->foto_sampul) {
                Storage::disk('public')->delete($kategori->foto_sampul);
            }
            $data['foto_sampul'] = $request->file('foto_sampul')->store('kategori', 'public');
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
            'foto_sampul' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only('nama_kategori');

        if ($request->hasFile('foto_sampul')) {
            $data['foto_sampul'] = $request->file('foto_sampul')->store('kategori', 'public');
        }

        $kategori = Kategori::create($data);

        // Return JSON
        return response()->json([
            'status' => 'success',
            'kategori' => $kategori
        ]);
    }

    public function updateAjax(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'foto_sampul' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $data = $request->only('nama_kategori');

        if ($request->hasFile('foto_sampul')) {
            if ($kategori->foto_sampul && Storage::disk('public')->exists($kategori->foto_sampul)) {
                Storage::disk('public')->delete($kategori->foto_sampul);
            }
            $data['foto_sampul'] = $request->file('foto_sampul')->store('kategori', 'public');
        }

        $kategori->update($data);

        return response()->json([
            'status' => 'success',
            'kategori' => $kategori
        ]);
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->foto_sampul && Storage::disk('public')->exists($kategori->foto_sampul)) {
            Storage::disk('public')->delete($kategori->foto_sampul);
        }

        $kategori->delete();

        return response()->json(['status' => 'success']);
    }

}
