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
        'departemen_id',
        // Profil PAC
        'alamat_sekretariat',
        'zona_wilayah',
        'nomor_sp',
        'masa_khidmat_mulai',
        'masa_khidmat_selesai',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'departemen_id', 'id');
    }

    public function realisasiPrograms()
    {
        return $this->hasMany(RealisasiProgram::class, 'pac_id', 'id');
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
