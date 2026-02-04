<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    use HasFactory, \App\Traits\HasCustomId;

    public function getPrefix()
    {
        return 'proker'; // Format: proker001
    }

    protected $fillable = [
        'nama_proker',
        'deskripsi_kegiatan',
        'departemen_id',
        'tgl_pelaksanaan',
        'penanggung_jawab',
        'path_lpj',
        'status_lpj',
        'status_pelaksanaan',
    ];

    protected $casts = [
        'tgl_pelaksanaan' => 'date',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id');
    }

    public function kepanitiaans()
    {
        return $this->hasMany(Kepanitiaan::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class)->orderBy('tgl_waktu');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
