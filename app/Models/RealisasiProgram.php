<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiProgram extends Model
{
    protected $table = 'realisasi_program';

    protected $fillable = [
        'pac_id',
        'kategori_program_id',
        'departemen_id',
        'nama_lokal',
        'tgl_mulai',
        'tgl_selesai',
        'status',
        'is_fix',
        'target_peserta',
        'deskripsi'
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_fix' => 'boolean',
        'target_peserta' => 'array', // Auto cast JSON ke Array
    ];

    public function pac()
    {
        return $this->belongsTo(User::class, 'pac_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriProgram::class, 'kategori_program_id');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id');
    }
}
