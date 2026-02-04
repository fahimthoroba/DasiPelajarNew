<?php

namespace App\Http\Controllers;

use App\Models\PengaturanWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PengaturanWebAdminController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanWeb::firstOrCreate([], ['nama_website' => 'DasiPelajar']);
        return view('dashboard.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        Log::info('Settings Update Request:', $request->all());
        $pengaturan = PengaturanWeb::first();

        $validated = $request->validate([
            'nama_website' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'header_news_title' => 'nullable|string',
            'header_news_desc' => 'nullable|string',
            'email' => 'nullable|email',
            'no_wa' => 'nullable|string',
            'alamat' => 'nullable|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($pengaturan->logo_path) {
                Storage::disk('public')->delete($pengaturan->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('settings', 'public');
        }

        $pengaturan->update($validated);

        return redirect()->route('dashboard.pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
