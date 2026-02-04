<?php

namespace App\Http\Controllers;

use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderAdminController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::orderBy('urutan')->get();
        return view('dashboard.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('dashboard.slider.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_utama' => 'nullable|max:255',
            'sub_judul' => 'nullable',
            'gambar_path' => 'required|image|max:2048', // Max 2MB
            'link_tombol' => 'nullable|url',
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar_path')) {
            $validated['gambar_path'] = $request->file('gambar_path')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['urutan'] = $validated['urutan'] ?? 0;

        HeroSlider::create($validated);

        return redirect()->route('dashboard.slider.index')->with('success', 'Slider berhasil ditambahkan!');
    }

    public function edit(HeroSlider $slider)
    {
        return view('dashboard.slider.edit', compact('slider'));
    }

    public function update(Request $request, HeroSlider $slider)
    {
        $validated = $request->validate([
            'judul_utama' => 'nullable|max:255',
            'sub_judul' => 'nullable',
            'label' => 'nullable|max:255',
            'gambar_path' => 'nullable|image|max:2048',
            'link_tombol' => 'nullable|url',
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar_path')) {
            if ($slider->gambar_path) {
                Storage::disk('public')->delete($slider->gambar_path);
            }
            $validated['gambar_path'] = $request->file('gambar_path')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $slider->update($validated);

        return redirect()->route('dashboard.slider.index')->with('success', 'Slider berhasil diperbarui!');
    }

    public function destroy(HeroSlider $slider)
    {
        if ($slider->gambar_path) {
            Storage::disk('public')->delete($slider->gambar_path);
        }
        $slider->delete();

        return redirect()->route('dashboard.slider.index')->with('success', 'Slider berhasil dihapus!');
    }
}
