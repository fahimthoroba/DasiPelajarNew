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
        'deskripsi',
        'id_kategori_baru'
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'is_fix' => 'boolean',
        'target_peserta' => 'array', // Auto cast JSON ke Array
    ];

    public static function booted()
    {
        static::saving(function ($model) {
            if ($model->kategori_program_id) {
                $cat = \App\Models\KategoriProgram::find($model->kategori_program_id);
                if ($cat) {
                    $name = strtolower($cat->nama_kategori);
                    if (str_contains($name, 'kader') || str_contains($name, 'sdm')) $model->id_kategori_baru = 1;
                    elseif (str_contains($name, 'organisasi') || str_contains($name, 'admin') || str_contains($name, 'rapat') || str_contains($name, 'evaluasi')) $model->id_kategori_baru = 2;
                    elseif (str_contains($name, 'agama') || str_contains($name, 'dakwah') || str_contains($name, 'sosial') || str_contains($name, 'ramadhan') || str_contains($name, 'shalawat')) $model->id_kategori_baru = 3;
                    elseif (str_contains($name, 'bakat') || str_contains($name, 'seni') || str_contains($name, 'olahraga') || str_contains($name, 'lomba')) $model->id_kategori_baru = 4;
                    elseif (str_contains($name, 'peringatan') || str_contains($name, 'apresiasi') || str_contains($name, 'harlah') || str_contains($name, 'hut')) $model->id_kategori_baru = 5;
                }
            }
        });
    }

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
