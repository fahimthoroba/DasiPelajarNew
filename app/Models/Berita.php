<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_berita_id',
        'user_id',
        'judul',
        'slug',
        'thumbnail',
        'konten',
        'status',
        'tgl_publish',
        'views',
    ];

    public function kategoriBerita()
    {
        return $this->belongsTo(KategoriBerita::class);
    }

    /**
     * Alias for kategoriBerita to make code cleaner
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_berita_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
