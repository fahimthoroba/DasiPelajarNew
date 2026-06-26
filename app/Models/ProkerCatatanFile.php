<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProkerCatatanFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_kerja_id',
        'file_path',
        'keterangan',
        'uploaded_by',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
