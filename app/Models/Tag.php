<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['nama', 'slug'];

    public function beritas()
    {
        return $this->belongsToMany(Berita::class, 'berita_tag');
    }
}
