<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorSuratCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisasi_id',
        'jenis_organisasi',
        'periode_kepengurusan_id',
        'nomor_terakhir',
    ];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    public function periodeKepengurusan()
    {
        return $this->belongsTo(PeriodeKepengurusan::class);
    }
}
