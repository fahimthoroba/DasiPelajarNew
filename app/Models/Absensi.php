<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory, \App\Traits\HasCustomId;

    public function getPrefix()
    {
        return 'abs';
    }

    protected $fillable = [
        'judul',
        'jenis',
        'deskripsi',
        'tgl_waktu',
        'lokasi',
        'departemen_id',
        'kode_akses',
        'status',
        'notulensi_path',
        'created_by',
        'program_kerja_id',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function records()
    {
        return $this->hasMany(AbsensiRecord::class);
    }

    protected $casts = [
        'tgl_waktu' => 'datetime',
    ];
}
