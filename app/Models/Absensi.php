<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory, \App\Traits\HasCustomId;

    public function getPrefix()
    {
        return 'abs';
    }

    protected $fillable = [
        'judul',
        'jenis',
        'deskripsi',
        'tgl_waktu',
        'lokasi',
        'departemen_id',
        'organisasi_id',
        'kode_akses',
        'status',
        'closed_at',
        'notulensi_path',
        'created_by',
        'program_kerja_id',
    ];

    protected $casts = [
        'tgl_waktu' => 'datetime',
        'closed_at' => 'datetime',
    ];

    // --- Constants ---

    const JENIS_LABELS = [
        'rapat_rutin'       => 'Rapat Rutin',
        'rapat_departemen'  => 'Rapat Departemen',
        'rapat_panitia'     => 'Rapat Panitia',
        'pelaksanaan'       => 'Pelaksanaan Kegiatan',
        'rapat_pac'         => 'Rapat PAC',
        'rapat_lembaga'     => 'Rapat Lembaga',
        'rapat_badan'       => 'Rapat Badan',
    ];

    // --- Relationships ---

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function records()
    {
        return $this->hasMany(AbsensiRecord::class);
    }

    // --- Scopes ---

    public function scopeOpen($query)
    {
        return $query->where('status', 'buka');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'tutup');
    }

    // --- Helpers ---

    public function isOpen(): bool
    {
        return $this->status === 'buka';
    }

    public function close(): void
    {
        $this->update([
            'status' => 'tutup',
            'closed_at' => now(),
        ]);
    }

    public function getJenisLabelAttribute(): string
    {
        return self::JENIS_LABELS[$this->jenis] ?? $this->jenis;
    }

    public function getTotalHadirAttribute(): int
    {
        return $this->records()->where('status_kehadiran', 'hadir')->count();
    }
}
