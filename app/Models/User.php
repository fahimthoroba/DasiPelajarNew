<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, \App\Traits\HasCustomId;

    public function getPrefix()
    {
        return 'use';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kader_id',
        'organisasi_id',
    ];

    public function kader()
    {
        return $this->belongsTo(Kader::class, 'kader_id', 'id');
    }

    public function organisasi()
    {
        return $this->belongsTo(\App\Models\Organisasi::class, 'organisasi_id', 'id');
    }

    public function getActiveOrganisasiId()
    {
        // For generic PAC accounts (e.g., admin_pac@ipnu.org), they might not have a kader_id but have explicitly assigned organisasi_id
        if ($this->organisasi_id) return $this->organisasi_id;

        // Otherwise, base it on their active pengurus profile
        if (!$this->kader_id) return null;

        $pengurus = \App\Models\Pengurus::where('kader_id', $this->kader_id)
            ->where('is_active', true)
            ->first();

        return $pengurus ? $pengurus->organisasi_id : null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
