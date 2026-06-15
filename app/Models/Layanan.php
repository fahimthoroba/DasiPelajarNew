<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Layanan extends Model
{
    use HasCustomId;

    protected $fillable = [
        'judul',
        'deskripsi',
        'kategori',
        'file_path',
        'ukuran_file',
        'jumlah_download',
        'is_active',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'jumlah_download'  => 'integer',
    ];

    public function getPrefix()
    {
        return 'lay';
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}
