<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BannerIklan extends Model {
    protected $fillable = ['posisi', 'gambar_path', 'link_url', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    const POSITIONS = [
        'leaderboard_berita' => [
            'nama'   => 'Leaderboard Berita',
            'ukuran' => '728x90',
            'lokasi' => 'Portal berita, di atas konten utama (setelah hero slider)',
            'icon'   => 'horizontal_rule',
        ],
        'between_categories' => [
            'nama'   => 'Antara Kategori',
            'ukuran' => '728x70',
            'lokasi' => 'Portal berita, antara setiap 2 kategori berita',
            'icon'   => 'view_stream',
        ],
        'sidebar_berita' => [
            'nama'   => 'Sidebar Kanan Berita',
            'ukuran' => '300x250',
            'lokasi' => 'Portal berita, sidebar kanan halaman',
            'icon'   => 'view_sidebar',
        ],
    ];
}
