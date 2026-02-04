<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_kerja_id',
        'kader_id',
        'nia',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'status',
        'tipe_daftar'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function kader()
    {
        return $this->belongsTo(Kader::class);
    }
}
