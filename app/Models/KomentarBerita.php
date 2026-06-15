<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarBerita extends Model
{
    protected $fillable = ['berita_id', 'nama', 'email', 'konten', 'is_approved', 'parent_id'];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    public function parent()
    {
        return $this->belongsTo(KomentarBerita::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(KomentarBerita::class, 'parent_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }
}
