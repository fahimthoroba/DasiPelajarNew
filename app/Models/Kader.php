<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kader extends Model
{
    use HasFactory, \App\Traits\HasCustomId;

    public function getPrefix()
    {
        return 'kdr';
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('pengurus_cabang');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('pengurus_cabang');
        });
    }

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'foto_path',
        'tempat_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat_jalan',
        'dusun',
        'desa',
        'kecamatan',
        'kabupaten',
        'no_hp',
        'quote',
    ];

    public function pengurus()
    {
        return $this->hasOne(Pengurus::class)->latest(); // Default to latest if accessed as single
    }

    public function listPengurus()
    {
        return $this->hasMany(Pengurus::class);
    }

    public function riwayatPelatihans()
    {
        return $this->hasMany(RiwayatPelatihan::class);
    }
}
