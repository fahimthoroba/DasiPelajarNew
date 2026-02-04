<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepanitiaan extends Model
{
    use HasFactory;

    protected $fillable = ['program_kerja_id', 'kader_id', 'nama_manual', 'jabatan'];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }
}
