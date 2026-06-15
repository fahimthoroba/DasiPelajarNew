<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepanitiaan extends Model
{
    use HasFactory, \App\Traits\HasCustomId;

    public function getPrefix(): string
    {
        return 'pan';
    }

    protected $fillable = ['program_kerja_id', 'kader_id', 'jabatan'];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }
}
