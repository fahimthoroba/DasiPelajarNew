<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProgram extends Model
{
    protected $table = 'kategori_program';

    protected $guarded = ['id'];

    protected $casts = [
        'status_verifikasi' => 'boolean',
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            // Normalisasi nama kategori (Title Case)
            $model->nama_kategori = \Illuminate\Support\Str::title(trim($model->nama_kategori));

            // Auto create slug
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->nama_kategori);
            }
        });
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id');
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_pac_id', 'id');
    }
}
