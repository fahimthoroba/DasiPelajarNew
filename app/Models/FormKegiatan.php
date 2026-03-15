<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormKegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'organisasi_id',
        'slug',
        'is_open',
        'tgl_buka',
        'tgl_tutup',
        'custom_fields',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'tgl_buka' => 'datetime',
        'tgl_tutup' => 'datetime',
        'custom_fields' => 'array',
    ];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }

    public function peserta()
    {
        return $this->hasMany(PesertaKegiatan::class, 'form_kegiatan_id');
    }
}
