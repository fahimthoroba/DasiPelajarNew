<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat',
        'pengirim',
        'perihal',
        'tgl_surat',
        'tgl_diterima',
        'file_scan',
        'disposisi',
    ];

    protected $casts = [
        'tgl_surat' => 'date',
        'tgl_diterima' => 'date',
    ];
}
