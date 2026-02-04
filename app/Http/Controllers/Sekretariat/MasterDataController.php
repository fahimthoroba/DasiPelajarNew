<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        return view('dashboard.sekretariat.master-data.index');
    }
}
