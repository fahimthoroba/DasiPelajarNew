<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory, \App\Traits\HasCustomId;

    public function getPrefix()
    {
        return 'dep';
    }

    protected $fillable = [
        'id',
        'nama_departemen',
    ];
}
