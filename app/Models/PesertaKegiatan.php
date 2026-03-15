<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaKegiatan extends Model
{
    protected $fillable = [
        'form_kegiatan_id',
        'user_id',
        'nama_lengkap',
        'jenis_kelamin',
        'no_wa',
        'asal_instansi',
        'custom_answers',
        'status',
    ];

    protected $casts = [
        'custom_answers' => 'array',
    ];

    public function formKegiatan()
    {
        return $this->belongsTo(FormKegiatan::class, 'form_kegiatan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
