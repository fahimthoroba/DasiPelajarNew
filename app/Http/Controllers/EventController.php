<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramKerja;
use App\Models\Pendaftaran;
use App\Models\Kader;

class EventController extends Controller
{
    public function show($token)
    {
        $proker = ProgramKerja::where('registration_link_token', $token)
            ->where('is_public_registration', true)
            ->firstOrFail();

        return view('public.event.register', compact('proker'));
    }

    public function checkNia(Request $request)
    {
        $request->validate(['nia' => 'required|string']);

        $kader = Kader::where('nia', $request->nia)->first();

        if ($kader) {
            return response()->json([
                'found' => true,
                'data' => $kader
            ]);
        }

        return response()->json(['found' => false]);
    }

    public function store(Request $request, $token)
    {
        $proker = ProgramKerja::where('registration_link_token', $token)->firstOrFail();

        $request->validate([
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            // Add other validations
        ]);

        $kader = null;
        if ($request->filled('nia')) {
            $kader = Kader::where('nia', $request->nia)->first();
        }

        Pendaftaran::create([
            'program_kerja_id' => $proker->id,
            'kader_id' => $kader ? $kader->id : null,
            'nia' => $request->nia, // Can be null or input
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status' => $kader ? 'verified' : 'pending', // Auto-verify if known kader, else pending
            'tipe_daftar' => 'umum', // Or check logic
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Terima kasih.');
    }
}
