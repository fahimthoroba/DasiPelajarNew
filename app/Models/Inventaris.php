<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris'; // Since 'inventaris' is singular/plural ambiguous, Laravel might default correctly but explicit is safer. Actually plural of inventaris is inventaris. Migration used 'inventaris'.

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'kondisi',
        'tgl_pengadaan',
        'sumber_dana',
        'lokasi',
        'foto_barang',
    ];

    protected $casts = [
        'tgl_pengadaan' => 'date',
    ];
}
