<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeputusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_sk',
        'judul_sk',
        'tgl_berlaku',
        'tgl_selesai',
        'file_sk_path',
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
}
