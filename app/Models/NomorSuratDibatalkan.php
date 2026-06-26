<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NomorSuratDibatalkan extends Model
{
    use HasFactory;

    protected $table = 'nomor_surat_dibatalkan';

    protected $fillable = [
        'counter_id',
        'counter_type',
        'nomor',
        'dibatalkan_at',
        'dibatalkan_by',
        'alasan',
        'sudah_dipakai_ulang',
    ];

    protected $casts = [
        'dibatalkan_at' => 'datetime',
        'sudah_dipakai_ulang' => 'boolean',
    ];

    public function counter(): MorphTo
    {
        return $this->morphTo();
    }

    public function dibatalkanOleh()
    {
        return $this->belongsTo(User::class, 'dibatalkan_by');
    }
}
