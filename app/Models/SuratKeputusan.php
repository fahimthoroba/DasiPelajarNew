<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeputusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisasi_id',
        'nomor_sk',
        'judul_sk',
        'tgl_berlaku',
        'tgl_selesai',
        'status', 
        'file_sk_path',
    ];

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
}
