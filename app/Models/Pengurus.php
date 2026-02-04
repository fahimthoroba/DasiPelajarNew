<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengurus extends Model
{
    use HasFactory, \App\Traits\HasCustomId;

    public function getPrefix()
    {
        return 'pgr';
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

    protected $table = 'pengurus';

    protected $fillable = [
        'kader_id',
        'parent_id',
        'surat_keputusan_id',
        'tingkatan',
        'nama_tingkatan',
        'jabatan',
        'departemen',
        'urutan_tampil',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Pengurus::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Pengurus::class, 'parent_id');
    }

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }

    public function sk()
    {
        return $this->belongsTo(SuratKeputusan::class, 'surat_keputusan_id');
    }

    public function departemenData()
    {
        return $this->belongsTo(Departemen::class, 'departemen', 'id');
    }

    // Accessors
    public function getJabatanLengkapAttribute()
    {
        $j = $this->jabatan;
        $d = $this->departemenData->nama_departemen ?? '';

        // List of titles that need suffixes
        $targets = ['Wakil Ketua', 'Wakil Sekretaris', 'Wakil Bendahara', 'Direktur', 'Komandan'];

        if (Str::contains($j, $targets) && $d) {
            // Check if suffix already exists to avoid double suffix
            if (!Str::contains($j, $d)) {
                return $j . ' ' . $d;
            }
        }

        return $j;
    }
}
