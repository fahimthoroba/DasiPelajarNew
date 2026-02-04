<?php

namespace App\Http\Controllers;

use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriAdminController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBerita::all();
        return view('dashboard.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('dashboard.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:kategori_beritas,nama',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        KategoriBerita::create($validated);

        return redirect()->route('dashboard.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(KategoriBerita $kategori)
    {
        return view('dashboard.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBerita $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:kategori_beritas,nama,' . $kategori->id,
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $kategori->update($validated);

        return redirect()->route('dashboard.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(KategoriBerita $kategori)
    {
        $kategori->delete();
        return redirect()->route('dashboard.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
