<?php
namespace App\Http\Controllers;

use App\Models\BannerIklan;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaVisualController extends Controller
{
    public function index(Request $request)
    {
        $sliders = HeroSlider::orderBy('urutan')->get();
        $banners = BannerIklan::all()->keyBy('posisi');
        $positions = BannerIklan::POSITIONS;
        $tab = $request->get('tab', 'slider');
        return view('dashboard.media-visual.index', compact('sliders', 'banners', 'positions', 'tab'));
    }

    public function sliderCreate()
    {
        return view('dashboard.media-visual.create');
    }

    public function sliderStore(Request $request)
    {
        $validated = $request->validate([
            'judul_utama' => 'nullable|max:255',
            'sub_judul'   => 'nullable',
            'label'       => 'nullable|max:100',
            'gambar_path' => 'required|image|max:3072',
            'link_tombol' => 'nullable|url',
            'urutan'      => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);
        if ($request->hasFile('gambar_path')) {
            $validated['gambar_path'] = $request->file('gambar_path')->store('sliders', 'public');
        }
        $validated['is_active'] = $request->has('is_active');
        $validated['urutan']    = $validated['urutan'] ?? 0;
        HeroSlider::create($validated);
        return redirect()->route('dashboard.media-visual.index')->with('success', 'Slide berhasil ditambahkan!');
    }

    public function sliderEdit(HeroSlider $slider)
    {
        return view('dashboard.media-visual.edit', compact('slider'));
    }

    public function sliderUpdate(Request $request, HeroSlider $slider)
    {
        $validated = $request->validate([
            'judul_utama' => 'nullable|max:255',
            'sub_judul'   => 'nullable',
            'label'       => 'nullable|max:100',
            'gambar_path' => 'nullable|image|max:3072',
            'link_tombol' => 'nullable|url',
            'urutan'      => 'nullable|integer',
            'is_active'   => 'nullable|boolean',
        ]);
        if ($request->hasFile('gambar_path')) {
            if ($slider->gambar_path) Storage::disk('public')->delete($slider->gambar_path);
            $validated['gambar_path'] = $request->file('gambar_path')->store('sliders', 'public');
        }
        $validated['is_active'] = $request->has('is_active');
        $slider->update($validated);
        return redirect()->route('dashboard.media-visual.index')->with('success', 'Slide berhasil diperbarui!');
    }

    public function sliderDestroy(HeroSlider $slider)
    {
        if ($slider->gambar_path) Storage::disk('public')->delete($slider->gambar_path);
        $slider->delete();
        return redirect()->route('dashboard.media-visual.index')->with('success', 'Slide berhasil dihapus!');
    }

    public function bannerUpdate(Request $request, string $posisi)
    {
        if (!array_key_exists($posisi, BannerIklan::POSITIONS)) abort(404);

        $request->validate([
            'gambar'   => 'required|image|max:2048',
            'link_url' => 'nullable|url|max:500',
        ]);

        $banner = BannerIklan::firstOrNew(['posisi' => $posisi]);
        if ($banner->gambar_path) Storage::disk('public')->delete($banner->gambar_path);
        $banner->gambar_path = $request->file('gambar')->store('banners', 'public');
        $banner->link_url    = $request->input('link_url');
        $banner->is_active   = $request->boolean('is_active', true);
        $banner->posisi      = $posisi;
        $banner->save();

        return redirect()->route('dashboard.media-visual.index', ['tab' => 'iklan'])->with('success', 'Banner berhasil diperbarui!');
    }

    public function bannerClear(string $posisi)
    {
        if (!array_key_exists($posisi, BannerIklan::POSITIONS)) abort(404);
        $banner = BannerIklan::where('posisi', $posisi)->first();
        if ($banner) {
            if ($banner->gambar_path) Storage::disk('public')->delete($banner->gambar_path);
            $banner->delete();
        }
        return redirect()->route('dashboard.media-visual.index', ['tab' => 'iklan'])->with('success', 'Banner berhasil dihapus!');
    }
}
