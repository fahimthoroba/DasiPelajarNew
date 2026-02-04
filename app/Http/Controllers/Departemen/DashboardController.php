<?php

namespace App\Http\Controllers\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramKerja;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $deptId = Auth::user()->departemen_id;

        $stats = [
            'total' => ProgramKerja::where('departemen_id', $deptId)->count(),
            'perencanaan' => ProgramKerja::where('departemen_id', $deptId)->where('status_pelaksanaan', 'Perencanaan')->count(),
            'persiapan' => ProgramKerja::where('departemen_id', $deptId)->where('status_pelaksanaan', 'Persiapan')->count(),
            'pelaksanaan' => ProgramKerja::where('departemen_id', $deptId)->where('status_pelaksanaan', 'Pelaksanaan')->count(),
            'selesai' => ProgramKerja::where('departemen_id', $deptId)->where('status_pelaksanaan', 'Selesai')->count(),
        ];

        return view('dashboard.departemen.index', compact('stats'));
    }
}
