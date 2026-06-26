<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeKepengurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisasi_id',
        'jenis_organisasi',
        'periode_ke',
        'tgl_mulai',
        'tgl_selesai',
        'is_active',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_active' => 'boolean',
    ];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    public function getPeriodeRomawiAttribute(): string
    {
        return \App\Services\RomawiHelper::convert($this->periode_ke);
    }
}
