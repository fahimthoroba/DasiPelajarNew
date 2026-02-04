<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departemen;
use App\Models\User;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat',
        'departemen_id',
        'tujuan',
        'perihal',
        'tgl_surat',
        'file_arsip',
        'pembuat_id',
    ];

    protected $casts = [
        'tgl_surat' => 'date',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }
}
