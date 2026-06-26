<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorSuratKepanitiaanCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_kerja_id',
        'jenis_organisasi',
        'nomor_terakhir',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }
}
