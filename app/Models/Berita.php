<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_berita_id',
        'jenis',
        'user_id',
        'judul',
        'slug',
        'thumbnail',
        'konten',
        'ringkasan',
        'status',
        'is_headline',
        'tgl_publish',
        'views',
        'sumber',
    ];

    protected $casts = [
        'is_headline' => 'boolean',
        'tgl_publish' => 'date',
    ];

    public function kategoriBerita()
    {
        return $this->belongsTo(KategoriBerita::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_berita_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'berita_tag');
    }

    public function komentars()
    {
        return $this->hasMany(KomentarBerita::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }

    public function scopeHeadline($query)
    {
        return $query->where('is_headline', true);
    }

    public function getRingkasanOrExcerptAttribute(): string
    {
        if ($this->ringkasan) {
            return $this->ringkasan;
        }
        return \Illuminate\Support\Str::limit(strip_tags($this->konten), 160, '...');
    }
}
