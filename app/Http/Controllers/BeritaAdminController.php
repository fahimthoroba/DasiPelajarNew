<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaAdminController extends Controller
{
    public function index()
    {
        // Get all news, ordered by newest
        $beritas = Berita::with('kategori', 'user')->latest()->paginate(10);
        return view('dashboard.berita.index', compact('beritas'));
    }

    public function create()
    {
        $kategoris = KategoriBerita::all();
        return view('dashboard.berita.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'kategori_id' => 'required|exists:kategori_beritas,id',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|max:2048', // Max 2MB
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['kategori_berita_id'] = $validated['kategori_id'];
        unset($validated['kategori_id']);

        $baseSlug = Str::slug($validated['judul']);
        $slug = $baseSlug . '-' . Str::random(5);

        // Ensure slug is unique
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::random(5);
        }
        $validated['slug'] = $slug;

        $validated['tgl_publish'] = $validated['status'] == 'published' ? now() : null;

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Berita::create($validated);

        return redirect()->route('dashboard.berita.index')->with('success', 'Berita berhasil dibuat!');
    }

    public function edit(Berita $beritum)
    {
        $kategoris = KategoriBerita::all();
        return view('dashboard.berita.edit', compact('beritum', 'kategoris'));
    }

    public function update(Request $request, Berita $beritum)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'kategori_id' => 'required|exists:kategori_beritas,id',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Update Slug if title changes (optional, usually kept stable for SEO, but let's update it for now or keep it)
        // Let's keep slug stable unless explicitly requested, or just update it if they change title significantly? 
        // For simplicity, let's keep old slug or update if title changed.
        if ($request->judul !== $beritum->judul) {
            $baseSlug = Str::slug($validated['judul']);
            $slug = $baseSlug . '-' . Str::random(5);
            while (Berita::where('slug', $slug)->where('id', '!=', $beritum->id)->exists()) {
                $slug = $baseSlug . '-' . Str::random(5);
            }
            $validated['slug'] = $slug;
        }

        $validated['kategori_berita_id'] = $validated['kategori_id'];
        unset($validated['kategori_id']);

        if ($validated['status'] == 'published' && !$beritum->tgl_publish) {
            $validated['tgl_publish'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old image
            if ($beritum->thumbnail) {
                Storage::disk('public')->delete($beritum->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $beritum->update($validated);

        return redirect()->route('dashboard.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $beritum)
    {
        if ($beritum->thumbnail) {
            Storage::disk('public')->delete($beritum->thumbnail);
        }
        $beritum->delete();

        return redirect()->route('dashboard.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
