<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tingkat',
        'parent_id',
        'alamat_sekretariat',
        'zona_wilayah',
        'nomor_sp',
        'masa_khidmat_mulai',
        'masa_khidmat_selesai',
    ];

    public function parent()
    {
        return $this->belongsTo(Organisasi::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Organisasi::class, 'parent_id');
    }

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class, 'organisasi_id');
    }

    public function realisasiPrograms()
    {
        return $this->hasMany(RealisasiProgram::class, 'organisasi_id');
    }
}
