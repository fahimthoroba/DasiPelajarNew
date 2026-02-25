<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\SuratKeputusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeputusanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $sks = SuratKeputusan::with('organisasi')
            ->when($user->role === 'pac' || $user->role === 'pr' || $user->role === 'pk', function($query) use ($user) {
                // PAC hanya bisa melihat SK organisasinya sendiri
                $query->where('organisasi_id', $user->organisasi_id);
            })
            ->orderBy('tgl_berlaku', 'desc')
            ->get();
            
        return view('dashboard.sekretariat.sk.index', compact('sks'));
    }

    public function create()
    {
        return view('dashboard.sekretariat.sk.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Inject organisasi_id to request databag for validation purpose
        if (in_array($user->role, ['pac', 'pr', 'pk'])) {
            $request->merge(['organisasi_id' => $user->organisasi_id]);
        }
        
        $request->validate([
            'organisasi_id' => 'required|exists:organisasis,id',
            'nomor_sk' => 'required|string|unique:surat_keputusans,nomor_sk',
            'judul_sk' => 'required|string',
            'tgl_berlaku' => 'required|date',
            'tgl_selesai' => 'required|date|after:tgl_berlaku',
            'file_sk' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file_sk')) {
            $path = $request->file('file_sk')->store('public/sk');
        }

        $status = 'Aktif'; // Default untuk Admin/PC
        
        // Jika yang submit adalah PAC, status awalnya Draft/Menunggu Pengesahan PC
        if (in_array($user->role, ['pac', 'pr', 'pk'])) {
            $status = 'Menunggu Pengesahan PC';
        }

        SuratKeputusan::create([
            'organisasi_id' => $request->organisasi_id,
            'nomor_sk' => $request->nomor_sk,
            'judul_sk' => $request->judul_sk,
            'tgl_berlaku' => $request->tgl_berlaku,
            'tgl_selesai' => $request->tgl_selesai,
            'status' => $status,
            'file_sk_path' => $path,
        ]);

        return back()->with('success', 'Surat Keputusan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $sk = SuratKeputusan::findOrFail($id);

        if ($sk->file_sk_path) {
            Storage::delete($sk->file_sk_path);
        }

        $sk->delete();
        return back()->with('success', 'Data SK dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Draft,Menunggu Pengesahan PC,Aktif,Demisioner,Ditolak',
        ]);

        $sk = SuratKeputusan::findOrFail($id);
        
        // Keamanan: Hanya Admin/PC yang bisa set ke Aktif/Ditolak
        $user = auth()->user();
        if (in_array($request->status, ['Aktif', 'Ditolak']) && !in_array($user->role, ['admin', 'pc'])) {
            abort(403, 'Unauthorized action.');
        }

        $sk->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status SK diperbarui menjadi ' . $request->status);
    }
}
