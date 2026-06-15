<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Kader;
// use App\Models\Inventaris; // Assuming model exists or to be created

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $deptRoles = [
            'dep_organisasi', 'dep_kaderisasi', 'dep_dakwah', 'dep_seni', 'dep_jaringan',
            'dep_pengorg', 'dep_media',
            'lmb_lpp', 'lmb_lekas', 'lmb_lan', 'lmb_lkpt', 'lmb_cbp',
            'bdn_bscc', 'bdn_bsrc',
            'lmb_kpp', 'lmb_konseling', 'lmb_ekraf', 'lmb_kdc',
            'departemen', // alias sementara
        ];
        if (in_array($user->role, $deptRoles)) {
            return redirect()->route('dashboard.departemen.index');
        }

        $stats = [];

        if ($user->role === 'sekretaris' || $user->role === 'admin') {
            $stats['surat_masuk'] = SuratMasuk::count();
            $stats['surat_keluar'] = SuratKeluar::count();
            $stats['kader'] = Kader::count();
            $stats['inventaris'] = \Illuminate\Support\Facades\DB::table('inventaris')->count(); // Use Query Builder if model not ready
        }

        // Pers Stats
        if ($user->role === 'pers' || $user->role === 'admin') {
            $stats['berita'] = \App\Models\Berita::count();
        }

        return view('dashboard.index', compact('user', 'stats'));
    }
}
