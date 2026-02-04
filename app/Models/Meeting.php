<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['program_kerja_id', 'nama_rapat', 'tgl_rapat', 'notulensi_path'];

    protected $casts = [
        'tgl_rapat' => 'datetime',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }
}
