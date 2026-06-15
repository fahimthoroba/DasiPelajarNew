<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'absensi_id',
        'kader_id',
        'nama_peserta',
        'tipe_peserta',
        'status_kehadiran',
        'metode',
        'waktu_hadir',
        'keterangan',
        'bukti_foto',
    ];

    protected $casts = [
        'waktu_hadir' => 'datetime',
    ];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class);
    }

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }

    /**
     * Get display name — kader name or manual name
     */
    public function getNamaAttribute(): string
    {
        if ($this->kader) {
            return $this->kader->nama_lengkap;
        }

        return $this->nama_peserta ?? 'Tanpa Nama';
    }
}
