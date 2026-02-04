<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanWeb extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_website',
        'deskripsi_singkat',
        'profil_singkat',
        'visi',
        'misi',
        'logo_path',
        'email',
        'no_wa',
        'alamat',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'header_news_title',
        'header_news_desc',
    ];
}
