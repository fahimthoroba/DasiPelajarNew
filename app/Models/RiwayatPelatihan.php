<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelatihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kader_id',
        'nama_pelatihan',
        'jenis',
        'penyelenggara',
        'tahun',
        'lokasi',
        'nomor_sertifikat',
    ];

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }
}
