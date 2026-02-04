<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_utama',
        'sub_judul',
        'label',
        'gambar_path',
        'link_tombol',
        'teks_tombol',
        'show_button',
        'is_active',
        'urutan',
    ];
}
