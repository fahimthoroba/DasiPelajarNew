<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpjRevision extends Model
{
    protected $fillable = [
        'program_kerja_id', 'revision_number', 'file_path',
        'submitted_by', 'submitted_at', 'status',
        'reviewed_by', 'reviewed_at', 'catatan',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class, 'program_kerja_id');
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
