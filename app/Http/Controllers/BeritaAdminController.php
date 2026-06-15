<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::with('kategori', 'user', 'tags')->latest();

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_berita_id', $request->kategori);
        }

        $beritas = $query->paginate(12)->withQueryString();

        $stats = [
            'total'     => Berita::count(),
            'published' => Berita::where('status', 'published')->count(),
            'draft'     => Berita::where('status', 'draft')->count(),
            'archived'  => Berita::where('status', 'archived')->count(),
        ];

        $kategoris = KategoriBerita::orderBy('nama')->get();

        return view('dashboard.berita.index', compact('beritas', 'stats', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriBerita::orderBy('nama')->get();
        $allTags = Tag::orderBy('nama')->get();
        return view('dashboard.berita.create', compact('kategoris', 'allTags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'      => 'required|max:255',
            'kategori_id'=> 'required|exists:kategori_beritas,id',
            'konten'     => 'required',
            'ringkasan'  => 'nullable|max:500',
            'thumbnail'  => 'nullable|image|max:2048',
            'status'     => 'required|in:draft,published,archived',
            'jenis'      => 'nullable|in:berita,opini,pengumuman,foto',
            'is_headline'=> 'nullable|boolean',
        ]);

        $validated['user_id']           = Auth::id();
        $validated['kategori_berita_id']= $validated['kategori_id'];
        $validated['is_headline']       = $request->boolean('is_headline');
        $validated['jenis']             = $validated['jenis'] ?? 'berita';
        unset($validated['kategori_id']);

        $baseSlug = Str::slug($validated['judul']);
        $slug     = $baseSlug . '-' . Str::random(5);
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . Str::random(5);
        }
        $validated['slug'] = $slug;

        if ($validated['status'] === 'published') {
            $validated['tgl_publish'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $berita = Berita::create($validated);

        // Sync tags
        $tagIds = $this->resolveTags($request->input('tags_input', ''));
        $berita->tags()->sync($tagIds);

        return redirect()->route('dashboard.berita.index')->with('success', 'Berita berhasil dibuat!');
    }

    public function edit(Berita $beritum)
    {
        $beritum->load('tags');
        $kategoris = KategoriBerita::orderBy('nama')->get();
        $allTags   = Tag::orderBy('nama')->get();
        return view('dashboard.berita.edit', compact('beritum', 'kategoris', 'allTags'));
    }

    public function update(Request $request, Berita $beritum)
    {
        $validated = $request->validate([
            'judul'      => 'required|max:255',
            'kategori_id'=> 'required|exists:kategori_beritas,id',
            'konten'     => 'required',
            'ringkasan'  => 'nullable|max:500',
            'thumbnail'  => 'nullable|image|max:2048',
            'status'     => 'required|in:draft,published,archived',
            'jenis'      => 'nullable|in:berita,opini,pengumuman,foto',
            'is_headline'=> 'nullable|boolean',
        ]);

        $validated['kategori_berita_id'] = $validated['kategori_id'];
        $validated['is_headline']        = $request->boolean('is_headline');
        $validated['jenis']              = $validated['jenis'] ?? $beritum->jenis ?? 'berita';
        unset($validated['kategori_id']);

        if ($request->judul !== $beritum->judul) {
            $baseSlug = Str::slug($validated['judul']);
            $slug     = $baseSlug . '-' . Str::random(5);
            while (Berita::where('slug', $slug)->where('id', '!=', $beritum->id)->exists()) {
                $slug = $baseSlug . '-' . Str::random(5);
            }
            $validated['slug'] = $slug;
        }

        if ($validated['status'] === 'published' && ! $beritum->tgl_publish) {
            $validated['tgl_publish'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($beritum->thumbnail) {
                Storage::disk('public')->delete($beritum->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $beritum->update($validated);

        // Sync tags
        $tagIds = $this->resolveTags($request->input('tags_input', ''));
        $beritum->tags()->sync($tagIds);

        return redirect()->route('dashboard.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $beritum)
    {
        if ($beritum->thumbnail) {
            Storage::disk('public')->delete($beritum->thumbnail);
        }
        $beritum->tags()->detach();
        $beritum->delete();

        return redirect()->route('dashboard.berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('berita-images', 'public');
            return response()->json(['location' => '/storage/' . $path]);
        }
        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    private function resolveTags(string $input): array
    {
        return collect(explode(',', $input))
            ->map(fn($t) => trim($t))
            ->filter()
            ->unique()
            ->map(fn($name) => Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['nama' => $name]
            )->id)
            ->values()
            ->toArray();
    }
}
